<?php

namespace App\Http\Controllers;

use App\Mail\ETicketMail;
use App\Models\Registration;
use App\Services\MakeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Str;
use Midtrans\Config;

class PaymentController extends Controller
{
    protected MakeService $makeService;

    public function __construct(MakeService $makeService)
    {
        $this->makeService = $makeService;
    }

    public function showPayment($orderId)
    {
        $registration = Registration::where('order_id', $orderId)->firstOrFail();

        // PENGAMANAN: Jika status masih pending, pastikan session browser ini yang membuat order tersebut
        if (strtolower($registration->payment_status) === 'pending' && session('pending_order_id') !== $orderId) {
            return redirect('/register')->with('error', 'Akses ditolak. Sesi pembayaran tidak valid atau Anda menggunakan perangkat/browser yang berbeda.');
        }

        $midtransEnabled = config('services.midtrans.enabled');

        $validStatuses = ['pending', 'paid', 'approved', 'settled', 'success'];
        if (!in_array(strtolower($registration->payment_status), $validStatuses)) {
            session()->forget('pending_order_id');
            return redirect('/register')->with('error', 'Transaksi sudah kedaluwarsa atau dibatalkan. Silakan daftar ulang.');
        }

        return view('registration.payment', compact('registration', 'midtransEnabled'));
    }

    public function handleNotification(Request $request): JsonResponse
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            $grossAmount        = number_format((float) $request->gross_amount, 2, '.', '');
            $transactionStatus  = $request->transaction_status;
            $orderId            = $request->order_id;
            $statusCode         = $request->status_code;
            $signatureKey       = $request->signature_key;

            $serverKey = config('services.midtrans.server_key');
            $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $calculatedSignature) {
                Log::warning("Midtrans Webhook: Invalid signature key for Order ID {$orderId}");
                return response()->json(['message' => 'Invalid signature key'], 403);
            }

            $registrationToSend = null;

            DB::transaction(function () use ($orderId, $transactionStatus, &$registrationToSend) {
                $registration = Registration::where('order_id', $orderId)->lockForUpdate()->first();

                if (!$registration) {
                    throw new \Exception('Registration not found');
                }

                if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                    if ($registration->payment_status !== 'paid') {
                        
                        $genderPrefix = ($registration->gender ?? 'L') === 'L' ? 'M' : 'F';
                        
                        $latestSequence = Registration::where('bib_number', 'LIKE', $genderPrefix . '10%')
                            ->lockForUpdate()
                            ->selectRaw("MAX(CAST(SUBSTRING(bib_number, 4) AS UNSIGNED)) as max_seq")
                            ->value('max_seq');

                        $nextSequence = str_pad(($latestSequence ? $latestSequence + 1 : 1), 3, '0', STR_PAD_LEFT);
                        $bibNumber = $genderPrefix . '10' . $nextSequence;

                        $registration->update([
                            'payment_status' => 'paid',
                            'bib_number'     => $bibNumber, 
                            'paid_at'        => now(),
                        ]);
                        
                        $registrationToSend = $registration;
                        Log::info("Payment SUCCESS (Settlement) for Order ID: {$orderId} with BIB: {$bibNumber}");
                    }
                } else if ($transactionStatus == 'pending') {
                    Log::info("Payment PENDING for Order ID: {$orderId}");
                } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $registration->update([
                        'payment_status' => 'cancelled',
                    ]);
                    Log::info("Payment CANCELLED/EXPIRED for Order ID: {$orderId}");
                }
            });

            // Kirim E-Ticket via Laravel khusus transaksi Midtrans
            if ($registrationToSend) {
                try {
                    $this->makeService->sendRunnerData($registrationToSend);
                } catch (\Exception $makeError) {
                    Log::error("Failed sending data to Make.com for {$orderId}: " . $makeError->getMessage());
                }

                try {
                    Mail::to($registrationToSend->email)->send(new ETicketMail($registrationToSend));
                    Log::info("E-Ticket Email sent successfully to: {$registrationToSend->email}");
                } catch (\Exception $emailError) {
                    Log::error("Failed sending E-Ticket to {$registrationToSend->email}: " . $emailError->getMessage());
                }
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Notification processed successfully',
            ], 200);

        } catch (\Exception $e) {
            Log::error("Midtrans Webhook Error: " . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to process notification: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function processManualPayment(Request $request, $orderId)
    {
        $registration = Registration::where('order_id', $orderId)->firstOrFail();

        if (strtolower($registration->payment_status) !== 'pending') {
            $msg = 'Transaksi sudah tidak aktif atau telah diproses.';
            return $request->ajax() 
                ? response()->json(['message' => $msg], 422) 
                : back()->with('error', $msg);
        }

        if (!empty($registration->payment_proof)) {
            $msg = 'Bukti pembayaran sudah pernah dikirim dan sedang diverifikasi.';
            return $request->ajax() 
                ? response()->json(['message' => $msg], 422) 
                : back()->with('error', $msg);
        }

        $request->validate([
            'payment_proof' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_proof.required' => 'Wajib upload bukti bayar.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
            'payment_proof.max'      => 'Ukuran file maksimal 2MB.'
        ]);

        $file = $request->file('payment_proof');

        if (!@getimagesize($file->getPathname())) {
            $msg = 'File gambar tidak valid atau rusak.';
            return $request->ajax() 
                ? response()->json(['message' => $msg], 422) 
                : back()->with('error', $msg);
        }

        $extension = $file->guessExtension() ?? 'jpg';
        $fileName  = 'proof_' . Str::random(40) . '.' . $extension;
        $path      = $file->storeAs('payment_proofs', $fileName, 'public');

        $registration->update([
            'payment_proof'  => $path,
            'payment_status' => 'pending', 
        ]);

        $webhookUrl = config('services.make.webhook_url');
        if ($webhookUrl) {
            $payload = $registration->toArray(); 
            $payload['payment_proof_url'] = asset('storage/' . $path);
            $payload['payment_status']    = 'PENDING';

            try {
                Http::post($webhookUrl, $payload);
            } catch (\Exception $e) {
                Log::error("Webhook Manual Payment Gagal: " . $e->getMessage());
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Bukti transfer berhasil dikirim!'
            ], 200);
        }

        return redirect('/')->with('success', 'Bukti transfer berhasil dikirim! Tunggu panitia memverifikasi.');
    }

    public function updateManualStatus(Request $request): JsonResponse
    {
        $secretToken = $request->header('X-Webhook-Secret');
        $expectedSecret = config('services.make.webhook_secret');

        if (!$secretToken || $secretToken !== $expectedSecret) {
            Log::warning("Unauthorized Webhook Make.com attempt on Order ID: " . $request->order_id);
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized Access: Invalid or missing webhook secret header.'
            ], 401);
        }

        $request->validate([
            'order_id' => 'required|string',
            'status'   => 'required|string',
        ]);

        try {
            $responseData = DB::transaction(function () use ($request) {
                $registration = Registration::where('order_id', $request->order_id)
                    ->lockForUpdate()
                    ->first();

                if (!$registration) {
                    throw new \Exception('Registration not found');
                }

                $newStatus = match (strtolower($request->status)) {
                    'approved', 'paid', 'settled' => 'paid',
                    'rejected', 'cancelled'      => 'cancelled',
                    default                      => 'pending',
                };

                $bibNumber = $registration->bib_number;
                $isNewlyPaid = ($newStatus === 'paid' && $registration->payment_status !== 'paid');

                if ($isNewlyPaid && empty($bibNumber)) {
                    $genderPrefix = ($registration->gender ?? 'L') === 'L' ? 'M' : 'F';
                    
                    $latestSequence = Registration::where('bib_number', 'LIKE', $genderPrefix . '10%')
                        ->lockForUpdate()
                        ->selectRaw("MAX(CAST(SUBSTRING(bib_number, 4) AS UNSIGNED)) as max_seq")
                        ->value('max_seq');

                    $nextSequence = str_pad(($latestSequence ? $latestSequence + 1 : 1), 3, '0', STR_PAD_LEFT);
                    $bibNumber = $genderPrefix . '10' . $nextSequence;
                }

                $registration->update([
                    'payment_status' => $newStatus,
                    'bib_number'     => $bibNumber,
                    'paid_at'        => $newStatus === 'paid' ? now() : null,
                ]);

                Log::info("Webhook Make.com: Status Order {$request->order_id} diubah ke {$newStatus} dengan BIB {$bibNumber}");

                return [
                    'order_id'   => $registration->order_id,
                    'bib_number' => $bibNumber,
                    'status'     => $newStatus,
                    'full_name'  => $registration->full_name,
                    'email'      => $registration->email,
                ];
            });

            // Kirim balik data BIB ke Make.com
            return response()->json([
                'status'  => 'success',
                'message' => 'Status updated successfully',
                'data'    => $responseData,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() === 'Registration not found' ? 'Registration not found' : 'Failed to update status',
            ], $e->getMessage() === 'Registration not found' ? 404 : 500);
        }
    }

    public function cancelAndEdit($orderId)
    {
        $registration = Registration::where('order_id', $orderId)
            ->where('payment_status', 'pending')
            ->first();

        if (!$registration) {
            return redirect('/register')->with('error', 'Data pendaftaran tidak ditemukan atau sudah diproses.');
        }

        session()->forget('pending_order_id');

        return redirect('/register?edit=' . $orderId)->with([
            'old_data' => $registration->toArray(),
            'info' => 'Silakan perbaiki data pendaftaran kamu.'
        ]);
    }
}
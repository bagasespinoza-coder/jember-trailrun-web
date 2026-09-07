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
use Illuminate\Support\Facades\Storage;
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

        if (session('pending_order_id') !== $orderId) {
            abort(403, 'Akses ditolak');
        }

        // UBAH INI: Kalau session-nya nggak cocok, langsung banting ke 403 Forbidden
        if (strtolower($registration->payment_status) === 'pending' && session('pending_order_id') !== $orderId) {
            abort(403, 'Akses ditolak');
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
            $fraudStatus        = $request->fraud_status;
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

            DB::transaction(function () use ($orderId, $transactionStatus, $fraudStatus, &$registrationToSend) {
                $registration = Registration::where('order_id', $orderId)->lockForUpdate()->first();

                if (!$registration) {
                    throw new \Exception('Registration not found');
                }

                $isPaid = false;
                if ($transactionStatus == 'capture') {
                    if ($fraudStatus == 'accept') {
                        $isPaid = true;
                    }
                } else if ($transactionStatus == 'settlement') {
                    $isPaid = true;
                }

                if ($isPaid) {
                    if ($registration->payment_status !== 'paid') {
                        $bibNumber = $registration->bib_number ?: $this->generateBibNumber($registration);

                        $registration->update([
                            'payment_status' => 'paid',
                            'bib_number'     => $bibNumber, 
                            'paid_at'        => now(),
                        ]);
                        
                        $registrationToSend = $registration;
                        Log::info("Payment SUCCESS (Settlement/Capture) for Order ID: {$orderId} with BIB: {$bibNumber}");
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

    public function processManualPayment(Request $request, $orderId = null)
    {
        // Ambil order_id dari URL atau dari body request (form hidden input)
        $targetOrderId = $orderId ?? $request->input('order_id');

        if (session('pending_order_id') !== $targetOrderId) {
            $msg = 'Akses ditolak.';
            return $request->expectsJson() 
                ? response()->json(['message' => $msg], 403) 
                : back()->with('error', $msg);
        }

        $registration = Registration::where('order_id', $targetOrderId)->firstOrFail();

        if (strtolower($registration->payment_status) !== 'pending') {
            $msg = 'Transaksi sudah tidak aktif atau telah diproses.';
            return $request->expectsJson() 
                ? response()->json(['message' => $msg], 422) 
                : back()->with('error', $msg);
        }

        if (!empty($registration->payment_proof)) {
            $msg = 'Bukti pembayaran sudah pernah dikirim dan sedang diverifikasi.';
            return $request->expectsJson() 
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
            return $request->expectsJson() 
                ? response()->json(['message' => $msg], 422) 
                : back()->with('error', $msg);
        }

        $extension = $file->guessExtension() ?? 'jpg';
        $fileName  = 'proof_' . Str::random(40) . '.' . $extension;
        $path = $file->storeAs('payment_proofs', $fileName, 'public');

        try {
            $registration->update([
                'payment_proof'  => $path,
                'payment_status' => 'pending', 
            ]);
            
            session()->forget('pending_order_id');

        } catch (\Exception $e) {
            Storage::disk('public')->delete($path);
            Log::error("Gagal simpan bukti bayar ke DB untuk Order ID {$targetOrderId}: " . $e->getMessage());

            $msg = 'Terjadi kesalahan sistem saat menyimpan bukti bayar.';
            return $request->expectsJson() 
                ? response()->json(['message' => $msg], 500) 
                : back()->with('error', $msg);
        }

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

        if ($request->expectsJson()) {
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

        if (!$secretToken || !hash_equals($expectedSecret, $secretToken)) {
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

                if ($newStatus === 'paid' && empty($bibNumber)) {
                    $bibNumber = $this->generateBibNumber($registration);
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

    public function editDataRegist(Request $request, $orderId)
    {
        if (session('pending_order_id') !== $orderId) {
            abort(403, 'Akses ditolak.');
        }

        $registration = Registration::where('order_id', $orderId)
            ->where('payment_status', 'pending')
            ->first();

        if (!$registration) {
            return redirect('/register')->with('error', 'Data pendaftaran tidak ditemukan atau sudah diproses.');
        }

        return redirect('/register?edit=' . $orderId)->with([
            'old_data' => $registration->toArray(),
            'info'     => 'Silakan perbaiki data pendaftaran kamu.'
        ]);
    }

    public function cancelOrder(Request $request, $orderId): JsonResponse
    {
        if (session('pending_order_id') !== $orderId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $registration = Registration::where('order_id', $orderId)
            ->where('payment_status', 'pending')
            ->first();

        if ($registration) {
            // Cukup ubah status jadi cancelled biar history datanya gak ilang
            $registration->update(['payment_status' => 'cancelled']);
        }

        // Bersihkan sesi terkait
        session()->forget('pending_order_id');
        session()->forget('edit_draft');

        return response()->json([
            'status'       => 'success',
            'message'      => 'Pendaftaran berhasil dibatalkan.',
            'redirect_url' => url('/') 
        ]);
    }

    private function generateBibNumber(Registration $registration): string
    {
        return DB::transaction(function () use ($registration) {
            $genderPrefix = ($registration->gender ?? 'L') === 'L' ? 'M' : 'F';
            
            // Mengunci seluruh baris data pendaftaran berstatus 'paid' untuk mencegah pembacaan berbarengan
            $latestSequence = Registration::whereNotNull('bib_number')
                ->where('bib_number', 'LIKE', $genderPrefix . '10%')
                ->lockForUpdate()
                ->selectRaw("MAX(CAST(SUBSTRING(bib_number, 4) AS UNSIGNED)) as max_seq")
                ->value('max_seq');

            $nextSequence = str_pad(($latestSequence ? $latestSequence + 1 : 1), 3, '0', STR_PAD_LEFT);

            return $genderPrefix . '10' . $nextSequence;
        });
    }
}
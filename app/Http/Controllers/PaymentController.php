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
        $midtransEnabled = config('services.midtrans.enabled');

        $validStatuses = ['pending', 'paid', 'approved', 'settled', 'success'];
        if (!in_array(strtolower($registration->payment_status), $validStatuses)) {
            return redirect('/register')->with('error', 'Transaksi sudah kedaluwarsa atau dibatalkan. Silakan daftar ulang.');
        }

        if ($midtransEnabled && $registration->payment_status === 'pending' && empty($registration->snap_token)) {
            return redirect('/')->with('error', 'Gagal memuat token pembayaran otomatis. Silakan coba lagi.');
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

            DB::transaction(function () use ($orderId, $transactionStatus) {
                $registration = Registration::where('order_id', $orderId)->lockForUpdate()->first();

                if (!$registration) {
                    throw new \Exception('Registration not found');
                }

                if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                    if ($registration->payment_status !== 'paid') {
                        $registration->update([
                            'payment_status' => 'paid',
                            'paid_at'        => now(),
                        ]);
                        Log::info("Payment SUCCESS (Settlement) for Order ID: {$orderId}");

                        try {
                            $this->makeService->sendRunnerData($registration);
                        } catch (\Exception $makeError) {
                            Log::error("Failed sending data to Make.com for {$orderId}: " . $makeError->getMessage());
                        }

                        try {
                            Mail::to($registration->email)->send(new ETicketMail($registration));
                            Log::info("E-Ticket Email sent successfully to: {$registration->email}");
                        } catch (\Exception $emailError) {
                            Log::error("Failed sending E-Ticket to {$registration->email}: " . $emailError->getMessage());
                        }
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

    public function showManualPayment($orderId)
    {
        $registration = Registration::where('order_id', $orderId)->firstOrFail();

        if (in_array(strtolower($registration->payment_status), ['paid', 'approved', 'settled', 'success'])) {
            return redirect('/')->with('success', 'Transaksi ini sudah lunas.');
        }

        // PERBAIKAN: Hanya passing variable $registration yang valid
        return view('payment', compact('registration'));
    }

    public function processManualPayment(Request $request, $orderId)
    {
        $registration = Registration::where('order_id', $orderId)->firstOrFail();

        // 1. Cek Status & Bukti Transfer Ganda (Anti Overwrite)
        if (strtolower($registration->payment_status) !== 'pending') {
            return back()->with('error', 'Transaksi sudah tidak aktif atau telah diproses.');
        }

        if (!empty($registration->payment_proof)) {
            return back()->with('error', 'Bukti pembayaran sudah pernah dikirim dan sedang diverifikasi.');
        }

        // 2. Validasi Server-Side Ketat
        $request->validate([
            'payment_proof' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_proof.required' => 'Wajib upload bukti bayar.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
            'payment_proof.max'      => 'Ukuran file maksimal 2MB.'
        ]);

        $file = $request->file('payment_proof');

        // Validation MimeType Riil
        if (!@getimagesize($file->getPathname())) {
            return back()->with('error', 'File gambar tidak valid atau rusak.');
        }

        // 3. Simpan dengan Nama Acak 40 Karakter (Anti Web Shell)
        $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('payment_proofs', $fileName, 'public');

        // 4. Update Database
        $registration->update([
            'payment_proof'  => $path,
            'payment_status' => 'pending', 
        ]);

        // 5. Tembak ke Webhook Make.com
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

        return redirect('/')->with('success', 'Bukti transfer berhasil dikirim! Tunggu panitia memverifikasi.');
    }

    public function updateManualStatus(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|string',
            'status'   => 'required|string',
        ]);

        $registration = Registration::where('order_id', $request->order_id)->first();

        if (!$registration) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Registration not found'
            ], 404);
        }

        // Mapping status dari Make.com (approved/rejected) ke enum database lu
        $newStatus = match (strtolower($request->status)) {
            'approved', 'paid' => 'paid',
            'rejected', 'cancelled' => 'cancelled',
            default => 'pending',
        };

        $registration->update([
            'payment_status' => $newStatus,
            'paid_at'        => $newStatus === 'paid' ? now() : null,
        ]);

        Log::info("Webhook Make.com: Status Order {$request->order_id} berhasil diubah jadi {$newStatus}");

        return response()->json([
            'status'  => 'success',
            'message' => 'Status updated successfully'
        ], 200);
    }
}
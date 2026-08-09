<?php

namespace App\Http\Controllers;

use App\Mail\ETicketMail;
use App\Models\Registration;
use App\Services\MakeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    protected MakeService $makeService;

    public function __construct(MakeService $makeService)
    {
        $this->makeService = $makeService; 
    }

    /**
     * Tampilkan Halaman Pembayaran (Embed QRIS)
     */
    public function showPayment($orderId)
    {
        $registration = Registration::where('order_id', $orderId)->first();

        if (!$registration || $registration->payment_status !== 'pending') {
            return redirect('/')->with('error', 'Transaksi tidak ditemukan atau sudah dibayar.');
        }

        return view('registration.payment', compact('registration'));
    }

    /**
     * Webhook Callback Handler untuk Midtrans
     */
    public function handleNotification(Request $request): JsonResponse
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notif = new Notification();

            $transactionStatus = $notif->transaction_status;
            $orderId           = $notif->order_id;
            $statusCode        = $notif->status_code;
            $grossAmount       = $notif->gross_amount;
            $signatureKey      = $notif->signature_key;

            // 1. Verifikasi Signature Key (Security Check)
            $serverKey           = config('midtrans.server_key');
            $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $calculatedSignature) {
                Log::warning("Midtrans Webhook: Invalid signature key for Order ID {$orderId}");
                return response()->json(['message' => 'Invalid signature key'], 403);
            }

            // 2. Cari Data Peserta di Database
            $registration = Registration::where('order_id', $orderId)->first();

            if (!$registration) {
                return response()->json(['message' => 'Registration not found'], 404);
            }

            // 3. Update Status Pembayaran & Trigger Otomatisasi
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                if ($registration->payment_status !== 'paid') {
                    $registration->update([
                        'payment_status' => 'paid',
                        'paid_at'        => now(),
                    ]);
                    Log::info("Payment SUCCESS (Settlement) for Order ID: {$orderId}");

                    // A. Kirim Data ke Make.com -> Google Sheets
                    $this->makeService->sendRunnerData($registration);

                    // B. Kirim Email E-Ticket via Brevo SMTP
                    try {
                        Mail::to($registration->email)->send(new ETicketMail($registration));
                        Log::info("E-Ticket Email sent successfully to: {$registration->email}");
                    } catch (\Exception $emailError) {
                        Log::error("Failed sending E-Ticket to {$registration->email}: " . $emailError->getMessage());
                    }
                }
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $registration->update([
                    'payment_status' => 'cancelled',
                ]);
                Log::info("Payment CANCELLED/EXPIRED for Order ID: {$orderId}");
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
}
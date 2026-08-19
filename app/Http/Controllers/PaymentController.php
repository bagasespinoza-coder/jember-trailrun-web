<?php

namespace App\Http\Controllers;

use App\Mail\ETicketMail;
use App\Models\Registration;
use App\Services\MakeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; // 🔥 TAMBAHAN UNTUK LOCK DATABASE
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    protected MakeService $makeService;

    public function __construct(MakeService $makeService)
    {
        $this->makeService = $makeService; 
    }

    public function showPayment($orderId)
    {
        $registration = Registration::where('order_id', $orderId)->first();

        if (!$registration || empty($registration->snap_token)) {
            return redirect('/')->with('error', 'Sistem pembayaran sedang sibuk atau data tidak ditemukan.');
        }

        if ($registration->payment_status === 'paid') {
            return view('registration.payment', compact('registration')); 
        }

        if ($registration->payment_status !== 'pending') {
            return redirect('/register')->with('error', 'Transaksi sudah kedaluwarsa atau dibatalkan. Silakan daftar ulang.');
        }

        return view('registration.payment', compact('registration'));
    }

    public function handleNotification(Request $request): JsonResponse
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $transactionStatus = $request->transaction_status;
            $orderId           = $request->order_id;
            $statusCode        = $request->status_code;
            $grossAmount       = $request->gross_amount;
            $signatureKey      = $request->signature_key;

            $serverKey           = config('midtrans.server_key');
            $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $calculatedSignature) {
                Log::warning("Midtrans Webhook: Invalid signature key for Order ID {$orderId}");
                return response()->json(['message' => 'Invalid signature key'], 403);
            }

            DB::transaction(function () use ($orderId, $transactionStatus) {
                
                // Kunci baris data ini selama proses berlangsung
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
                    Log::info("Payment PENDING (Menunggu Transfer) for Order ID: {$orderId}");

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

    public function verifyStatus($orderId)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        $registration = Registration::where('order_id', $orderId)->first();

        if (!$registration) {
            return response()->json(['status' => 'not_found'], 404);
        }

        if ($registration->payment_status === 'paid') {
            return response()->json(['status' => 'paid']);
        }

        try {
            // Cek langsung ke API Midtrans
            $status = \Midtrans\Transaction::status($orderId);
            
            if (in_array($status->transaction_status, ['settlement', 'capture'])) {
                $registration->update([
                    'payment_status' => 'paid',
                    'paid_at'        => now(),
                ]);

                // Kirim data ke Make.com & Email E-Ticket secara instan
                try {
                    $this->makeService->sendRunnerData($registration);
                    Mail::to($registration->email)->send(new ETicketMail($registration));
                } catch (\Exception $e) {
                    Log::error("Failed sending data/email on verify: " . $e->getMessage());
                }

                return response()->json(['status' => 'paid']);
            }
        } catch (\Exception $e) {
            Log::error("Midtrans API Check Error: " . $e->getMessage());
        }

        return response()->json(['status' => $registration->payment_status]);
    }
}
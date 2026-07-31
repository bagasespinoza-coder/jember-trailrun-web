<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\MakeService;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    protected MidtransService $midtransService;
    protected MakeService $makeService;

    public function __construct(MidtransService $midtransService, MakeService $makeService)
    {
        $this->midtransService = $midtransService;
        $this->makeService     = $makeService; 
    }

    /**
     * Endpoint Checkout / Generate Snap Token QRIS (165k)
     */
    public function checkout(Request $request): JsonResponse
    {
        if (Registration::isQuotaFull()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Mohon maaf, kuota pendaftaran Jember 10k Trail Run sudah penuh!'
            ], 400);
        }

        $ticketPrice = 165000;

        $validated = $request->validate([
            'full_name'                  => 'required|string|max:255',
            'identity_number'            => 'required|string|unique:registrations,identity_number',
            'gender'                     => 'required|in:L,P',
            'pob'                        => 'required|string|max:255',
            'dob'                        => 'required|date',
            'address'                    => 'required|string',
            'community'                  => 'nullable|string|max:255',
            'whatsapp_number'            => 'required|string|max:20',
            'email'                      => 'required|email|max:255',
            'instagram_handle'           => 'nullable|string|max:255',
            'jersey_size'                => 'required|in:S,M,L,XL,XXL',
            'blood_type'                 => 'nullable|in:A,B,AB,O',
            'medical_history'            => 'nullable|string',
            'emergency_contact_name'     => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'emergency_contact_phone'    => 'required|string|max:20',
        ]);

        $orderId = 'JTR-' . strtoupper(uniqid());

        try {
            $snapToken = $this->midtransService->createSnapToken([
                'order_id'   => $orderId,
                'amount'     => $ticketPrice,
                'user_name'  => $validated['full_name'],
                'user_email' => $validated['email'],
                'user_phone' => $validated['whatsapp_number'],
            ]);

            $registrationData = array_merge($validated, [
                'order_id'       => $orderId,
                'gross_amount'   => $ticketPrice,
                'payment_status' => 'pending',
                'snap_token'     => $snapToken,
            ]);

            $registration = Registration::create($registrationData);

            return response()->json([
                'status'       => 'success',
                'message'      => 'Pendaftaran berhasil dibuat, silakan selesaikan pembayaran.',
                'order_id'     => $orderId,
                'gross_amount' => $ticketPrice,
                'snap_token'   => $snapToken,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
            ], 500);
        }
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

            // 3. Update Status Pembayaran
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                if ($registration->payment_status !== 'paid') {
                    $registration->update([
                        'payment_status' => 'paid',
                        'paid_at'        => now(),
                    ]);
                    Log::info("Payment SUCCESS (Settlement) for Order ID: {$orderId}");

                    $this->makeService->sendRunnerData($registration);
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
<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function store(StoreRegistrationRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        // 1. CEK NIK SAJA (Email Bebas), Filter HANYA pada Status yang Mengunci NIK
        $blockedNik = Registration::where('identity_number', $validated['identity_number'])
            ->whereIn('payment_status', ['pending', 'paid', 'approved', 'settled', 'success'])
            ->latest()
            ->first();

        // 2. JIKA NIK DITEMUKAN DENGAN STATUS TERKUNCI
        if ($blockedNik) {
            $status = strtolower($blockedNik->payment_status);

            // A. Jika masih PENDING
            if ($status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'identity_number' => ['NIK ini masih memiliki transaksi yang PENDING. Silakan selesaikan pembayaran sebelumnya.']
                    ]
                ], 422);
            }

            // B. Jika sudah PAID / APPROVED / SETTLED / SUCCESS
            if (in_array($status, ['paid', 'approved', 'settled', 'success'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'identity_number' => ['NIK ini sudah terdaftar dan pembayarannya telah terverifikasi.']
                    ]
                ], 422);
            }
        }

        // ==========================================
        // PROSES REGISTRASI BARU 
        // (Berlaku untuk NIK Baru ATAU NIK Lama yang Statusnya 'rejected'/'expired'/'cancelled')
        // ==========================================
        $ticketPrice = 192500;
        $orderId = 'JTR-' . strtoupper(Str::random(12));

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

            Registration::create($registrationData);

            return response()->json([
                'success'      => true,
                'status'       => 'success',
                'message'      => 'Pendaftaran sukses, mengalihkan ke pembayaran....',
                'redirect_url' => url('/payment/' . $orderId),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function checkStatus($orderId)
    {
        // Hanya membaca data (Read-Only)
        $registration = Registration::where('order_id', $orderId)
            ->firstOrFail(['payment_status']);

        return response()->json([
            'status'  => strtolower($registration->payment_status),
            'is_paid' => in_array(strtolower($registration->payment_status), ['paid', 'settled', 'approved', 'success'])
        ]);
    }
}
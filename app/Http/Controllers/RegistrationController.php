<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function store(StoreRegistrationRequest $request): JsonResponse
    {
        // 1. Ambil data yang udah Lolos Validation
        $validated = $request->validated();
        
        // 🔥 LOGIKA PENCEGAT (OPSI 1) MULAI DI SINI
        $existingPeserta = Registration::where('email', $validated['email'])
            ->orWhere('identity_number', $validated['identity_number'])
            ->first();

        if ($existingPeserta) {
            // Kalau udah lunas, tolak mentah-mentah
            if (in_array(strtolower($existingPeserta->payment_status), ['paid', 'settled', 'success'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'email' => ['Email atau NIK ini sudah terdaftar dan lunas.'],
                        'identity_number' => ['Email atau NIK ini sudah terdaftar dan lunas.']
                    ]
                ], 422);
            }

            // Kalau masih pending, tendang balik ke link pembayaran aslinya!
            return response()->json([
                'success'      => true,
                'status'       => 'success',
                'message'      => 'Melanjutkan pembayaran sebelumnya...',
                // Pastikan mengarah ke order_id yang lama
                'redirect_url' => url('/payment/' . $existingPeserta->order_id), 
            ], 200);
        }
        // 🔥 LOGIKA PENCEGAT SELESAI

        // ==========================================
        // PROSES NORMAL (BUAT PENDAFTAR BARU)
        // ==========================================
        $ticketPrice = 165000;
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
}
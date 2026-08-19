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
        $validated = $request->validated();
        
        // Cari data berdasarkan NIK ATAU Email yang sudah ada
        $existingPeserta = Registration::where('identity_number', $validated['identity_number'])
            ->orWhere('email', $validated['email'])
            ->latest()
            ->first();

        if ($existingPeserta) {
            // 🔥 LOGIKA BARU: Cek spesifik kolom mana yang duplikat
            $errors = [];
            
            if ($existingPeserta->identity_number === $validated['identity_number']) {
                $errors['identity_number'] = ['NIK ini sudah terdaftar.'];
            }
            if ($existingPeserta->email === $validated['email']) {
                $errors['email'] = ['Email ini sudah terdaftar.'];
            }

            // 1. Tolak kalau statusnya udah lunas
            if (in_array(strtolower($existingPeserta->payment_status), ['paid', 'settled', 'success'])) {
                // Ubah pesannya jadi lebih spesifik kalau udah lunas
                if (isset($errors['identity_number'])) $errors['identity_number'] = ['NIK ini sudah terdaftar dan lunas.'];
                if (isset($errors['email'])) $errors['email'] = ['Email ini sudah terdaftar dan lunas.'];

                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => $errors // Cuma nampilin error di input yang beneran kembar
                ], 422);
            }

            // 2. Cek waktu 15 Menit ATAU statusnya sudah batal/expired
            if ($existingPeserta->created_at->diffInMinutes(now()) >= 15 || in_array($existingPeserta->payment_status, ['cancelled', 'expired'])) {

                $ticketPrice = 192500;
                $orderId = 'JTR-' . strtoupper(uniqid());

                try {
                    $snapToken = $this->midtransService->createSnapToken([
                        'order_id'   => $orderId,
                        'amount'     => $ticketPrice,
                        'user_name'  => $validated['full_name'],
                        'user_email' => $validated['email'],
                        'user_phone' => $validated['whatsapp_number'],
                    ]);

                    $existingPeserta->update(array_merge($validated, [
                        'order_id'       => $orderId,
                        'gross_amount'   => $ticketPrice,
                        'payment_status' => 'pending',
                        'snap_token'     => $snapToken,
                    ]));

                    return response()->json([
                        'success'      => true,
                        'status'       => 'success',
                        'message'      => 'Pendaftaran diperbarui, mengalihkan ke pembayaran....',
                        'redirect_url' => url('/payment/' . $orderId),
                    ], 200);

                } catch (\Exception $e) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Gagal memperbarui transaksi: ' . $e->getMessage(),
                    ], 500);
                }

            } else {
                // Belum 15 menit, lempar balik ke pembayaran yang aktif.
                return response()->json([
                    'success'      => true,
                    'status'       => 'success',
                    'message'      => 'Melanjutkan pembayaran sebelumnya...',
                    'redirect_url' => url('/payment/' . $existingPeserta->order_id), 
                ], 200);
            }
        }

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
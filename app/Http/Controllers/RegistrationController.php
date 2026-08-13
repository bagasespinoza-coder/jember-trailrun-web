<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    protected MidtransService $midtransService;

    // Suntik MidtransService ke sini
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function store(StoreRegistrationRequest $request): JsonResponse
    {
        // 1. Ambil data yang udah Lolos Validation 100% dari "Satpam Form"
        $validated = $request->validated();
        
        $ticketPrice = 165000;
        $orderId = 'JTR-' . strtoupper(uniqid());

        try {
            // 2. Tembak Token Midtrans Dulu
            $snapToken = $this->midtransService->createSnapToken([
                'order_id'   => $orderId,
                'amount'     => $ticketPrice,
                'user_name'  => $validated['full_name'],
                'user_email' => $validated['email'],
                'user_phone' => $validated['whatsapp_number'],
            ]);

            // 3. Gabungkan Data + Token buat disimpen ke Database
            $registrationData = array_merge($validated, [
                'order_id'       => $orderId,
                'gross_amount'   => $ticketPrice,
                'payment_status' => 'pending',
                'snap_token'     => $snapToken,
            ]);

            Registration::create($registrationData);

            // 4. Sukses! Lempar user ke halaman Payment
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
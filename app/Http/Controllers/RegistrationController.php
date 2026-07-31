<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    protected MidtransService $midtransService;

    // Inject Service via Constructor
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function store(StoreRegistrationRequest $request)
    {
        // 1. Cek Kuota Dulu Sebelum Olah Data
        if (Registration::isQuotaFull()) {
            return redirect()->back()->with('error', 'Mohon maaf, kuota pendaftaran Jember 10k Trail Run sudah penuh!');
        }

        // 2. Ambil data yang lolos Validasi Form Request
        $validatedData = $request->validated();

        // 3. Set Fixed Price (Rp 165.000) & Order ID Unik
        $validatedData['order_id'] = 'JTR-' . strtoupper(uniqid());
        $validatedData['gross_amount'] = 165000; // FIX: Lock ke 165k sesuai keputusan stakeholder

        try {
            // 4. Generate Snap Token via Midtrans Service
            $snapToken = $this->midtransService->createSnapToken([
                'order_id'   => $validatedData['order_id'],
                'amount'     => $validatedData['gross_amount'],
                'user_name'  => $validatedData['full_name'],
                'user_email' => $validatedData['email'],
                'user_phone' => $validatedData['whatsapp_number'],
            ]);

            // Masukkan snap token ke array data
            $validatedData['snap_token'] = $snapToken;

            // 5. Simpan ke Database
            $registration = Registration::create($validatedData);

            // Redirect ke halaman instruksi / instruksi pop-up Snap pembayaran
            return redirect()->route('payment.show', $registration->order_id)
                ->with('success', 'Pendaftaran berhasil! Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses token pembayaran: ' . $e->getMessage());
        }
    }
}
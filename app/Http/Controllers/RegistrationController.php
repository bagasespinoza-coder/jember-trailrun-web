<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(StoreRegistrationRequest $request)
    {
        // 1. Ambil data yang udah Lolos Validation 100%
        $validatedData = $request->validated();

        // 2. Generate Order ID unik & Gross Amount (Rp150.000 / harga event)
        $validatedData['order_id'] = 'JTR-' . strtoupper(uniqid());
        $validatedData['gross_amount'] = 150000; 

        // 3. Simpan ke Database
        $registration = Registration::create($validatedData);

        // (Di Sprint 3 nanti: Panggil Midtrans Snap Token di sini)
        // Dummy snap_token for frontend testing (will be replaced in actual Sprint 3)
        $snapToken = 'YOUR_SNAP_TOKEN_HERE';

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil, lanjut ke pembayaran!',
            'snap_token' => $snapToken
        ]);
    }
}

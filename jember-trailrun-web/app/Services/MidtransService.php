<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class MidtransService
{
    /**
     * Generate Snap Token pake Laravel HTTP Client (Bypass SSL)
     */
    public function createSnapToken(array $orderData): string
    {
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');

        // Tentukan URL API Midtrans (Sandbox atau Production)
        $baseUrl = $isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Susun Payload
        $payload = [
            'transaction_details' => [
                'order_id'     => $orderData['order_id'],
                'gross_amount' => (int) $orderData['amount'],
            ],
            'customer_details' => [
                'first_name' => $orderData['user_name'],
                'email'      => $orderData['user_email'],
                'phone'      => $orderData['user_phone'] ?? '',
            ],
            'item_details' => [
                [
                    'id'       => 'JTR-10K-TICKET',
                    'price'    => (int) $orderData['amount'],
                    'quantity' => 1,
                    'name'     => 'Tiket Pendaftaran Jember 10k Trail Run',
                ]
            ],
            'enabled_payments' => [
                'bca_va'
            ],
        ];

        // 🚀 TEMBAK API LANGSUNG (PAKSA TANPA VERIFIKASI SSL)
        $response = Http::withoutVerifying()
            ->withBasicAuth($serverKey, '')
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->post($baseUrl, $payload);

        // Kalau sukses, ambil tokennya
        if ($response->successful()) {
            return $response->json('token');
        }

        // Kalau gagal, lempar pesan eror aslinya
        throw new Exception('Midtrans API Error: ' . $response->body());
    }
}
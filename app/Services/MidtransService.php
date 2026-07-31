<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        // Set konfigurasi Midtrans SDK dari file config/midtrans.php
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap Token untuk Pendaftaran Event
     */
    public function createSnapToken(array $orderData): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderData['order_id'],
                'gross_amount' => (int) $orderData['amount'],
            ],
            'customer_details' => [
                'first_name' => $orderData['user_name'],
                'email' => $orderData['user_email'],
                'phone' => $orderData['user_phone'] ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'JTR-10K-TICKET',
                    'price' => (int) $orderData['amount'],
                    'quantity' => 1,
                    'name' => 'Tiket Pendaftaran Jember 10k Trail Run',
                ]
            ],
            // Opsional: Batasi metode pembayaran kalau cuma mau QRIS / e-Wallet / Bank Transfer tertentu
            'enabled_payments' => [
                'qris'
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
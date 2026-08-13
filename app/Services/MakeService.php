<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // 🚀 WAJIB TAMBAHIN INI BIAR CARBON BISA DIPAKAI

class MakeService
{
    /**
     * Kirim data pelari lunas ke Webhook Make.com
     */
    public function sendRunnerData(Registration $registration): void
    {
        $webhookUrl = config('services.make.webhook_url');

        if (!$webhookUrl) {
            Log::warning("Make.com Webhook URL belum di-set di config/services.php");
            return;
        }

        try {
            // 🚀 LOGIKA NGITUNG UMUR OTOMATIS
            // Kasih fallback angka 0 kalau misal user daftar nggak ngisi tanggal lahir
            $umur = $registration->dob ? Carbon::parse($registration->dob)->age : 0;

            // Request HTTP POST dengan timeout 5 detik & non-blocking
            // (withoutVerifying udah gua hapus karena SSL lu sekarang udah bener)
            $response = Http::timeout(5)->post($webhookUrl, [
                'order_id'                   => $registration->order_id,
                'full_name'                  => $registration->full_name,
                'identity_number'            => $registration->identity_number,
                'gender'                     => $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                'pob'                        => $registration->pob,
                'dob'                        => $registration->dob?->format('Y-m-d'),
                'age'                        => $umur, 
                'community'                  => $registration->community ?? '-',
                'address'                    => $registration->address,
                'whatsapp_number'            => $registration->whatsapp_number,
                'instagram_username'         => $registration->intagram_username ?? '-',
                'email'                      => $registration->email,
                'category'                   => $registration->category,
                'jersey_size'                => $registration->jersey_size,
                'blood_type'                 => $registration->blood_type ?? '-',
                'medical_history'            => $registration->medical_history ?? '-',
                'emergency_contact_name'     => $registration->emergency_contact_name,
                'emergency_contact_relation' => $registration->emergency_contact_relation,
                'emergency_contact_phone'    => $registration->emergency_contact_phone,
                'gross_amount'               => $registration->gross_amount,
                'paid_at'                    => $registration->paid_at?->toDateTimeString(),
            ]);

            if ($response->successful()) {
                Log::info("Automation Make.com SUCCESS for Order ID: {$registration->order_id}");
            } else {
                Log::error("Automation Make.com FAILED: Status {$response->status()} | Body: {$response->body()}");
            }

        } catch (\Exception $e) {
            // Isolasi exception agar tidak mengganggu return HTTP 200 ke Midtrans
            Log::error("Automation Make.com Exception: " . $e->getMessage());
        }
    }
}
<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            // Request HTTP POST dengan timeout 5 detik & non-blocking
            $response = Http::retry(3, 1000)->timeout(5)->post($webhookUrl, [
                'order_id'                   => $registration->order_id,
                'full_name'                  => $registration->full_name,
                
                'bib_name'                   => $registration->bib_name,
                'bib_number'                 => $registration->bib_number,

                'identity_number'            => $registration->identity_number,
                'gender'                     => $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                'pob'                        => $registration->pob,
                'dob'                        => $registration->dob?->format('Y-m-d'),
                'age'                        => $registration->age ?? 0, 
                'community'                  => $registration->community ?? '-',
                'address'                    => $registration->address,
                'whatsapp_number'            => $registration->whatsapp_number,
                'instagram_handle'           => $registration->instagram_handle ?? '-', 
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
            Log::error("Automation Make.com Exception: " . $e->getMessage());
        }
    }
}
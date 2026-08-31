<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

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

        $age = null;
        if (!empty($validated['dob'])) {
            $age = Carbon::parse($validated['dob'])->age;
        }
        
        // 0. CEK KUOTA MAKSIMAL 300 PESERTA
        $totalRegistered = Registration::whereIn('payment_status', ['pending', 'paid', 'approved', 'settled', 'success'])->count();

        if ($totalRegistered >= 300) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => [
                    'general' => ['Mohon maaf, kuota pendaftaran Jember Trail Run 2026 sudah penuh (Maksimal 300 peserta).']
                ]
            ], 422);
        }

        // 1. CEK NIK SAJA (Email Bebas)
        $blockedNik = Registration::where('identity_number', $validated['identity_number'])
            ->whereIn('payment_status', ['pending', 'paid', 'approved', 'settled', 'success'])
            ->latest()
            ->first();

        if ($blockedNik) {
            $status = strtolower($blockedNik->payment_status);

            if ($status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'identity_number' => ['NIK ini masih memiliki transaksi yang PENDING. Silakan selesaikan pembayaran sebelumnya.']
                    ]
                ], 422);
            }

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
        // PROSES REGISTRASI BARU (RACE-CONDITION PROOF)
        // ==========================================
        $ticketPrice = 192500;
        $orderId = 'JTR-' . strtoupper(Str::random(12));

        try {
            $registration = DB::transaction(function () use ($validated, $orderId, $ticketPrice, $age) {
                
                // 2. GENERATE NOMOR BIB AUTOMATIC DENGAN PESSIMISTIC LOCKING
                $genderPrefix = ($validated['gender'] ?? 'L') === 'L' ? 'M' : 'F';
                
                $latestSequence = Registration::where('bib_number', 'LIKE', $genderPrefix . '10%')
                    ->lockForUpdate()
                    ->selectRaw("MAX(CAST(SUBSTRING(bib_number, 4) AS UNSIGNED)) as max_seq")
                    ->value('max_seq');

                $nextSequence = str_pad(($latestSequence ? $latestSequence + 1 : 1), 3, '0', STR_PAD_LEFT);
                $bibNumber = $genderPrefix . '10' . $nextSequence;

                // 3. SET NAMA BIB
                $bibName = !empty($validated['bib_name']) ? $validated['bib_name'] : $validated['full_name'];

                // 4. GENERATE SNAP TOKEN MIDTRANS
                $snapToken = $this->midtransService->createSnapToken([
                    'order_id'   => $orderId,
                    'amount'     => $ticketPrice,
                    'user_name'  => $validated['full_name'],
                    'user_email' => $validated['email'],
                    'user_phone' => $validated['whatsapp_number'],
                ]);

                // 5. SIMPAN KE DATABASE
                $registrationData = array_merge($validated, [
                    'bib_name'       => $bibName,
                    'bib_number'     => null,
                    'order_id'       => $orderId,
                    'gross_amount'   => $ticketPrice,
                    'payment_status' => 'pending',
                    'snap_token'     => $snapToken,
                    'usia'           => $age,
                ]);

                return Registration::create($registrationData);
            });

            return response()->json([
                'success'      => true,
                'status'       => 'success',
                'message'      => 'Pendaftaran sukses, mengalihkan ke pembayaran....',
                'redirect_url' => url('/payment/' . $orderId),
            ], 201);

        } catch (\Exception $e) {
            Log::error("Registration Exception: " . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Sistem pembayaran sedang gangguan atau konfigurasi bermasalah. Mohon coba beberapa saat lagi atau hubungi panitia.'
            ], 500);
        }
    }

    public function checkStatus($orderId): JsonResponse
    {
        $registration = Registration::where('order_id', $orderId)->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success'        => true,
            'order_id'       => $registration->order_id,
            'payment_status' => $registration->payment_status,
            'bib_number'     => in_array($registration->payment_status, ['paid', 'approved', 'settled']) ? $registration->bib_number : null,
            'redirect_url'   => in_array($registration->payment_status, ['paid', 'approved', 'settled']) ? url('/') : null,
        ]);
    }
}
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

    public function index()
    {
        if (session()->has('pending_order_id')) {
            $pendingOrderId = session('pending_order_id');
            $registration = Registration::where('order_id', $pendingOrderId)
                ->where('payment_status', 'pending')
                ->first();

            if ($registration) {
                return redirect('/payment/' . $pendingOrderId)
                    ->with('warning', 'Selesaikan pembayaran kamu terlebih dahulu.');
            } else {
                session()->forget('pending_order_id');
            }
        }

        return view('registration.register');
    }

    public function store(StoreRegistrationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $age = null;
        if (!empty($validated['dob'])) {
            $age = Carbon::parse($validated['dob'])->age;
        }

        $ticketPrice = 192500;
        $orderId = 'JTR-' . strtoupper(Str::random(12));

        try {
            // 1. Generate Snap Token Midtrans DILUAR DB Transaction
            $snapToken = $this->midtransService->createSnapToken([
                'order_id'   => $orderId,
                'amount'     => $ticketPrice,
                'user_name'  => $validated['full_name'],
                'user_email' => $validated['email'],
                'user_phone' => $validated['whatsapp_number'],
            ]);

            // 2. Transaksi DB: Cek NIK + Cek Kuota + Simpan Registrasi
            $registration = DB::transaction(function () use ($validated, $orderId, $ticketPrice, $age, $snapToken) {
                
                // CEK NIK DENGAN LOCK
                $blockedNik = Registration::where('identity_number', $validated['identity_number'])
                    ->whereIn('payment_status', ['pending', 'paid', 'approved', 'settled', 'success'])
                    ->lockForUpdate()
                    ->latest()
                    ->first();

                if ($blockedNik) {
                    $status = strtolower($blockedNik->payment_status);
                    if ($status === 'pending') {
                        throw new \Exception('NIK_PENDING');
                    }
                    if (in_array($status, ['paid', 'approved', 'settled', 'success'])) {
                        throw new \Exception('NIK_PAID');
                    }
                }

                // CEK KUOTA DENGAN LOCK
                $totalRegistered = Registration::whereIn('payment_status', ['pending', 'paid', 'approved', 'settled', 'success'])
                    ->lockForUpdate()
                    ->count();

                if ($totalRegistered >= 300) {
                    throw new \Exception('QUOTA_FULL');
                }

                $bibName = !empty($validated['bib_name']) ? $validated['bib_name'] : $validated['full_name'];

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

            session(['pending_order_id' => $orderId]);

            return response()->json([
                'success'      => true,
                'status'       => 'success',
                'message'      => 'Pendaftaran sukses, mengalihkan ke pembayaran....',
                'redirect_url' => url('/payment/' . $orderId),
            ], 201);

        } catch (\Exception $e) {
            if ($e->getMessage() === 'NIK_PENDING') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'identity_number' => ['NIK ini masih memiliki transaksi yang PENDING. Silakan selesaikan pembayaran sebelumnya.']
                    ]
                ], 422);
            }

            if ($e->getMessage() === 'NIK_PAID') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'identity_number' => ['NIK ini sudah terdaftar dan pembayarannya telah terverifikasi.']
                    ]
                ], 422);
            }

            if ($e->getMessage() === 'QUOTA_FULL') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'general' => ['Mohon maaf, kuota pendaftaran Jember Trail Run 2026 sudah penuh (Maksimal 300 peserta).']
                    ]
                ], 422);
            }

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

        if (in_array(strtolower($registration->payment_status), ['paid', 'approved', 'settled', 'success'])) {
            session()->forget('pending_order_id');
        }

        return response()->json([
            'success'        => true,
            'order_id'       => $registration->order_id,
            'payment_status' => $registration->payment_status,
            'bib_number'     => in_array($registration->payment_status, ['paid', 'approved', 'settled']) ? $registration->bib_number : null,
            'redirect_url' => in_array($registration->payment_status, ['paid', 'approved', 'settled']) ? route('dashboard') : null,
        ]);
    }
}
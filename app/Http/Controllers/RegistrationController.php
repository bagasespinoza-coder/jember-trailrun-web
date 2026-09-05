<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class RegistrationController extends Controller
{
    protected MidtransService $midtransService;

    // Status pembayaran yang aktif dan menyita kuota
    protected array $activeStatuses = ['pending', 'paid', 'approved', 'settled', 'success'];
    
    // Status pembayaran yang sudah lunas/terverifikasi
    protected array $completedStatuses = ['paid', 'approved', 'settled', 'success'];

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        // 1. Cek apakah ada request edit DAN validasinya bawa tiket dari PaymentController
        if ($request->has('edit')) {
            session()->forget('pending_order_id');

            // SATPAM: Pastikan edit_draft cuma keisi kalau user dateng dari tombol edit yang sah
            if (session()->has('old_data')) {
                session(['edit_draft' => session('old_data')]);
            } else {
                // Tendang orang iseng yang cuma ngetik /register?edit= di URL
                return redirect('/register')->with('error', 'Akses edit ditolak! Gunakan tombol edit dari halaman pembayaran.');
            }
        } else {
            // Bersihkan form draft kalau user masuk lewat /register biasa
            session()->forget('edit_draft');
        }

        // 2. Cek apakah ada sesi pembayaran pending lain yang aktif
        if (session()->has('pending_order_id')) {
            $pendingOrderId = session('pending_order_id');
            $pendingRegistration = Registration::where('order_id', $pendingOrderId)
                ->where('payment_status', 'pending')
                ->first();

            if ($pendingRegistration) {
                return redirect('/payment/' . $pendingOrderId)
                    ->with('warning', 'Selesaikan pembayaran kamu terlebih dahulu.');
            }

            session()->forget('pending_order_id');
        }

        return view('registration.register');
    }

    public function store(StoreRegistrationRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $oldOrderId = session('edit_draft.order_id');

        // 1. PRE-CHECK NIK
        $existingNik = Registration::where('identity_number', $validated['identity_number'])
            ->whereIn('payment_status', $this->activeStatuses)
            ->when($oldOrderId, fn($q) => $q->where('order_id', '!=', $oldOrderId))
            ->latest()
            ->first();

        if ($existingNik) {
            $status = strtolower($existingNik->payment_status);
            if ($status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => [
                        'identity_number' => ['NIK ini masih memiliki transaksi yang PENDING. Silakan selesaikan pembayaran sebelumnya.']
                    ]
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => [
                    'identity_number' => ['NIK ini sudah terdaftar dan pembayarannya telah terverifikasi.']
                ]
            ], 422);
        }

        // 2. PRE-CHECK KUOTA (Exclude old draft if editing)
        $currentCount = Registration::whereIn('payment_status', $this->activeStatuses)
            ->when($oldOrderId, fn($q) => $q->where('order_id', '!=', $oldOrderId)) 
            ->count();

        if ($currentCount >= 300) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => [
                    'quota' => ['Mohon maaf, kuota pendaftaran Jember Trail Run 2026 sudah penuh (Maksimal 300 peserta).']
                ]
            ], 422);
        }

        $age = !empty($validated['dob']) ? Carbon::parse($validated['dob'])->age : null;
        $basePrice = 190000;
        
        // Cek metode pembayaran yang dipilih user dari form
        $paymentMethod = $request->input('payment_method', 'midtrans'); 
        
        // Tentukan admin fee (Midtrans kena 2500, manual 0)
        $adminFee = ($paymentMethod === 'midtrans') ? 2500 : 0;
        $ticketPrice = $basePrice + $adminFee;

        $orderId = 'JTR-' . strtoupper(Str::random(12));

        try {
            $snapToken = null;
            
            // CEK STATUS MIDTRANS: Hanya generate Snap Token jika Midtrans di-ENABLE
            if (config('services.midtrans.enabled')) {
                $snapToken = $this->midtransService->createSnapToken([
                    'order_id'   => $orderId,
                    'amount'     => $ticketPrice,
                    'user_name'  => $validated['full_name'],
                    'user_email' => $validated['email'],
                    'user_phone' => $validated['whatsapp_number'],
                ]);
            }

            // 3. DB Transaction
            $registration = DB::transaction(function () use ($validated, $orderId, $ticketPrice, $age, $snapToken, $oldOrderId) {
                
                // Lock Check NIK
                $blockedNik = Registration::where('identity_number', $validated['identity_number'])
                    ->whereIn('payment_status', $this->activeStatuses)
                    ->when($oldOrderId, fn($q) => $q->where('order_id', '!=', $oldOrderId))
                    ->lockForUpdate()
                    ->latest()
                    ->first();

                if ($blockedNik) {
                    $status = strtolower($blockedNik->payment_status);
                    throw new \Exception($status === 'pending' ? 'NIK_PENDING' : 'NIK_PAID');
                }

                // Lock Check Kuota (SUDAH DIPERBAIKI: Exclude old order ID)
                $totalRegistered = Registration::whereIn('payment_status', $this->activeStatuses)
                    ->when($oldOrderId, fn($q) => $q->where('order_id', '!=', $oldOrderId))
                    ->lockForUpdate()
                    ->count();

                if ($totalRegistered >= 300) {
                    throw new \Exception('QUOTA_FULL');
                }

                if ($oldOrderId) {
                    Registration::where('order_id', $oldOrderId)
                        ->where('payment_status', 'pending')
                        ->update(['payment_status' => 'cancelled']);
                }

                $bibName = !empty($validated['bib_name']) ? $validated['bib_name'] : $validated['full_name'];

                return Registration::create(array_merge($validated, [
                    'bib_name'       => $bibName,
                    'bib_number'     => null,
                    'order_id'       => $orderId,
                    'gross_amount'   => $ticketPrice,
                    'payment_status' => 'pending',
                    'snap_token'     => $snapToken,
                    'usia'           => $age,
                ]));
            });

            session(['pending_order_id' => $orderId]);
            session()->forget('edit_draft');

            return response()->json([
                'success'      => true,
                'status'       => 'success',
                'message'      => 'Pendaftaran sukses, mengalihkan ke pembayaran....',
                'snap_token'   => $snapToken,
                'redirect_url' => url('/payment/' . $orderId),
            ], 201);

        } catch (\Exception $e) {
            // Kalau exception bawa data order_id (format: NIK_PENDING:JTR-XXXXX)
            if (str_starts_with($e->getMessage(), 'NIK_PENDING:')) {
                $orderIdPending = str_replace('NIK_PENDING:', '', $e->getMessage());
                return response()->json([
                    'success'  => false,
                    'status'   => 'pending_exists', // <-- Tambahin status ini buat dibaca JS
                    'order_id' => $orderIdPending,
                    'message'  => 'Validasi gagal',
                    'errors'   => ['identity_number' => ['NIK ini masih memiliki transaksi yang PENDING.']]
                ], 422);
            }

            if ($e->getMessage() === 'NIK_PAID') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => ['identity_number' => ['NIK ini sudah terdaftar dan terverifikasi.']]
                ], 422);
            }

            if ($e->getMessage() === 'QUOTA_FULL') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => ['quota' => ['Mohon maaf, kuota pendaftaran sudah penuh.']]
                ], 422);
            }

            Log::error("Registration Exception: " . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem, mohon coba beberapa saat lagi.'
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

        $isCompleted = in_array(strtolower($registration->payment_status), $this->completedStatuses);

        if ($isCompleted) {
            session()->forget('pending_order_id');
        }

        return response()->json([
            'success'        => true,
            'order_id'       => $registration->order_id,
            'payment_status' => $registration->payment_status,
            'bib_number'     => $isCompleted ? $registration->bib_number : null,
            'redirect_url'   => $isCompleted ? route('dashboard') : null,
        ]);
    }
}
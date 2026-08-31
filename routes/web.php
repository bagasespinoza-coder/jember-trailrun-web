<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;

// 1. Landing & Registration
Route::get('/', function () {
    return view('landing');
});

Route::get('/register', function () {
    return view('registration.register');
})->name('register');

// 🚀 KEAMANAN POIN 3: Pasang Rate Limiter (Max 5x submit per 1 menit per IP)
Route::post('/register', [RegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('register.store');

// 2. Payment Views & Verification (Read-Only)
Route::get('/payment/{orderId}', [PaymentController::class, 'showPayment'])->name('payment.page');
Route::get('/payment/manual/{orderId}', [PaymentController::class, 'showManualPayment'])->name('payment.manual');

// Cek status dipasangi limit 30x/menit biar aman dari brute force enumerasi Order ID
Route::get('/payment/verify/{orderId}', [RegistrationController::class, 'checkStatus'])
    ->middleware('throttle:30,1')
    ->name('payment.verify');

// 3. Process Manual Payment (Dilindungi Rate Limiter: Max 3x submit per menit per IP)
Route::post('/payment/manual/{orderId}', [PaymentController::class, 'processManualPayment'])
    ->middleware('throttle:3,1')
    ->name('payment.manual.process');

// 4. Webhook Callback Midtrans
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])
    ->name('midtrans.notification');

// 5. Webhook Manual Status dari Make.com
Route::post('/api/webhook/manual-status', [PaymentController::class, 'updateManualStatus'])
    ->name('webhook.manual-status');
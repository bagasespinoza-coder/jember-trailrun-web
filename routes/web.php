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

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// 2. Payment Views & Verification (Read-Only)
Route::get('/payment/{orderId}', [PaymentController::class, 'showPayment'])->name('payment.page');
Route::get('/payment/manual/{orderId}', [PaymentController::class, 'showManualPayment'])->name('payment.manual');
Route::get('/payment/verify/{orderId}', [RegistrationController::class, 'checkStatus'])->name('payment.verify');

// 3. Process Manual Payment (Dilindungi Rate Limiter: Max 3x submit per menit per IP)
Route::post('/payment/manual/{orderId}', [PaymentController::class, 'processManualPayment'])
    ->middleware('throttle:3,1')
    ->name('payment.manual.process');

// 4. Webhook Callback Midtrans (Aman jika sudah dikecualikan via bootstrap/app.php di Cara 1)
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification');

// 5. Webhook Manual Status dari Make.com
Route::post('/api/webhook/manual-status', [PaymentController::class, 'updateManualStatus'])
    ->name('webhook.manual-status');
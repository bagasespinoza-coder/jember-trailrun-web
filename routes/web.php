<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// 1. Landing Page & Form Registration
Route::get('/', function () {
    return view('landing');
});

Route::get('/register', function () {
    return view('registration.register');
})->name('register');

Route::post('/register', [PaymentController::class, 'checkout'])->name('register.store');

// 2. Tampilan Halaman Pembayaran & Aksi Terkait
Route::get('/payment', [PaymentController::class, 'showPayment'])->name('payment');
Route::post('/payment/apply-coupon', [PaymentController::class, 'applyCoupon'])->name('payment.apply-coupon');
Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment'])->name('payment.confirm');
Route::get('/payment/status', [PaymentController::class, 'checkStatus'])->name('payment.status');

Route::get('/confirmation', function () {
    return view('registration.confirmation');
})->name('confirmation');

Route::get('/payment-expired', function () {
    return view('registration.payment-expired');
})->name('payment-expired');

Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification');
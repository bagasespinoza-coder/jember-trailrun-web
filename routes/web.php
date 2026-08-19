<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;

// 1. Landing Page & Form Registration
Route::get('/', function () {
    return view('landing');
});

Route::get('/register', function () {
    return view('registration.register');
})->name('register');

// Jalur Pendaftaran (Ditangani oleh Satpam & Resepsionis)
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');


// 2. Tampilan Halaman Pembayaran (Snap Embed Midtrans)
Route::get('/payment/{orderId}', [PaymentController::class, 'showPayment'])->name('payment.page');

// 4. Webhook Callback Midtrans (Jalur Otomatisasi Belakang Layar)
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification');
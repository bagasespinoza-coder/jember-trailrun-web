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

// 2. Tampilan Halaman Status Pembayaran
Route::get('/payment', function () {
    return view('registration.payment');
})->name('payment');

Route::get('/confirmation', function () {
    return view('registration.confirmation');
})->name('confirmation');

Route::get('/payment-expired', function () {
    return view('registration.payment-expired');
})->name('payment-expired');

Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification');
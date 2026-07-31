<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/register', function () {
    return view('registration.register');
})->name('register');

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// 2. Tampilan Halaman Payment & Status (dari GitHub)
Route::get('/payment', function () {
    return view('registration.payment');
})->name('payment');

Route::get('/confirmation', function () {
    return view('registration.confirmation');
})->name('confirmation');

Route::get('/payment-expired', function () {
    return view('registration.payment-expired');
})->name('payment-expired');

// 3. API Checkout & Webhook Callback Midtrans (dari Lokal)
Route::post('/checkout', [PaymentController::class, 'checkout']);
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification']);
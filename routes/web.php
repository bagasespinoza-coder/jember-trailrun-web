<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/register', function () {
    return view('registration.register');
})->name('register');

Route::get('/payment', function () {
    return view('registration.payment');
})->name('payment');

Route::get('/confirmation', function () {
    return view('registration.confirmation');
})->name('confirmation');

Route::get('/payment-expired', function () {
    return view('registration.payment-expired');
})->name('payment-expired');

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
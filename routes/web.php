<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

Route::get('/', function () {
    return view('welcome');
});

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 🚀 IMPORT INI

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🚀 PAKSA SEMUA GENERATE URL JADI HTTPS (AMAN BUAT NGROK)
        if (config('app.env') !== 'local' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }
        
        // Atau kalau mau dipaksa selamanya di lokal pakai ngrok:
        // URL::forceScheme('https');
    }
}

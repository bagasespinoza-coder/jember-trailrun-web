@extends('layouts.clean')

@section('content')
    <main class="py-10 bg-[#E2E2E2] min-h-screen flex items-center justify-center text-[#000C28] px-4">
        <div class="max-w-sm w-full bg-white rounded-xl shadow-sm p-6 text-center border border-gray-100">
            <!-- Icon Berhasil -->
        <div class="relative w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <div class="absolute inset-0 bg-emerald-100 rounded-full animate-ping opacity-25"></div>
                <div class="relative w-16 h-16 bg-gradient-to-tr from-emerald-500 to-green-400 text-white rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                    </svg>
                </div>
            </div>

        <!-- Heading & Deskripsi -->
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#000C28] tracking-tight mb-2">
                Pembayaran Berhasil!
            </h2>
            <p class="text-sm text-gray-600 leading-relaxed max-w-sm mx-auto mb-6">
                Terima kasih! E-ticket Anda telah berhasil diproses dan akan segera dikirimkan ke email Anda dalam beberapa saat.
            </p>
            
            <!-- Tombol Kembali ke Beranda (Opsional agar pengguna tidak terjebak di halaman konfirmasi) -->
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-full bg-[#FD4801] px-5 py-2 text-xs font-semibold uppercase tracking-wider text-white transition duration-300 hover:bg-[#e04000]">
                Kembali ke Beranda
            </a>

            <!-- Webhook dari Midtrans akan handle data sync ke Google Sheets + send email -->
        </div>
    </main>
@endsection
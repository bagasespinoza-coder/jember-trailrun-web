@extends('layouts.clean')

@section('content')
    <main class="py-10 bg-[#E2E2E2] min-h-screen flex items-center justify-center text-[#000C28] px-4">
        <div class="max-w-sm w-full bg-white rounded-xl shadow-sm p-6 text-center border border-gray-100">
            <!-- Icon Berhasil -->
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3.5 border border-green-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
            </div>

            <!-- Heading & Deskripsi -->
            <h2 class="text-base sm:text-lg font-bold text-[#000C28] mb-1.5">Pembayaran Berhasil! ✅</h2>
            <p class="text-xs text-gray-500 leading-relaxed mb-5">E-ticket akan dikirim ke email Anda dalam beberapa saat.</p>
            
            <!-- Tombol Kembali ke Beranda (Opsional agar pengguna tidak terjebak di halaman konfirmasi) -->
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-full bg-[#FD4801] px-5 py-2 text-xs font-semibold uppercase tracking-wider text-white transition duration-300 hover:bg-[#e04000]">
                Kembali ke Beranda
            </a>

            <!-- Webhook dari Midtrans akan handle data sync ke Google Sheets + send email -->
        </div>
    </main>
@endsection
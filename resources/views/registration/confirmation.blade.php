@extends('layouts.app')

@section('content')
    @include('partials.navbar')
    <main class="pt-32 pb-12 bg-[#E2E2E2] min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-[#000C28] mb-2">Pendaftaran Berhasil!</h1>
            <p class="text-gray-600 mb-6">Terima kasih, pembayaran Anda sedang kami verifikasi. Silakan cek email Anda secara berkala.</p>
            <a href="/" class="inline-flex items-center justify-center rounded-full bg-[#fd4801] px-6 py-2.5 text-sm font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105">
                Kembali ke Beranda
            </a>
        </div>
    </main>
    @include('partials.footer')
@endsection

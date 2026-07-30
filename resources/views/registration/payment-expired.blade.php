@extends('layouts.app')

@section('content')
    @include('partials.navbar')
    <main class="pt-32 pb-12 bg-[#E2E2E2] min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-[#000C28] mb-2">Batas Waktu Pembayaran Habis</h1>
            <p class="text-gray-600 mb-6">Maaf, batas waktu pembayaran Anda telah habis. Silakan lakukan pendaftaran ulang untuk mendapatkan kode pembayaran baru.</p>
            <a href="/register" class="inline-flex items-center justify-center rounded-full bg-[#fd4801] px-6 py-2.5 text-sm font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105">
                Daftar Ulang
            </a>
        </div>
    </main>
    @include('partials.footer')
@endsection

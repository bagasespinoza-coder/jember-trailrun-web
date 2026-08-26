@extends('layouts.clean')

@section('content')
    <main class="py-10 bg-[#E2E2E2] min-h-screen flex items-center justify-center text-[#000C28]">
        <div class="max-w-sm w-full bg-white rounded-xl shadow-sm p-6 text-center border border-gray-100">
            <!-- Icon Box -->
            <div class="w-12 h-12 bg-orange-50 text-[#FD4801] rounded-full flex items-center justify-center mx-auto mb-3.5 border border-orange-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                </svg>
            </div>
            
            <!-- Heading & Description -->
            <h1 class="text-base sm:text-lg font-bold text-[#000C28] mb-1.5">Batas Waktu Pembayaran Habis</h1>
            <p class="text-xs text-gray-500 leading-relaxed mb-5">Maaf, batas waktu pembayaran Anda telah habis. Silakan lakukan pendaftaran ulang untuk mendapatkan kode pembayaran baru.</p>
            
            <!-- Action Button -->
            <a href="/register" class="inline-flex items-center justify-center rounded-full bg-[#FD4801] px-5 py-2 text-xs font-semibold uppercase tracking-wider text-white transition duration-300 hover:bg-[#e04000]">
                Daftar Ulang
            </a>
        </div>
    </main>
@endsection
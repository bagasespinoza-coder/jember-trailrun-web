@extends('layouts.app')

@section('content')
<main class="py-6 sm:py-10 bg-[#E2E2E2] min-h-screen text-[#000C28]">
    <div class="mx-auto max-w-2xl px-4 sm:px-6">

        <!-- ================= HEADER HERO CARD ================= -->
        <header class="relative overflow-hidden rounded-3xl p-5 sm:p-6 text-white shadow-2xl mb-6" 
                style="background: radial-gradient(ellipse at top right, #FD3801 0%, #011B63 40%, #000F3B 100%);">
            
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#FD3801]/30 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 space-y-4">
                <div class="flex items-center justify-between">
                    <a href="{{ url('/') }}" 
                        title="Kembali ke Beranda"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/15 transition duration-200 hover:scale-105 shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                        </svg>
                    </a>

                    <div class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10 shadow-sm">
                        <span class="font-sporty font-black italic tracking-wider text-xs uppercase text-white">
                            JEMBER TRAIL <span class="text-[#FD3801]">RUN</span> <span class="text-gray-300">2026</span>
                        </span>
                    </div>
                </div>

                <div class="text-center px-2 pt-1">
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white mb-2">
                        Transfer Bank Manual
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-200 max-w-sm mx-auto font-normal leading-relaxed opacity-85">
                        Selesaikan konfirmasi pembayaran untuk ID Order: <span class="font-mono font-bold text-amber-300">{{ $registration->order_id }}</span>
                    </p>
                </div>

                <!-- Stepper Progress Widget -->
                <div class="bg-black/30 backdrop-blur-md rounded-2xl py-2 px-3.5 max-w-xs mx-auto shadow-xl border border-white/15">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 opacity-80">
                            <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-500/30">
                                ✓
                            </div>
                            <span class="text-xs font-semibold text-gray-200">Data Diri</span>
                        </div>

                        <div class="flex-1 mx-2.5 h-1 bg-gradient-to-r from-emerald-500 to-[#FD3801] rounded-full"></div>

                        <div class="flex items-center gap-2">
                            <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-[#FD3801] text-white font-black text-xs shadow-md shadow-[#FD3801]/40">
                                2
                            </div>
                            <span class="text-xs font-extrabold text-white">Pembayaran</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl p-6 sm:p-8 border border-gray-100">
            
            <!-- Section Info Rekening -->
            <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-200/80 mb-6 text-center">
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-widest mb-1">Nominal Transfer Sesuai Tagihan</p>
                <p class="text-3xl font-black text-[#FD3801] mb-4">Rp{{ number_format($registration->gross_amount, 0, ',', '.') }}</p>
                
                <div class="bg-white border border-gray-200 rounded-xl p-3.5 shadow-2xs max-w-sm mx-auto">
                    <p class="text-xs text-gray-500 mb-1">Transfer ke Rekening BCA:</p>
                    <p class="font-mono font-extrabold text-base text-[#01217C] tracking-wide select-all">1234567890</p>
                    <p class="text-xs font-semibold text-gray-600 mt-0.5">a.n Panitia Jember 10K</p>
                </div>
            </div>

            <!-- Form Upload -->
            <form action="{{ route('payment.manual.process', $registration->order_id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label for="payment_proof" class="block text-xs font-bold text-[#01217C] mb-1.5">
                        Upload Bukti Pembayaran <span class="text-[#FD3801]">*</span>
                    </label>
                    <input type="file" id="payment_proof" name="payment_proof" accept="image/png, image/jpeg, image/jpg" required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-2.5 text-xs text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#FD3801]/10 file:text-[#FD3801] hover:file:bg-[#FD3801]/20 transition cursor-pointer">
                    
                    @error('payment_proof')
                        <p class="text-red-500 text-[10px] font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] text-gray-400 mt-1.5">*Format yang diterima: JPG/PNG, Maksimal: 2MB.</p>
                </div>

                <button type="submit" 
                    class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#01217C] via-[#01217C] to-[#FD3801] text-white font-extrabold text-xs tracking-wide shadow-lg hover:shadow-xl hover:scale-[1.005] active:scale-[0.995] transition duration-200">
                    Kirim Bukti Pembayaran
                </button>
            </form>

        </div>
    </div>
</main>
@endsection
@extends('layouts.app')

@section('content')
    <!-- Midtrans Snap.js -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <!-- Main Content -->
    <main class="py-6 sm:py-10 bg-[#E2E2E2] min-h-screen">
        <div class="mx-auto max-w-2xl px-4" x-data="registrationForm()" x-cloak>

            <!-- ================= HEADER HERO CARD ================= -->
            <header class="relative overflow-hidden rounded-3xl p-5 sm:p-6 text-white shadow-2xl mb-6" 
                    style="background: radial-gradient(ellipse at top right, #FD3801 0%, #011B63 40%, #000F3B 100%);">
                
                <!-- Ambient Glow Overlay -->
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#FD3801]/30 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 space-y-4">
                    <!-- Top Bar: Home CTA (Kiri) & Label Event (Pojok Kanan) -->
                    <div class="flex items-center justify-between">
                        <a href="{{ url('/') }}" 
                            title="Kembali ke Beranda"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/15 transition duration-200 hover:scale-105 shadow-2xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                            </svg>
                        </a>

                        <!-- Event Label (Pojok Kanan, Tanpa Bulatan) -->
                        <div class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10 shadow-sm">
                            <span class="font-sporty font-black italic tracking-wider text-xs uppercase text-white">
                                JEMBER TRAIL <span class="text-[#FD3801]">RUN</span> <span class="text-gray-300">2026</span>
                            </span>
                        </div>
                    </div>

                    <!-- Title & Description Section -->
                    <div class="text-center px-2 pt-1">
                        <!-- Judul Formulir Pendaftaran (Lebih Besar) -->
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white mb-2">
                            Formulir Pendaftaran
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-200 max-w-sm mx-auto font-normal leading-relaxed opacity-85">
                            Lengkapi data diri Anda untuk mengikuti tantangan Trail Run Jember.
                        </p>
                    </div>

                    <!-- Stepper Progress Widget (Glassmorphism Dark) -->
                    <div class="bg-black/30 backdrop-blur-md rounded-2xl py-2 px-3.5 max-w-xs mx-auto shadow-xl border border-white/15">
                        <div class="flex items-center justify-between">
                            <!-- Step 1: Active -->
                            <div class="flex items-center gap-2">
                                <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-[#FD3801] text-white font-black text-xs shadow-md shadow-[#FD3801]/40">
                                    1
                                </div>
                                <span class="text-xs font-extrabold text-white">Data Diri</span>
                            </div>

                            <!-- Step Divider Bar -->
                            <div class="flex-1 mx-2.5 h-1 bg-gradient-to-r from-[#FD3801] to-white/20 rounded-full"></div>

                            <!-- Step 2: Inactive -->
                            <div class="flex items-center gap-2">
                                <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-white/10 border border-white/10 text-gray-300 font-bold text-xs">
                                    2
                                </div>
                                <span class="text-xs font-medium text-gray-300">Pembayaran</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ================= END HEADER ================= -->

            <!-- Alpine.js: General Error Banner -->
            <div x-show="generalError" x-cloak x-transition
                class="mb-5 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <p class="text-sm font-semibold text-red-800" x-text="generalError"></p>
                <button type="button" @click="generalError = ''" class="ml-auto text-red-400 hover:text-red-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Alpine.js: Notification Banner -->
            <div x-show="notification" x-cloak x-transition
                class="mb-5 bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                <p class="text-sm font-semibold text-amber-800" x-text="notification"></p>
                <button type="button" @click="notification = ''" class="ml-auto text-amber-400 hover:text-amber-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Alpine.js: Quota Full Banner -->
            <div x-show="errors.quota" x-cloak x-transition
                class="mb-5 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                <p class="text-sm font-semibold text-red-800" x-text="errors.quota?.[0]"></p>
            </div>

            <!-- Form Section -->
            <form x-ref="form" @submit.prevent="submitForm" novalidate class="space-y-5">

                <!-- Section 1: Data Diri -->
                <section class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 p-5 sm:p-6">
                    <div class="flex items-center gap-3 pb-3 mb-4 border-b border-gray-100">
                        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#FD3801]/10 text-[#FD3801] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-[#FD3801] tracking-tight">Data Diri Peserta</h2>
                            <p class="text-[11px] text-gray-500">Pastikan data sesuai dengan kartu identitas resmi.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="full_name" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Nama Lengkap (Sesuai KTP/Passport) <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="text" id="full_name" name="full_name" placeholder="Masukkan nama lengkap" 
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.full_name }"
                                required>
                            <p x-show="errors.full_name" x-text="errors.full_name?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Nomor Identitas -->
                        <div>
                            <label for="identity_number" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Nomor Identitas (NIK/Passport) <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="text" id="identity_number" name="identity_number" placeholder="3509XXXXXXXXXXXX"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.identity_number }"
                                required>
                            <p x-show="errors.identity_number" x-text="errors.identity_number?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Jenis Kelamin <span class="text-[#FD3801]">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="relative flex items-center justify-center py-2 px-3 rounded-xl border border-gray-200 bg-gray-50/60 cursor-pointer transition hover:border-gray-300 has-[:checked]:border-[#FD3801] has-[:checked]:bg-[#FD3801]/10 has-[:checked]:text-[#FD3801] has-[:checked]:font-bold text-gray-600 text-xs shadow-2xs">
                                    <input type="radio" name="gender" value="L" class="sr-only">
                                    <span>Laki-laki</span>
                                </label>
                                <label class="relative flex items-center justify-center py-2 px-3 rounded-xl border border-gray-200 bg-gray-50/60 cursor-pointer transition hover:border-gray-300 has-[:checked]:border-[#FD3801] has-[:checked]:bg-[#FD3801]/10 has-[:checked]:text-[#FD3801] has-[:checked]:font-bold text-gray-600 text-xs shadow-2xs">
                                    <input type="radio" name="gender" value="P" class="sr-only">
                                    <span>Perempuan</span>
                                </label>
                            </div>
                            <p x-show="errors.gender" x-text="errors.gender?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="pob" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Tempat Lahir <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="text" id="pob" name="pob" placeholder="Contoh: Jember"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.pob }"
                                required>
                            <p x-show="errors.pob" x-text="errors.pob?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="dob" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Tanggal Lahir <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="date" id="dob" name="dob" @change="hitungUmur"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs" required>
                        </div>

                        <!-- Usia -->
                        <div>
                            <label for="usia" class="block text-xs font-bold text-[#01217C] mb-1.5">Usia (Otomatis)</label>
                            <input type="number" id="usia" name="usia" x-model="usia" readonly
                                placeholder="0"
                                class="w-full rounded-xl border border-gray-200 bg-gray-100/80 px-3.5 py-2.5 text-xs font-bold text-[#FD3801] cursor-not-allowed">
                        </div>

                        <!-- Komunitas -->
                        <div class="md:col-span-2">
                            <label for="community" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Komunitas / Klub Lari <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" id="community" name="community" placeholder="e.g., Jember Runners"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.community }">
                            <p x-show="errors.community" x-text="errors.community?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Alamat Domisili <span class="text-[#FD3801]">*</span>
                            </label>
                            <textarea id="address" name="address" placeholder="Masukkan alamat lengkap saat ini" rows="2"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.address }"></textarea>
                            <p x-show="errors.address" x-text="errors.address?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 2: Kontak & Komunikasi -->
                <section class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 p-5 sm:p-6">
                    <div class="flex items-center gap-3 pb-3 mb-4 border-b border-gray-100">
                        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#FD3801]/10 text-[#FD3801] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-[#FD3801] tracking-tight">Kontak & Komunikasi</h2>
                            <p class="text-[11px] text-gray-500">Email dan WhatsApp aktif untuk konfirmasi tiket & informasi event.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nomor WhatsApp -->
                        <div>
                            <label for="whatsapp_number" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Nomor WhatsApp <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="tel" id="whatsapp_number" name="whatsapp_number" placeholder="Contoh: 081234567890"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.whatsapp_number }"
                                required>
                            <p x-show="errors.whatsapp_number" x-text="errors.whatsapp_number?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Alamat Email <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="email" id="email" name="email" autocomplete="off" placeholder="nama@email.com"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.email }"
                                required>
                            <p x-show="errors.email" x-text="errors.email?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Instagram -->
                        <div class="md:col-span-2">
                            <label for="instagram_handle" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Akun Instagram <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" id="instagram_handle" name="instagram_handle" placeholder="@username"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.instagram_handle }">
                            <p x-show="errors.instagram_handle" x-text="errors.instagram_handle?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Detail Race & Kit -->
                <section class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 p-5 sm:p-6">
                    <div class="flex items-center gap-3 pb-3 mb-4 border-b border-gray-100">
                        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#FD3801]/10 text-[#FD3801] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-[#FD3801] tracking-tight">Detail Race & Jersey</h2>
                            <p class="text-[11px] text-gray-500">Pilih ukuran jersey dan nama yang akan dicetak di BIB.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama BIB -->
                        <div>
                            <label for="bib_name" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Nama BIB <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="text" id="bib_name" name="bib_name" placeholder="Masukkan nama untuk BIB"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.bib_name }"
                                required>
                            <p x-show="errors.bib_name" x-text="errors.bib_name?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Race Tee Size -->
                        <div>
                            <label class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Ukuran Jersey (Race Tee) <span class="text-[#FD3801]">*</span>
                            </label>
                            <fieldset class="flex gap-2 flex-wrap">
                                @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="jersey_size" value="{{ $size }}" class="sr-only peer">
                                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-gray-200 bg-gray-50/60 text-xs font-bold text-gray-700 peer-checked:border-[#FD3801] peer-checked:bg-[#FD3801]/10 peer-checked:text-[#FD3801] transition shadow-2xs hover:border-gray-300">{{ $size }}</span>
                                    </label>
                                @endforeach
                            </fieldset>
                            <p x-show="errors.jersey_size" x-text="errors.jersey_size?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 4: Profil Medis & Kontak Darurat -->
                <section class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 p-5 sm:p-6">
                    <div class="flex items-center gap-3 pb-3 mb-4 border-b border-gray-100">
                        <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#FD3801]/10 text-[#FD3801] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-[#FD3801] tracking-tight">Profil Medis & Kontak Darurat</h2>
                            <p class="text-[11px] text-gray-500">Informasi penting untuk penanganan medis darurat saat event.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Golongan Darah -->
                        <div>
                            <label for="blood_type" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Golongan Darah <span class="text-[#FD3801]">*</span>
                            </label>
                            <select id="blood_type" name="blood_type"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.blood_type }"
                                required>
                                <option value="">-- Pilih Golongan Darah --</option>
                                <option value="O">O</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                            </select>
                            <p x-show="errors.blood_type" x-text="errors.blood_type?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Riwayat Medis -->
                        <div>
                            <label for="medical_history" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Riwayat Medis / Alergi <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" id="medical_history" name="medical_history" placeholder="Contoh: Asma, Alergi Obat"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.medical_history }">
                            <p x-show="errors.medical_history" x-text="errors.medical_history?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Nama Kontak Darurat -->
                        <div class="md:col-span-2">
                            <label for="emergency_contact_name" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Nama Kontak Darurat <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name" autocomplete="off" placeholder="Nama lengkap wali / keluarga"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_name }"
                                required>
                            <p x-show="errors.emergency_contact_name" x-text="errors.emergency_contact_name?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Hubungan -->
                        <div>
                            <label for="emergency_contact_relation" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Hubungan <span class="text-[#FD3801]">*</span>
                            </label>
                            <select id="emergency_contact_relation" name="emergency_contact_relation"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_relation }"
                                required>
                                <option value="">-- Pilih Hubungan --</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Saudara Laki-laki">Saudara Laki-laki</option>
                                <option value="Saudara Perempuan">Saudara Perempuan</option>
                                <option value="Suami">Suami</option>
                                <option value="Istri">Istri</option>
                                <option value="Teman">Teman</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <p x-show="errors.emergency_contact_relation" x-text="errors.emergency_contact_relation?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>

                        <!-- Nomor Telepon Darurat -->
                        <div>
                            <label for="emergency_contact_phone" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                Nomor Telepon Darurat <span class="text-[#FD3801]">*</span>
                            </label>
                            <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" placeholder="Contoh: 081122334455"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:border-[#FD3801] focus:ring-2 focus:ring-[#FD3801]/20 transition shadow-2xs"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_phone }"
                                required>
                            <p x-show="errors.emergency_contact_phone" x-text="errors.emergency_contact_phone?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Checkbox Persetujuan -->
                <section class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 p-5 sm:p-6">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="terms" required class="mt-0.5 rounded-md border-gray-300 text-[#FD3801] focus:ring-[#FD3801]/20 w-4 h-4 shrink-0 transition">
                        <span class="text-xs text-gray-600 leading-relaxed">
                            Saya menyatakan bahwa data yang diisi adalah benar, saya dalam kondisi sehat untuk mengikuti acara ini, dan menyetujui seluruh <a href="#" class="text-[#FD3801] underline font-semibold hover:text-[#e03000]">Syarat & Ketentuan</a> yang berlaku.
                        </span>
                    </label>
                    <p x-show="errors.terms" x-text="errors.terms?.[0]" class="mt-1 text-[10px] font-medium text-red-600"></p>
                </section>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" :disabled="loading"
                        class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#01217C] via-[#01217C] to-[#FD3801] text-white font-extrabold text-sm tracking-wide shadow-lg shadow-[#01217C]/20 hover:shadow-xl hover:scale-[1.01] active:scale-[0.99] transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <template x-if="!loading">
                            <span class="flex items-center gap-2">
                                <span>Lanjut ke Pembayaran</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memproses Pendaftaran...</span>
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    function registrationForm() {
        return {
            isSubmitting: false,
            loading: false,
            errors: {},
            generalError: '',
            notification: '',          
            usia: '', 

            init() {
                // Kosongkan atau biarkan kosong jika tidak ada setup lain yang dibutuhkan saat halaman dimuat
            },

            clearDraft() {
                // Dikosongkan agar fungsi pemanggil lain tidak error
            },

            hitungUmur(event) {
                const dob = event.target.value;
                if (!dob) {
                    this.usia = '';
                    return;
                }

                const birthDate = new Date(dob);
                const raceYear = 2026; 
                let calculatedAge = raceYear - birthDate.getFullYear();

                this.usia = calculatedAge > 0 ? calculatedAge : 0;
            },

            buildPayload() {
                const fd = new FormData(this.$refs.form);

                return {
                    full_name:                  fd.get('full_name'),
                    identity_number:            fd.get('identity_number'),
                    gender:                     fd.get('gender'),
                    pob:                        fd.get('pob'),
                    dob:                        fd.get('dob'),
                    usia:                       this.usia,
                    address:                    fd.get('address'),
                    community:                  fd.get('community') || null,
                    whatsapp_number:            fd.get('whatsapp_number'),
                    email:                      fd.get('email'),
                    instagram_handle:           fd.get('instagram_handle') || null,
                    bib_name:                   fd.get('bib_name'),
                    jersey_size:                fd.get('jersey_size'),
                    blood_type:                 fd.get('blood_type'), 
                    medical_history:            fd.get('medical_history') || null,
                    emergency_contact_name:     fd.get('emergency_contact_name'),
                    emergency_contact_relation: fd.get('emergency_contact_relation'),
                    emergency_contact_phone:    fd.get('emergency_contact_phone'),
                };
            },

            clearErrors() {
                this.errors = {};
                this.generalError = '';
            },

            findFirstInvalidField() {
                const errorKeys = Object.keys(this.errors || {});
                if (errorKeys.length > 0) {
                    for (const key of errorKeys) {
                        const field = document.querySelector(`[name="${key}"]`)
                                    || document.querySelector(`[name^="${key}["]`)
                                    || document.querySelector(`[x-ref="${key}"]`);
                        if (field) return field;
                    }
                }
                return document.querySelector('.is-invalid, [aria-invalid="true"], input:invalid, select:invalid, textarea:invalid');
            },

            scrollToFirstError() {
                this.$nextTick(() => {
                    setTimeout(() => {
                        requestAnimationFrame(() => {
                            const field = this.findFirstInvalidField();
                            if (!field) {
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                                return;
                            }

                            field.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });

                            if (typeof field.focus === 'function' && !field.disabled && field.tabIndex !== -1) {
                                try {
                                    field.focus({ preventScroll: true });
                                } catch (e) {
                                    field.focus();
                                }
                            }
                        });
                    }, 50);
                });
            },

            async submitForm() {
                if (this.isSubmitting || this.loading) return;
                this.isSubmitting = true;
                this.loading = true;

                this.clearErrors();
                this.notification = '';

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                    const payload = JSON.stringify(this.buildPayload());

                    const response = await fetch('{{ route("register.store") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: payload
                    });

                    let data;
                    try {
                        data = await response.json();
                    } catch (parseError) {
                        throw new Error('Server mengembalikan respons yang tidak valid.');
                    }

                    // Validation Error (422)
                    if (response.status === 422) {
                        this.errors = data.errors || {};
                        this.scrollToFirstError();
                        return;
                    }

                    // Server Error / Other status
                    if (!response.ok) {
                        this.generalError = data.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        this.$nextTick(() => window.scrollTo({ top: 0, behavior: 'smooth' }));
                        return;
                    }

                    // Handle Midtrans Snap Popup vs Direct Redirect
                    if (data.snap_token && typeof window.snap !== 'undefined') {
                        window.snap.pay(data.snap_token, {
                            onSuccess: (res) => {
                                window.location.href = res.finish_url || data.redirect_url || '/register/success';
                            },
                            onPending: (res) => {
                                window.location.href = res.finish_url || data.redirect_url || '/register/pending';
                            },
                            onError: (res) => {
                                this.generalError = 'Pembayaran gagal. Silakan coba lagi.';
                                this.$nextTick(() => window.scrollTo({ top: 0, behavior: 'smooth' }));
                            },
                            onClose: () => {
                                this.notification = 'Kamu menutup halaman pembayaran sebelum transaksi selesai.';
                            }
                        });
                    } else if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        this.generalError = data.message || 'Gagal memproses pendaftaran. Silakan coba lagi.';
                        this.$nextTick(() => window.scrollTo({ top: 0, behavior: 'smooth' }));
                    }

                } catch (error) {
                    console.error('Registration submission error:', error);
                    this.generalError = error.message || 'Terjadi kesalahan jaringan. Periksa koneksi internet Anda dan coba lagi.';
                    this.$nextTick(() => window.scrollTo({ top: 0, behavior: 'smooth' }));
                } finally {
                    this.isSubmitting = false;
                    this.loading = false;
                }
            }
        };
    }
</script>
@endpush
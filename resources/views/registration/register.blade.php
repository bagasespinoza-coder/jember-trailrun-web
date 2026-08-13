@extends('layouts.app')

@section('content')
    <!-- Midtrans Snap.js -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <!-- Main Content -->
    <main class="py-6 bg-[#E2E2E2] min-h-screen">
        <div class="mx-auto max-w-2xl px-4" x-data="registrationForm()" x-cloak>

            <!-- Header Section: Tombol Kembali & Judul Megah -->
            <div class="mb-5">
                <div class="flex items-center justify-between mb-2">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#FD4801] text-white font-medium text-xs transition duration-300 hover:bg-[#e04000]">
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- Judul & Sub-judul yang Lebih Besar & Mencolok -->
            <div class="text-center">
                    <h1 class="text-xl sm:text-2xl font-bold text-[#000C28] mb-1">Formulir Pendaftaran</h1>
                    <p class="text-xs text-gray-600">Lengkapi data diri Anda untuk mengikuti tantangan Trail Run Jember.</p>
                </div>
            </div>

            <!-- Stepper Section: Paksa Horizontal di HP & Desktop (Hapus arah vertikal) -->
<section class="mb-6">
                <div class="flex items-center justify-center max-w-xs mx-auto">
                    <!-- Step 1: Registration (Active) -->
                    <div class="flex flex-col items-center shrink-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-[#FD4801] text-white font-bold text-xs">
                            1
                        </div>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-[#FD4801] mt-1">Registration</span>
                    </div>

                    <!-- Connector 1 -->
                    <div class="flex-1 flex items-center justify-center px-1.5 mb-4">
                        <div class="h-0.5 w-full bg-gray-300"></div>
                    </div>

                    <!-- Step 2: Payment -->
                    <div class="flex flex-col items-center shrink-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-300 text-gray-400 font-bold text-xs">
                            2
                        </div>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-gray-400 mt-1">Payment</span>
                    </div>

                    <!-- Connector 2 -->
                    <div class="flex-1 flex items-center justify-center px-1.5 mb-4">
                        <div class="h-0.5 w-full bg-gray-300"></div>
                    </div>

                    <!-- Step 3: Confirmation -->
                    <div class="flex flex-col items-center shrink-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-300 text-gray-400 font-bold text-xs">
                            3
                        </div>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-gray-400 mt-1">Confirmation</span>
                    </div>
                </div>
            </section>

            <!-- ============================================================ -->
            <!-- Alpine.js: General Error Banner (server/network errors)      -->
            <!-- ============================================================ -->
            <div x-show="generalError" x-cloak x-transition
                class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
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

            <!-- ============================================================ -->
            <!-- Alpine.js: Notification Banner (payment popup closed, etc.)  -->
            <!-- ============================================================ -->
            <div x-show="notification" x-cloak x-transition
                class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
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

            <!-- ============================================================ -->
            <!-- Alpine.js: Quota Full Banner                                 -->
            <!-- ============================================================ -->
            <div x-show="errors.quota" x-cloak x-transition
                class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                <p class="text-sm font-semibold text-red-800" x-text="errors.quota?.[0]"></p>
            </div>

<!-- Form Section -->
            <form x-ref="form" @submit.prevent="submitForm" novalidate class="space-y-4">

                <!-- Section 1: Data Diri -->
                <section class="bg-white rounded-xl shadow-sm p-4 sm:p-5">
                    <div class="flex items-center gap-2 mb-3.5">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-[#FD4801] text-white font-bold text-[10px]">👤</span>
                        <h2 class="text-sm sm:text-base font-bold text-[#000C28]">Data Diri</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="full_name" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Nama Lengkap (Sesuai KTP/Passport)<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="full_name" name="full_name" placeholder="Masukkan nama lengkap" 
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.full_name }"
                                required>
                            <p x-show="errors.full_name" x-text="errors.full_name?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Nomor Identitas -->
                        <div>
                            <label for="identity_number" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Nomor Identitas (NIK/Passport)<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="identity_number" name="identity_number" placeholder="3509XXXXXXXXXXXX"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.identity_number }"
                                required>
                            <p x-show="errors.identity_number" x-text="errors.identity_number?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">Jenis Kelamin<span class="text-red-500">*</span></label>
                            <fieldset class="flex gap-4 pt-0.5">
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="gender" value="L"
                                        class="w-3.5 h-3.5 text-[#FD4801] focus:ring-1 focus:ring-[#FD4801]">
                                    <span class="text-[11px] sm:text-xs text-gray-700 font-medium">Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="gender" value="P"
                                        class="w-3.5 h-3.5 text-[#FD4801] focus:ring-1 focus:ring-[#FD4801]">
                                    <span class="text-[11px] sm:text-xs text-gray-700 font-medium">Perempuan</span>
                                </label>
                            </fieldset>
                            <p x-show="errors.gender" x-text="errors.gender?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="pob" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Tempat Lahir<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="pob" name="pob" placeholder="Contoh: Jember"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.pob }"
                                required>
                            <p x-show="errors.pob" x-text="errors.pob?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="dob" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">Tanggal Lahir<span class="text-red-500">*</span></label>
                            <input type="date" id="dob" name="dob" @change="hitungUmur"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition" required>
                        </div>

                        <!-- Usia -->
                        <div>
                            <label for="usia" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">Usia</label>
                            <input type="number" id="usia" name="usia" x-model="usia" readonly
                                placeholder="Otomatis terisi"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs bg-gray-100 cursor-not-allowed text-gray-500">
                        </div>

                        <!-- Komunitas -->
                        <div class="md:col-span-2">
                            <label for="community" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Komunitas / Klub Lari (Opsional)
                            </label>
                            <input type="text" id="community" name="community" placeholder="e.g., Jember Runners"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.community }">
                            <p x-show="errors.community" x-text="errors.community?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Alamat Domisili<span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address" placeholder="Masukkan alamat lengkap saat ini" rows="2.5"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.address }"></textarea>
                            <p x-show="errors.address" x-text="errors.address?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 2: Kontak & Komunikasi -->
                <section class="bg-white rounded-xl shadow-sm p-4 sm:p-5">
                    <div class="flex items-center gap-2 mb-3.5">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-[#FD4801] text-white font-bold text-[10px]">📱</span>
                        <h2 class="text-sm sm:text-base font-bold text-[#000C28]">Kontak & Komunikasi</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Nomor WhatsApp -->
                        <div>
                            <label for="whatsapp_number" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Nomor WhatsApp<span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="whatsapp_number" name="whatsapp_number" placeholder="Contoh: 081234567890"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.whatsapp_number }"
                                required>
                            <p x-show="errors.whatsapp_number" x-text="errors.whatsapp_number?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Alamat Email<span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" autocomplete="off" placeholder="nama@email.com"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.email }"
                                required>
                            <p x-show="errors.email" x-text="errors.email?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Instagram -->
                        <div class="md:col-span-2">
                            <label for="instagram_handle" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Akun Instagram (Opsional)
                            </label>
                            <input type="text" id="instagram_handle" name="instagram_handle" placeholder="@username"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.instagram_handle }">
                            <p x-show="errors.instagram_handle" x-text="errors.instagram_handle?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Event Details -->
                <section class="bg-white rounded-xl shadow-sm p-4 sm:p-5">
                    <div class="flex items-center gap-2 mb-3.5">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-[#FD4801] text-white font-bold text-[10px]">🏃</span>
                        <h2 class="text-sm sm:text-base font-bold text-[#000C28]">Event Details</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Kategori Lari -->
                        <div>
                            <label for="category" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Kategori Lari
                            </label>
                            <input type="text" id="category" name="category" value="10K Trail Run" readonly
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 bg-gray-100 cursor-not-allowed focus:outline-none shadow-sm">
                            <p x-show="errors.category" x-text="errors.category?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Race Tee Size -->
                        <div>
                            <label class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">Race Tee Size<span class="text-red-500">*</span></label>
                            <fieldset class="flex gap-1.5 flex-wrap">
                                <label class="cursor-pointer">
                                    <input type="radio" name="jersey_size" value="S" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 text-xs font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">S</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jersey_size" value="M" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 text-xs font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">M</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jersey_size" value="L" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 text-xs font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">L</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jersey_size" value="XL" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 text-xs font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">XL</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jersey_size" value="XXL" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 text-xs font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">XXL</span>
                                </label>
                            </fieldset>
                            <p x-show="errors.jersey_size" x-text="errors.jersey_size?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 4: Profil Medis -->
                <section class="bg-white rounded-xl shadow-sm p-4 sm:p-5">
                    <div class="flex items-center gap-2 mb-3.5">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-[#FD4801] text-white font-bold text-[10px]">🏥</span>
                        <h2 class="text-sm sm:text-base font-bold text-[#000C28]">Profil Medis & Kontak Darurat</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Golongan Darah -->
                        <div>
                            <label for="blood_type" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Golongan Darah<span class="text-red-500">*</span>
                            </label>
                            <select id="blood_type" name="blood_type" class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.blood_type }">
                                <option value="">-- Pilih --</option>
                                <option value="O">O</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                            </select>
                            <p x-show="errors.blood_type" x-text="errors.blood_type?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Riwayat Medis -->
                        <div>
                            <label for="medical_history" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Riwayat Medis / Alergi
                            </label>
                            <input type="text" id="medical_history" name="medical_history" placeholder="Contoh: Tidak ada"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.medical_history }">
                            <p x-show="errors.medical_history" x-text="errors.medical_history?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Nama Kontak Darurat -->
                        <div class="md:col-span-2">
                            <label for="emergency_contact_name" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Nama Kontak Darurat<span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name" autocomplete="nope" placeholder="Nama lengkap wali"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_name }"
                                required>
                            <p x-show="errors.emergency_contact_name" x-text="errors.emergency_contact_name?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Hubungan -->
                        <div>
                            <label for="emergency_contact_relation" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Hubungan<span class="text-red-500">*</span>
                            </label>
                            <select id="emergency_contact_relation" name="emergency_contact_relation" class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
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
                            <p x-show="errors.emergency_contact_relation" x-text="errors.emergency_contact_relation?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>

                        <!-- Nomor Telepon Darurat -->
                        <div>
                            <label for="emergency_contact_phone" class="block text-[11px] sm:text-xs font-semibold text-[#000C28] mb-1">
                                Nomor Telepon Darurat<span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" placeholder="Contoh: 081122334455"
                                class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_phone }"
                                required>
                            <p x-show="errors.emergency_contact_phone" x-text="errors.emergency_contact_phone?.[0]" class="mt-0.5 text-[10px] text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Checkbox Persetujuan -->
                <section class="bg-white rounded-xl shadow-sm p-4 sm:p-5 mb-4">
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="checkbox" id="agreement" name="agreement"
                            class="mt-0.5 w-3.5 h-3.5 text-[#FD4801] rounded border-gray-300 focus:ring-1 focus:ring-[#FD4801] cursor-pointer"
                            required>
                        <span class="text-[11px] sm:text-xs text-gray-600 leading-relaxed">
                            Saya menyatakan seluruh data benar dan menyetujui <a href="#" class="text-[#FD4801] font-semibold hover:underline">Syarat & Ketentuan</a> Trail Run Jember 2026.
                        </span>
                    </label>
                </section>

                <!-- CTA Button -->
<div class="flex justify-center pt-2">
    <button type="submit"
        :disabled="isSubmitting"
        :class="{ 'opacity-60 cursor-not-allowed hover:scale-100 active:scale-100': isSubmitting }"
        class="inline-flex items-center justify-center rounded-full bg-[#FD4801] px-3.5 py-1.5 text-[10px] sm:text-[11px] font-semibold uppercase tracking-[0.1em] text-white transition duration-300 hover:scale-105 active:scale-95 shadow-sm">
        
        <!-- Loading Circle Spinner -->
        <div x-show="isSubmitting" x-cloak class="animate-spin rounded-full h-3 w-3 border-2 border-white border-t-transparent mr-1.5"></div>

        <!-- Teks Tombol -->
        <span x-show="!isSubmitting">Lanjut ke Pembayaran</span>
        <span x-show="isSubmitting" x-cloak>Memproses...</span>
    </button>
</div>
                </div>

            </form>

        </div>
    </main>
@endsection

@push('scripts')
<script>
    /**
     * Alpine.js Registration Form Component
     */
    function registrationForm() {
        return {
            isSubmitting: false,
            errors: {},
            generalError: '',
            notification: '',
            
            usia: '', 

            hitungUmur(event) {
                const dob = event.target.value;
                if(!dob) return;
                
                const birthDate = new Date(dob);
                const raceYear = 2026; 
                
                let calculatedAge = raceYear - birthDate.getFullYear();
                this.usia = calculatedAge > 0 ? calculatedAge : 0;
            },

            buildPayload() {
                const form = this.$refs.form;
                const fd = new FormData(form);

                return {
                    full_name:                  fd.get('full_name'),
                    identity_number:            fd.get('identity_number'),
                    gender:                     fd.get('gender'),
                    pob:                        fd.get('pob'),
                    dob:                        fd.get('dob'),
                    address:                    fd.get('address'),
                    community:                  fd.get('community') || null,
                    whatsapp_number:            fd.get('whatsapp_number'),
                    email:                      fd.get('email'),
                    instagram_handle:           fd.get('instagram_handle') || null,
                    category:                   fd.get('category'),
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
                // 1. Ambil key error pertama yang dikembalikan oleh Laravel (status 422)
                const errorKeys = Object.keys(this.errors || {});
                if (errorKeys.length > 0) {
                    for (const key of errorKeys) {
                        // Sesuaikan dengan berbagai kemungkinan atribut name pada HTML Anda
                        // (misal: name="email", name="profile[email]", atau menggunakan x-ref)
                        const field = document.querySelector(`[name="${key}"]`)
                                    || document.querySelector(`[name^="${key}["]`)
                                    || document.querySelector(`[x-ref="${key}"]`);
                        if (field) return field;
                    }
                }

                // 2. Fallback universal mencari elemen yang memiliki class error / invalid di halaman
                return document.querySelector('.is-invalid, [aria-invalid="true"], input:invalid, select:invalid, textarea:invalid');
            },

            scrollToFirstError() {
                // Menggunakan double nextTick agar Alpine.js benar-benar selesai memperbarui DOM/pesan error
                this.$nextTick(() => {
                    setTimeout(() => {
                        requestAnimationFrame(() => {
                            const field = this.findFirstInvalidField();
                            if (!field) return;

                            // Lakukan scroll ke tengah elemen
                            field.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });

                            // Berikan fokus ke input jika memungkinkan
                            if (typeof field.focus === 'function' && !field.disabled && field.tabIndex !== -1) {
                                try {
                                    field.focus({ preventScroll: true });
                                } catch (error) {
                                    field.focus();
                                }
                            }
                        });
                    }, 50); // Jeda kecil penstabil render DOM
                });
            },

            async submitForm() {
                if (this.isSubmitting) return;

                this.isSubmitting = true;
                this.clearErrors();
                this.notification = '';

                try {
                    const payload = this.buildPayload();
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    const response = await fetch('{{ route("register.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type':  'application/json',
                            'Accept':        'application/json',
                            'X-CSRF-TOKEN':  csrfToken,
                        },
                        body: JSON.stringify(payload),
                    });

                    let data;
                    try {
                        data = await response.json();
                    } catch (parseError) {
                        throw new Error('Server mengembalikan respons yang tidak valid.');
                    }

                    if (response.status === 422) {
                        this.errors = data.errors || {};
                        this.scrollToFirstError();
                        this.isSubmitting = false;
                        return;
                    }

                    if (!response.ok) {
                        this.generalError = data.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        this.isSubmitting = false;
                        return;
                    }

                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        this.generalError = data.message || 'Gagal memproses pendaftaran. Silakan coba lagi.';
                        this.isSubmitting = false;
                    }

                } catch (error) {
                    console.error('Registration submission error:', error);
                    this.generalError = 'Terjadi kesalahan jaringan. Periksa koneksi internet Anda dan coba lagi.';
                    this.isSubmitting = false;
                }
            },
        };
    }
</script>
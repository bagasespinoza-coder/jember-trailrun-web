@extends('layouts.app')

@section('content')
    <!-- Midtrans Snap.js -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="pt-32 pb-12 bg-[#E2E2E2] min-h-screen">
        <div class="mx-auto max-w-6xl px-5 lg:px-10" x-data="registrationForm()">

            <!-- Stepper Section -->
            <section class="mb-12">
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8">
                    <!-- Step 1: Registration (Active) -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-[#FD4801] border-2 border-[#FD4801]">
                            <span class="text-white font-bold text-lg">1</span>
                        </div>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-[#FD4801] mt-3 text-center">Registration</span>
                    </div>

                    <!-- Connector -->
                    <div class="hidden md:block h-1 flex-1 bg-gray-300"></div>
                    <div class="md:hidden w-0.5 h-12 bg-gray-300"></div>

                    <!-- Step 2: Payment -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white border-2 border-gray-300">
                            <span class="text-gray-400 font-bold text-lg">2</span>
                        </div>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-gray-400 mt-3 text-center">Payment</span>
                    </div>

                    <!-- Connector -->
                    <div class="hidden md:block h-1 flex-1 bg-gray-300"></div>
                    <div class="md:hidden w-0.5 h-12 bg-gray-300"></div>

                    <!-- Step 3: Confirmation -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white border-2 border-gray-300">
                            <span class="text-gray-400 font-bold text-lg">3</span>
                        </div>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-gray-400 mt-3 text-center">Confirmation</span>
                    </div>
                </div>
            </section>

            <!-- Title Section -->
            <section class="text-center mb-10">
                <h1 class="text-4xl md:text-5xl font-bold text-[#000C28] mb-4">Formulir Pendaftaran</h1>
                <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">Lengkapi data diri Anda untuk mengikuti tantangan Trail Run Jember.</p>
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
            <form x-ref="form" @submit.prevent="submitForm" class="space-y-8">

                <!-- Section 1: Data Diri -->
                <section class="bg-white rounded-xl shadow-sm p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#FD4801] text-white font-bold text-sm">👤</span>
                        <h2 class="text-xl md:text-2xl font-bold text-[#000C28]">Data Diri</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nama Lengkap (Sesuai KTP/Passport)
                            </label>
                            <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" value="Adrian Wijaya" 
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.full_name }"
                                required>
                            <p x-show="errors.full_name" x-text="errors.full_name?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Nomor Identitas -->
                        <div>
                            <label for="nomor_identitas" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nomor Identitas (NIK/Passport)
                            </label>
                            <input type="text" id="nomor_identitas" name="nomor_identitas" placeholder="3509XXXXXXXXXXXX" value="3509XXXXXXXXXXXX"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.identity_number }"
                                required>
                            <p x-show="errors.identity_number" x-text="errors.identity_number?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-semibold text-[#000C28] mb-3">Jenis Kelamin</label>
                            <fieldset class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="laki-laki" checked
                                        class="w-4 h-4 text-[#FD4801] focus:ring-2 focus:ring-[#FD4801]">
                                    <span class="text-sm text-gray-700 font-medium">Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="perempuan"
                                        class="w-4 h-4 text-[#FD4801] focus:ring-2 focus:ring-[#FD4801]">
                                    <span class="text-sm text-gray-700 font-medium">Perempuan</span>
                                </label>
                            </fieldset>
                            <p x-show="errors.gender" x-text="errors.gender?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Tempat Lahir
                            </label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Jember" value="Jember"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.pob }"
                                required>
                            <p x-show="errors.pob" x-text="errors.pob?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" placeholder="mm/dd/yyyy" value="2002-11-24"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.dob }"
                                required>
                            <p x-show="errors.dob" x-text="errors.dob?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Usia -->
                        <div>
                            <label for="usia" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Usia (Per-tahun lari)
                            </label>
                            <input type="number" id="usia" name="usia" placeholder="24" value="24"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                required>
                        </div>

                        <!-- Komunitas -->
                        <div class="md:col-span-2">
                            <label for="komunitas" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Komunitas / Klub Lari (Opsional)
                            </label>
                            <input type="text" id="komunitas" name="komunitas" placeholder="e.g., Jember Runners" value="Jember Runners"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.community }">
                            <p x-show="errors.community" x-text="errors.community?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Alamat Domisili
                            </label>
                            <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap saat ini" rows="4"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.address }">Jl. Jawa No. 15, Jember</textarea>
                            <p x-show="errors.address" x-text="errors.address?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 2: Kontak & Komunikasi -->
                <section class="bg-white rounded-xl shadow-sm p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#FD4801] text-white font-bold text-sm">📱</span>
                        <h2 class="text-xl md:text-2xl font-bold text-[#000C28]">Kontak & Komunikasi</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomor WhatsApp -->
                        <div>
                            <label for="whatsapp" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nomor WhatsApp
                            </label>
                            <input type="tel" id="whatsapp" name="whatsapp" placeholder="+62 81234567890" value="+62 81234567890"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.whatsapp_number }"
                                required>
                            <p x-show="errors.whatsapp_number" x-text="errors.whatsapp_number?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Alamat Email
                            </label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" value="adrian@email.com"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.email }"
                                required>
                            <p x-show="errors.email" x-text="errors.email?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Instagram -->
                        <div class="md:col-span-2">
                            <label for="instagram" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Akun Instagram (Opsional)
                            </label>
                            <input type="text" id="instagram" name="instagram" placeholder="@username" value="@adrianwijaya"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.instagram_handle }">
                            <p x-show="errors.instagram_handle" x-text="errors.instagram_handle?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Event Details -->
                <section class="bg-white rounded-xl shadow-sm p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#FD4801] text-white font-bold text-sm">🏃</span>
                        <h2 class="text-xl md:text-2xl font-bold text-[#000C28]">Event Details</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kategori Lari -->
                        <div>
                            <label for="kategori_lari" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Kategori Lari
                            </label>
                            <input type="text" id="kategori_lari" name="kategori_lari" value="10K Trail Run" readonly
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 bg-gray-100 cursor-not-allowed focus:outline-none shadow-sm">
                            <p x-show="errors.category" x-text="errors.category?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Race Tee Size -->
                        <div>
                            <label class="block text-sm font-semibold text-[#000C28] mb-3">Race Tee Size</label>
                            <fieldset class="flex gap-2 flex-wrap">
                                <label class="cursor-pointer">
                                    <input type="radio" name="tee_size" value="S" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">S</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="tee_size" value="M" checked class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">M</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="tee_size" value="L" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">L</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="tee_size" value="XL" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">XL</span>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="tee_size" value="XXL" class="sr-only peer">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border-2 border-gray-300 text-sm font-semibold text-gray-700 peer-checked:border-[#FD4801] peer-checked:bg-[#FD4801] peer-checked:text-white transition">XXL</span>
                                </label>
                            </fieldset>
                            <p x-show="errors.jersey_size" x-text="errors.jersey_size?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Section 4: Profil Medis -->
                <section class="bg-white rounded-xl shadow-sm p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#FD4801] text-white font-bold text-sm">🏥</span>
                        <h2 class="text-xl md:text-2xl font-bold text-[#000C28]">Profil Medis & Kontak Darurat</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Golongan Darah -->
                        <div>
                            <label for="golongan_darah" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Golongan Darah
                            </label>
                            <select id="golongan_darah" name="golongan_darah" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.blood_type }"
                                required>
                                <option value="">-- Pilih Golongan Darah --</option>
                                <option value="O" selected>O</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                            </select>
                            <p x-show="errors.blood_type" x-text="errors.blood_type?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Riwayat Medis -->
                        <div>
                            <label for="riwayat_medis" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Riwayat Medis / Alergi
                            </label>
                            <input type="text" id="riwayat_medis" name="riwayat_medis" placeholder="Tidak ada" value="Tidak ada"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.medical_history }">
                            <p x-show="errors.medical_history" x-text="errors.medical_history?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Nama Kontak Darurat -->
                        <div class="md:col-span-2">
                            <label for="nama_kontak_darurat" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nama Kontak Darurat
                            </label>
                            <input type="text" id="nama_kontak_darurat" name="nama_kontak_darurat" placeholder="Nama lengkap wali/kontak" value="Budi Wijaya"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_name }"
                                required>
                            <p x-show="errors.emergency_contact_name" x-text="errors.emergency_contact_name?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Hubungan -->
                        <div>
                            <label for="hubungan" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Hubungan
                            </label>
                            <select id="hubungan" name="hubungan" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_relation }"
                                required>
                                <option value="">-- Pilih Hubungan --</option>
                                <option value="Ayah" selected>Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Saudara Laki-laki">Saudara Laki-laki</option>
                                <option value="Saudara Perempuan">Saudara Perempuan</option>
                                <option value="Suami">Suami</option>
                                <option value="Istri">Istri</option>
                                <option value="Teman">Teman</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <p x-show="errors.emergency_contact_relation" x-text="errors.emergency_contact_relation?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>

                        <!-- Nomor Telepon Darurat -->
                        <div>
                            <label for="nomor_darurat" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nomor Telepon Darurat
                            </label>
                            <input type="tel" id="nomor_darurat" name="nomor_darurat" placeholder="Nomor telepon aktif kontak darurat" value="+62 81122334455"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                :class="{ 'border-red-400 focus:ring-red-400': errors.emergency_contact_phone }"
                                required>
                            <p x-show="errors.emergency_contact_phone" x-text="errors.emergency_contact_phone?.[0]" class="mt-1.5 text-sm text-red-600"></p>
                        </div>
                    </div>
                </section>

                <!-- Checkbox Persetujuan -->
                <section class="bg-white rounded-xl shadow-sm p-6 md:p-8">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="agreement" name="agreement" checked
                            class="mt-1 w-5 h-5 text-[#FD4801] rounded border-gray-300 focus:ring-2 focus:ring-[#FD4801] cursor-pointer">
                        <span class="text-sm text-gray-600">
                            Saya dengan ini menyatakan bahwa seluruh data yang saya masukkan adalah benar. Saya juga memahami dan menyetujui <a href="#" class="text-[#FD4801] font-semibold hover:underline">Syarat & Ketentuan</a> yang berlaku pada 10K Trail Run Jember 2026.
                        </span>
                    </label>
                </section>

                <!-- CTA Button -->
                <div class="flex justify-center">
                    <button type="submit"
                        :disabled="isSubmitting"
                        :class="{ 'opacity-60 cursor-not-allowed hover:scale-100 active:scale-100': isSubmitting }"
                        class="inline-flex items-center justify-center rounded-full bg-[#FD4801] px-10 py-4 text-base md:text-lg font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105 active:scale-95">
                        <!-- Loading Spinner (visible during submission) -->
                        <svg x-show="isSubmitting" x-cloak class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="isSubmitting ? 'Memproses...' : 'Lanjut ke Pembayaran'"></span>
                        <span class="ml-2" x-show="!isSubmitting">→</span>
                    </button>
                </div>

            </form>

        </div>
    </main>
@endsection

@push('scripts')
<script>
    /**
     * Alpine.js Registration Form Component
     * ======================================
     * Handles:
     * - Async form submission via Fetch API
     * - Backend validation error display per field
     * - Loading / disabled state management
     * - Midtrans Snap popup integration with all callbacks
     */
    function registrationForm() {
        return {
            /** @type {boolean} Submission lock — prevents duplicate POSTs */
            isSubmitting: false,

            /** @type {Object} Backend validation errors keyed by field name */
            errors: {},

            /** @type {string} General error message (server/network failures) */
            generalError: '',

            /** @type {string} Informational notification (e.g. popup closed) */
            notification: '',

            // ─────────────────────────────────────────────────────────
            // Payload Builder
            // ─────────────────────────────────────────────────────────

            /**
             * Maps form field names to the backend's expected parameter names.
             * This avoids changing HTML name attributes while satisfying
             * StoreRegistrationRequest validation rules.
             *
             * @returns {Object} Payload ready for JSON POST
             */
            buildPayload() {
                const form = this.$refs.form;
                const fd = new FormData(form);

                return {
                    // Data Diri
                    full_name:          fd.get('nama'),
                    identity_number:    fd.get('nomor_identitas'),
                    gender:             fd.get('jenis_kelamin') === 'laki-laki' ? 'L' : 'P',
                    pob:                fd.get('tempat_lahir'),
                    dob:                fd.get('tanggal_lahir'),
                    address:            fd.get('alamat'),
                    community:          fd.get('komunitas') || null,

                    // Kontak & Komunikasi
                    whatsapp_number:    fd.get('whatsapp'),
                    email:              fd.get('email'),
                    instagram_handle:   fd.get('instagram') || null,

                    // Event Details
                    category:           fd.get('kategori_lari'),
                    jersey_size:        fd.get('tee_size'),

                    // Profil Medis & Kontak Darurat
                    blood_type:                 fd.get('golongan_darah') || null,
                    medical_history:            fd.get('riwayat_medis') || null,
                    emergency_contact_name:     fd.get('nama_kontak_darurat'),
                    emergency_contact_relation: fd.get('hubungan'),
                    emergency_contact_phone:    fd.get('nomor_darurat'),
                };
            },

            // ─────────────────────────────────────────────────────────
            // Error Helpers
            // ─────────────────────────────────────────────────────────

            /** Resets all error/notification states */
            clearErrors() {
                this.errors = {};
                this.generalError = '';
            },

            /** Smooth-scrolls to the first visible validation error message */
            scrollToFirstError() {
                this.$nextTick(() => {
                    const el = this.$refs.form.querySelector('.text-red-600');
                    if (el && el.offsetParent !== null) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            },

            // ─────────────────────────────────────────────────────────
            // Form Submission
            // ─────────────────────────────────────────────────────────

            /**
             * Main submission handler — called by @submit.prevent.
             * 1. Collects & maps form data
             * 2. POSTs to /register as JSON
             * 3. On 422 → displays per-field errors
             * 4. On success → opens Midtrans Snap popup
             */
            async submitForm() {
                // Guard: prevent duplicate submissions
                if (this.isSubmitting) return;

                this.isSubmitting = true;
                this.clearErrors();
                this.notification = '';

                try {
                    const payload = this.buildPayload();

                    // Retrieve CSRF token from <meta> tag
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute('content');

                    const response = await fetch('{{ route("register.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type':  'application/json',
                            'Accept':        'application/json',
                            'X-CSRF-TOKEN':  csrfToken,
                        },
                        body: JSON.stringify(payload),
                    });

                    // Try to parse the JSON response
                    let data;
                    try {
                        data = await response.json();
                    } catch (parseError) {
                        throw new Error('Server mengembalikan respons yang tidak valid.');
                    }

                    // ── Validation Errors (422) ──
                    if (response.status === 422) {
                        this.errors = data.errors || {};
                        this.scrollToFirstError();
                        this.isSubmitting = false;
                        return;
                    }

                    // ── Other HTTP Errors ──
                    if (!response.ok) {
                        this.generalError = data.message
                            || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        this.isSubmitting = false;
                        return;
                    }

                    // ── Success → Trigger Midtrans Snap ──
                    if (data.success && data.snap_token) {
                        // Keep isSubmitting = true while Snap popup is open
                        this.openSnapPopup(data.snap_token);
                    } else if (data.success && data.redirect_url) {
                        // Fallback for redirect flow if needed
                        window.location.href = data.redirect_url;
                    } else {
                        this.generalError =
                            data.message || 'Gagal mendapatkan token pembayaran. Silakan coba lagi.';
                        this.isSubmitting = false;
                    }

                } catch (error) {
                    console.error('Registration submission error:', error);
                    this.generalError =
                        'Terjadi kesalahan jaringan. Periksa koneksi internet Anda dan coba lagi.';
                    this.isSubmitting = false;
                }
            },

            // ─────────────────────────────────────────────────────────
            // Midtrans Snap Integration
            // ─────────────────────────────────────────────────────────

            /**
             * Opens the Midtrans Snap payment popup.
             * Uses the token returned by the backend — does NOT generate a new one.
             *
             * @param {string} snapToken – Snap transaction token from backend
             */
            openSnapPopup(snapToken) {
                window.snap.pay(snapToken, {

                    /**
                     * Payment completed successfully.
                     * Log the result and redirect to confirmation page.
                     */
                    onSuccess: (result) => {
                        console.log('Payment success:', result);
                        window.location.href = '/confirmation';
                    },

                    /**
                     * Payment is pending (e.g. QRIS scanned, awaiting settlement).
                     * Log the result and redirect to payment status page.
                     */
                    onPending: (result) => {
                        console.log('Payment pending:', result);
                        window.location.href = '/payment';
                    },

                    /**
                     * Payment failed / error from payment gateway.
                     * Show friendly error, keep form data intact.
                     */
                    onError: (result) => {
                        console.error('Payment error:', result);
                        this.generalError =
                            'Pembayaran gagal. Silakan coba lagi atau hubungi panitia.';
                        this.isSubmitting = false;
                    },

                    /**
                     * User closed the Snap popup without completing payment.
                     * Notify the user and re-enable the form.
                     */
                    onClose: () => {
                        this.notification =
                            'Pembayaran belum selesai. Silakan klik "Lanjut ke Pembayaran" untuk melanjutkan.';
                        this.isSubmitting = false;
                    },
                });
            },
        };
    }
</script>
@endpush

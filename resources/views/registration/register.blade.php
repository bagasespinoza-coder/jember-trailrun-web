@extends('layouts.app')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="pt-32 pb-12 bg-[#E2E2E2] min-h-screen">
        <div class="mx-auto max-w-6xl px-5 lg:px-10">

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

            <!-- Form Section -->
            <form action="/payment" method="GET" class="space-y-8">

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
                                required>
                        </div>

                        <!-- Nomor Identitas -->
                        <div>
                            <label for="nomor_identitas" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nomor Identitas (NIK/Passport)
                            </label>
                            <input type="text" id="nomor_identitas" name="nomor_identitas" placeholder="3509XXXXXXXXXXXX" value="3509XXXXXXXXXXXX"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                required>
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
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Tempat Lahir
                            </label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Jember" value="Jember"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                required>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" placeholder="mm/dd/yyyy" value="2002-11-24"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                required>
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
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition">
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Alamat Domisili
                            </label>
                            <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap saat ini" rows="4"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition">Jl. Jawa No. 15, Jember</textarea>
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
                                required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Alamat Email
                            </label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" value="adrian@email.com"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                required>
                        </div>

                        <!-- Instagram -->
                        <div class="md:col-span-2">
                            <label for="instagram" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Akun Instagram (Opsional)
                            </label>
                            <input type="text" id="instagram" name="instagram" placeholder="@username" value="@adrianwijaya"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition">
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
                                required>
                                <option value="">-- Pilih Golongan Darah --</option>
                                <option value="O" selected>O</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                            </select>
                        </div>

                        <!-- Riwayat Medis -->
                        <div>
                            <label for="riwayat_medis" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Riwayat Medis / Alergi
                            </label>
                            <input type="text" id="riwayat_medis" name="riwayat_medis" placeholder="Tidak ada" value="Tidak ada"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition">
                        </div>

                        <!-- Nama Kontak Darurat -->
                        <div class="md:col-span-2">
                            <label for="nama_kontak_darurat" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nama Kontak Darurat
                            </label>
                            <input type="text" id="nama_kontak_darurat" name="nama_kontak_darurat" placeholder="Nama lengkap wali/kontak" value="Budi Wijaya"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                required>
                        </div>

                        <!-- Hubungan -->
                        <div>
                            <label for="hubungan" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Hubungan
                            </label>
                            <select id="hubungan" name="hubungan" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
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
                        </div>

                        <!-- Nomor Telepon Darurat -->
                        <div>
                            <label for="nomor_darurat" class="block text-sm font-semibold text-[#000C28] mb-2">
                                Nomor Telepon Darurat
                            </label>
                            <input type="tel" id="nomor_darurat" name="nomor_darurat" placeholder="Nomor telepon aktif kontak darurat" value="+62 81122334455"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FD4801] shadow-sm transition"
                                required>
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
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#FD4801] px-10 py-4 text-base md:text-lg font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105 active:scale-95">
                        Lanjut ke Pembayaran
                        <span class="ml-2">→</span>
                    </button>
                </div>

            </form>

        </div>
    </main>
@endsection


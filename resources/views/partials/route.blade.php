<section id="route" class="bg-[#E2E2E2] px-5 py-24 lg:px-10">
    <div class="mx-auto max-w-[1200px]">
        <!-- Bagian Header & Deskripsi (Centered) -->
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="mt-4 text-3xl font-bold uppercase tracking-[-0.03em] text-[#000C28] sm:text-4xl lg:text-5xl">
                Explore The <span class="text-[#FD4801]">Route</span>
            </h2>
            <!-- Garis pemisah oranye kecil di bawah judul -->
            <div class="mx-auto mt-6 h-1 w-16 rounded-full bg-[#FD4801]"></div>
            
            <p class="mt-6 text-sm leading-7 text-[#000C28]/70 sm:text-base lg:text-lg sm:leading-8">
                Navigate through varying elevations and terrains designed to test your limits in the heart of Jember’s highlands.
            </p>
        </div>

        <!-- Bagian Konten Utama (Grid 2 Kolom) -->
        <div class="mt-16 grid gap-8 lg:grid-cols-[1.1fr_1fr] lg:items-center lg:gap-12">
            <!-- Kolom Kiri: Kartu Informasi & Tombol -->
            <div class="flex flex-col justify-center">
                <div class="grid gap-4">
                    <!-- Kartu 1: Total Distance -->
                    <article class="flex items-center justify-between rounded-3xl border border-[#000C28]/10 bg-white p-5 sm:p-6 shadow-[0_20px_45px_rgba(0,0,0,0.06)]">
                        <div class="flex items-center space-x-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#FD4801]/10 text-[#FD4801]">
                                <!-- Ikon Jarak -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#000C28]/60 font-medium">Total Distance</p>
                                <p class="mt-1 text-lg sm:text-xl font-bold text-[#000C28]">10 KM</p>
                            </div>
                        </div>
                    </article>

                    <!-- Kartu 2: Max Elevation -->
                    <article class="flex items-center justify-between rounded-3xl border border-[#000C28]/10 bg-white p-5 sm:p-6 shadow-[0_20px_45px_rgba(0,0,0,0.06)]">
                        <div class="flex items-center space-x-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#FD4801]/10 text-[#FD4801]">
                                <!-- Ikon Elevasi -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#000C28]/60 font-medium">Max Elevation</p>
                                <p class="mt-1 text-lg sm:text-xl font-bold text-[#000C28]">850m</p>
                            </div>
                        </div>
                    </article>

                    <!-- Kartu 3: Difficulty -->
                    <article class="flex flex-wrap items-center justify-between gap-3 rounded-3xl border border-[#000C28]/10 bg-white p-5 sm:p-6 shadow-[0_20px_45px_rgba(0,0,0,0.06)]">
                        <div class="flex items-center space-x-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#FD4801]/10 text-[#FD4801]">
                                <!-- Ikon Difficulty -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-[#000C28]/60 font-medium">Difficulty</p>
                                <p class="mt-1 text-lg sm:text-xl font-bold text-[#000C28]">Intermediate</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-[#FD4801]/10 px-4 py-1.5 text-xs font-semibold tracking-wider text-[#FD4801]">LEVEL 3</span>
                    </article>
                </div>

                <!-- Tombol Google Maps -->
                <a href="#" aria-label="View on Google Maps" class="mt-8 inline-flex items-center justify-center space-x-3 rounded-2xl bg-[#FF5A1F] px-8 py-4 text-xs sm:text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-[0_18px_50px_rgba(255,90,31,0.3)] transition duration-300 hover:scale-[1.02] w-full sm:w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <span>View on Google Maps</span>
                </a>
            </div>

            <!-- Kolom Kanan: Mockup Preview Peta -->
            <div class="relative overflow-hidden rounded-[24px] sm:rounded-[32px] border border-[#000C28]/10 bg-white p-3 sm:p-4 shadow-[0_40px_80px_rgba(0,0,0,0.12)]">
                <div class="relative h-full min-h-[340px] sm:min-h-[380px] rounded-[20px] sm:rounded-[24px] border border-[#000C28]/10 bg-[#000C28] p-4 flex flex-col justify-between">
                    <!-- Simulasi Header Peta -->
                    <div class="flex items-center justify-between border-b border-white/10 pb-4 gap-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-bold tracking-wider text-[#FF5A1F]">10K</span>
                            <span class="text-[11px] sm:text-xs font-semibold uppercase tracking-widest text-white/90 truncate">TRAIL RUN JEMBER</span>
                        </div>
                        <div class="hidden sm:flex items-center space-x-3 text-[10px] uppercase text-white/60 tracking-wider">
                            <span>Event Info</span>
                            <span class="text-[#FF5A1F]">Course</span>
                            <span>Registration</span>
                            <span>Profile</span>
                        </div>
                    </div>

                    <!-- Simulasi Badan Peta (Garis Jalur & Titik Lokasi) -->
                    <div class="relative my-6 h-40 sm:h-48 w-full rounded-xl bg-[radial-gradient(circle_at_center,rgba(255,90,31,0.15),transparent_70%)] bg-[#071132] flex items-center justify-center overflow-hidden border border-white/5">
                        <svg class="absolute inset-0 h-full w-full opacity-70" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                            <path d="M50 150 C 100 120, 150 180, 200 100 C 250 40, 300 80, 350 50" stroke="#FF5A1F" stroke-width="3" stroke-linecap="root" stroke-dasharray="6 4"/>
                        </svg>
                        <div class="absolute h-4 w-4 rounded-full bg-[#FF5A1F] shadow-[0_0_15px_#FF5A1F] animate-pulse"></div>
                    </div>

                    <!-- Badge Lokasi Bawah Peta -->
                    <div class="inline-flex items-center space-x-2 rounded-xl bg-white/10 border border-white/10 px-4 py-2.5 text-xs text-white w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-[#FF5A1F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium">Rembangan, Jember</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
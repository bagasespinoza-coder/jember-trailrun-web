<section id="route" class="bg-[#E2E2E2] px-4 py-10 lg:py-16 lg:px-8">
    <div class="mx-auto max-w-[1000px]">
        
        <!-- Bagian Header & Deskripsi (Centered) -->
        <div class="mx-auto max-w-xl text-center">
            <h2 class="mt-2 text-xl font-bold uppercase tracking-[-0.03em] text-[#000C28] sm:text-2xl lg:text-3xl">
                Explore The <span class="text-[#FD4801]">Route</span>
            </h2>
            <!-- Garis pemisah oranye kecil di bawah judul -->
            <div class="mx-auto mt-4 h-0.5 w-12 rounded-full bg-[#FD4801]"></div>
            
            <p class="mt-4 text-[11px] leading-5 text-[#000C28]/70 sm:text-xs sm:leading-6">
                Navigate through varying elevations and terrains designed to test your limits in the heart of Jember’s highlands.
            </p>
        </div>

        <!-- ========================================== -->
        <!-- Bagian Stats (3 Kotak Horizontal)          -->
        <!-- ========================================== -->
        <!-- Pake grid-cols-3 buat paksa berjejer 3 ke samping di semua ukuran layar -->
        <div class="mt-8 sm:mt-10 grid grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
            
            <!-- Kartu 1: Total Distance -->
            <article class="flex flex-col items-center justify-center text-center rounded-xl border border-[#000C28]/10 bg-white p-2.5 sm:p-4 shadow-[0_10px_25px_rgba(0,0,0,0.04)] hover:border-[#FD4801]/30 transition duration-300">
                <div class="flex h-6 w-6 sm:h-8 sm:w-8 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801] mb-1.5 sm:mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </div>
                <p class="text-[8px] sm:text-[10px] uppercase tracking-wider text-[#000C28]/60 font-semibold line-clamp-1">Total Distance</p>
                <p class="mt-0.5 sm:mt-1 text-xs sm:text-lg font-bold text-[#000C28]">10 KM</p>
            </article>

            <!-- Kartu 2: Max Elevation -->
            <article class="flex flex-col items-center justify-center text-center rounded-xl border border-[#000C28]/10 bg-white p-2.5 sm:p-4 shadow-[0_10px_25px_rgba(0,0,0,0.04)] hover:border-[#FD4801]/30 transition duration-300">
                <div class="flex h-6 w-6 sm:h-8 sm:w-8 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801] mb-1.5 sm:mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <p class="text-[8px] sm:text-[10px] uppercase tracking-wider text-[#000C28]/60 font-semibold line-clamp-1">Elevation</p>
                <p class="mt-0.5 sm:mt-1 text-xs sm:text-lg font-bold text-[#000C28]">850m</p>
            </article>

            <!-- Kartu 3: Difficulty -->
            <article class="flex flex-col items-center justify-center text-center rounded-xl border border-[#000C28]/10 bg-white p-2.5 sm:p-4 shadow-[0_10px_25px_rgba(0,0,0,0.04)] hover:border-[#FD4801]/30 transition duration-300">
                <div class="flex h-6 w-6 sm:h-8 sm:w-8 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801] mb-1.5 sm:mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-[8px] sm:text-[10px] uppercase tracking-wider text-[#000C28]/60 font-semibold line-clamp-1">Difficulty</p>
                <p class="mt-0.5 sm:mt-1 text-xs sm:text-lg font-bold text-[#000C28]">Medium</p>
            </article>

        </div>

        <!-- ========================================== -->
        <!-- Bagian Preview Peta (Full Width)           -->
        <!-- ========================================== -->
        <div class="mt-4 sm:mt-6 relative overflow-hidden rounded-[20px] sm:rounded-[24px] border border-[#000C28]/10 bg-white p-3 shadow-[0_30px_60px_rgba(0,0,0,0.08)]">
            
            <!-- min-h dinaikin biar petanya kerasa lega di desktop -->
            <div class="relative h-full min-h-[350px] sm:min-h-[450px] rounded-[16px] sm:rounded-[20px] border border-[#000C28]/10 bg-[#000C28] p-3.5 sm:p-5 flex flex-col justify-between">
                
                <!-- Simulasi Header Peta -->
                <div class="flex items-center justify-between border-b border-white/10 pb-3 gap-2">
                    <div class="flex items-center space-x-2">
                        <span class="text-[11px] sm:text-[13px] font-bold tracking-wider text-[#FF5A1F]">10K</span>
                        <span class="text-[10px] sm:text-[12px] font-semibold uppercase tracking-widest text-white/90 truncate">TRAIL RUN JEMBER</span>
                    </div>
                    <div class="hidden sm:flex items-center space-x-3 text-[10px] uppercase text-white/60 tracking-wider">
                        <span class="cursor-pointer hover:text-white transition">Event Info</span>
                        <span class="text-[#FF5A1F] font-semibold">Course</span>
                        <span class="cursor-pointer hover:text-white transition">Registration</span>
                        <span class="cursor-pointer hover:text-white transition">Profile</span>
                    </div>
                </div>

                <!-- Simulasi Badan Peta (Garis Jalur & Titik Lokasi) -->
                <div class="relative my-4 h-40 sm:h-56 w-full rounded-xl bg-[radial-gradient(circle_at_center,rgba(255,90,31,0.15),transparent_70%)] bg-[#071132] flex items-center justify-center overflow-hidden border border-white/5">
                    <svg class="absolute inset-0 h-full w-full opacity-70" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M50 150 C 100 120, 150 180, 200 100 C 250 40, 300 80, 350 50" stroke="#FF5A1F" stroke-width="3" stroke-linecap="root" stroke-dasharray="6 4"/>
                    </svg>
                    <!-- Marker Titik Lokasi -->
                    <div class="absolute h-4 w-4 rounded-full bg-[#FF5A1F] shadow-[0_0_15px_#FF5A1F] animate-pulse"></div>
                </div>

                <!-- 🔥 TOMBOL MAPS DIGABUNG DI SINI (Footer Peta) -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                    
                    <!-- Badge Lokasi (Kiri) -->
                    <div class="inline-flex items-center space-x-2 rounded-xl bg-white/10 border border-white/10 px-3.5 py-2 text-[10px] sm:text-[11px] text-white w-full sm:w-fit justify-center sm:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 shrink-0 text-[#FF5A1F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium tracking-wide">Rembangan, Jember</span>
                    </div>

                    <!-- Tombol View on Maps (Kanan) -->
                    <a href="#" aria-label="View on Google Maps" class="inline-flex items-center justify-center space-x-2 rounded-xl bg-[#FF5A1F] px-4 py-2 text-[10px] sm:text-[11px] font-semibold uppercase tracking-[0.1em] text-white shadow-[0_6px_15px_rgba(255,90,31,0.2)] transition duration-300 hover:scale-[1.02] w-full sm:w-fit active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        <span>View on Google Maps</span>
                    </a>

                </div>
            </div>
        </div>

    </div>
</section>
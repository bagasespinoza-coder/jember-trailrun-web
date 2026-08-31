<section id="about" class="bg-[#000C28] px-4 py-10 lg:py-12 lg:px-8">
    <div class="mx-auto max-w-[900px]">

        <!-- Bagian Header & Deskripsi (Centered) -->
        <div class="mx-auto max-w-xl text-center">
            <h2 class="mt-2 text-xl font-bold uppercase tracking-[-0.03em] text-[#E2E2E2] sm:text-2xl lg:text-3xl">
                Beyond the <span class="text-[#FD4801]">Route</span>
            </h2>

            <!-- Garis pemisah oranye kecil di bawah judul -->
            <div class="mx-auto mt-3 h-0.5 w-10 rounded-full bg-[#FD4801]"></div>
            
            <!-- (FIXED) Penutup tag paragraf dibenerin jadi </p> -->
            <p class="mt-3 text-sm leading-6 text-white/70 sm:text-base">
                This is where it begins. The Jember Trail Run Start Here brings a brand new 10K adventure through East Java's raw landscapes, built for anyone ready to take their first step into trail running.
            </p>
        </div>

        <!-- Bagian Grid Kartu Informasi -->
        <!-- 🔥 PERUBAHAN: grid-cols-2 untuk mobile, gap-3 agar presisi di layar HP -->
        <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4 lg:gap-6 lg:grid-cols-4">
            
            <!-- Card 1: Date -->
            <article class="rounded-xl border border-white/10 bg-white/[0.02] p-3 lg:p-4 shadow-[0_15px_30px_rgba(0,0,0,0.1)] backdrop-blur-sm">
                <div class="flex items-center space-x-2 lg:space-x-2.5">
                    <div class="flex h-6 w-6 lg:h-9 lg:w-9 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801]">
                        <!-- Ikon Kalender -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-4 lg:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-[9px] lg:text-[11px] uppercase tracking-wider lg:tracking-[0.15em] text-white/60 font-medium">Open Registration</p>
                </div>
                <p class="mt-2.5 lg:mt-4 text-xs sm:text-sm lg:text-base font-semibold text-white">1 september, 2026</p>
            </article>

            <!-- Card 2: Location -->
            <article class="rounded-xl border border-white/10 bg-white/[0.02] p-3 lg:p-4 shadow-[0_15px_30px_rgba(0,0,0,0.1)] backdrop-blur-sm">
                <div class="flex items-center space-x-2 lg:space-x-2.5">
                    <div class="flex h-6 w-6 lg:h-9 lg:w-9 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801]">
                        <!-- Ikon Lokasi/Pin -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-4 lg:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-[9px] lg:text-[11px] uppercase tracking-wider lg:tracking-[0.15em] text-white/60 font-medium">Location</p>
                </div>
                <!-- leading-tight ditambahkan agar kalau teks kepanjangan di HP tetep rapi -->
                <p class="mt-2.5 lg:mt-4 text-xs sm:text-sm lg:text-base font-semibold text-white leading-tight">Jember, Jawa Timur</p>
            </article>

            <!-- Card 3: Start Time -->
            <article class="rounded-xl border border-white/10 bg-white/[0.02] p-3 lg:p-4 shadow-[0_15px_30px_rgba(0,0,0,0.1)] backdrop-blur-sm">
                <div class="flex items-center space-x-2 lg:space-x-2.5">
                    <div class="flex h-6 w-6 lg:h-9 lg:w-9 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801]">
                        <!-- Ikon Jam -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-4 lg:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-[9px] lg:text-[11px] uppercase tracking-wider lg:tracking-[0.15em] text-white/60 font-medium">Start</p>
                </div>
                <p class="mt-2.5 lg:mt-4 text-xs sm:text-sm lg:text-base font-semibold text-white">05:30 WIB</p>
            </article>

            <!-- Card 4: Distance -->
            <article class="rounded-xl border border-white/10 bg-white/[0.02] p-3 lg:p-4 shadow-[0_15px_30px_rgba(0,0,0,0.1)] backdrop-blur-sm">
                <div class="flex items-center space-x-2 lg:space-x-2.5">
                    <div class="flex h-6 w-6 lg:h-9 lg:w-9 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801]">
                        <!-- Ikon Jarak/Route -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-4 lg:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <p class="text-[9px] lg:text-[11px] uppercase tracking-wider lg:tracking-[0.15em] text-white/60 font-medium">Distance</p>
                </div>
                <p class="mt-2.5 lg:mt-4 text-xs sm:text-sm lg:text-base font-semibold text-white">10 KM Trail</p>
            </article>
            
        </div>
    </div>
</section>
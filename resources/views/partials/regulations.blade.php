<section id="regulations" class="bg-[#E2E2E2] px-4 py-10 lg:py-16 lg:px-8">
    
    <!-- Desktop Layout: Gap 8 (32px), rasio 1.5 : 1 -->
    <div class="mx-auto grid max-w-[950px] gap-6 sm:gap-8 lg:grid-cols-[1.5fr_1fr] lg:items-start lg:gap-8">
        
        <!-- ========================================== -->
        <!-- KOLOM KIRI: Judul & Regulations            -->
        <!-- ========================================== -->
        <div class="w-full">
            
            <h2 class="mt-2 text-xl font-bold uppercase tracking-[-0.03em] text-[#000C28] sm:text-2xl lg:text-3xl text-center lg:text-left">
                Race <span class="text-[#FD4801]">Regulation</span>
            </h2>
            <div class="mt-2.5 lg:mt-4 h-0.5 w-10 rounded-full bg-[#FD4801] mx-auto lg:mx-0"></div>
            
            <p class="mt-3 lg:mt-4 text-[11px] leading-5 text-[#000C28]/80 sm:text-xs lg:text-sm lg:leading-relaxed text-center lg:text-left">
                Please review your safety guidelines and requirements to ensure a smooth race experience for everyone.
            </p>

            <!-- Grid Regulations (1 Kolom Vertikal di Semua Layar) -->
            <div class="mt-6 grid grid-cols-1 gap-3 lg:gap-4 lg:mt-8">
                
                <!-- Kotak 1: Age Requirement -->
                <article x-data="{ open: false }" 
                        @click="if(window.innerWidth >= 1024) open = !open" 
                        class="group lg:cursor-pointer rounded-xl border border-[#FD4801]/20 bg-white p-3.5 sm:p-4 shadow-[0_8px_20px_rgba(0,0,0,0.03)] transition duration-300 hover:border-[#FD4801]">
                    
                    <div class="flex items-start lg:items-center gap-3 lg:gap-3.5">
                        <!-- Ikon (Selalu Tampil) -->
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801] transition-colors group-hover:bg-[#FD4801] group-hover:text-white mt-0.5 lg:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <!-- Wrapper Judul & Teks Mobile & Panah Desktop -->
                        <div class="flex w-full items-start lg:items-center justify-between">
                            <div class="flex flex-col text-left">
                                <p class="text-[10px] lg:text-[11px] uppercase tracking-wide lg:tracking-[0.25em] font-bold text-[#FD4801] leading-tight">Age Requirement</p>
                                <!-- Teks Deskripsi (KHUSUS MOBILE: Selalu Tampil) -->
                                <p class="mt-1.5 text-[10px] leading-relaxed text-[#000C28]/80 block lg:hidden">
                                    No age limit. Participants must only be in good health and physically capable of completing the event.
                                </p>
                            </div>
                            <!-- Panah (KHUSUS DESKTOP) -->
                            <svg :class="open ? 'rotate-180' : ''" class="hidden lg:block h-4 w-4 shrink-0 text-[#FD4801] transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>

                    <!-- Teks Deskripsi (KHUSUS DESKTOP: Mode Accordion) -->
                    <div class="hidden lg:block">
                        <div x-show="open" x-collapse x-cloak class="mt-2 ml-[40px]">
                            <p class="text-[11px] leading-relaxed text-[#000C28]/80 text-left">No age limit. Participants must only be in good health and physically capable of completing the event.</p>
                        </div>
                    </div>
                </article>

                <!-- Kotak 2: Health Status -->
                <article x-data="{ open: false }" 
                        @click="if(window.innerWidth >= 1024) open = !open" 
                        class="group lg:cursor-pointer rounded-xl border border-[#FD4801]/20 bg-white p-3.5 sm:p-4 shadow-[0_8px_20px_rgba(0,0,0,0.03)] transition duration-300 hover:border-[#FD4801]">
                    
                    <div class="flex items-start lg:items-center gap-3 lg:gap-3.5">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801] transition-colors group-hover:bg-[#FD4801] group-hover:text-white mt-0.5 lg:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div class="flex w-full items-start lg:items-center justify-between">
                            <div class="flex flex-col text-left">
                                <p class="text-[10px] lg:text-[11px] uppercase tracking-wide lg:tracking-[0.25em] font-bold text-[#FD4801] leading-tight">Health Status</p>
                                <p class="mt-1.5 text-[10px] leading-relaxed text-[#000C28]/80 block lg:hidden">
                                    Participants must be in good physical health and have no underlying medical conditions.
                                </p>
                            </div>
                            <svg :class="open ? 'rotate-180' : ''" class="hidden lg:block h-4 w-4 shrink-0 text-[#FD4801] transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div x-show="open" x-collapse x-cloak class="mt-2 ml-[40px]">
                            <p class="text-[11px] leading-relaxed text-[#000C28]/80 text-left">Participants must be in good physical health and have no underlying medical conditions.</p>
                        </div>
                    </div>
                </article>

                <!-- Kotak 3: Mandatory Gear -->
                <article x-data="{ open: false }" 
                         @click="if(window.innerWidth >= 1024) open = !open" 
                         class="group lg:cursor-pointer rounded-xl border border-[#FD4801]/20 bg-white p-3.5 sm:p-4 shadow-[0_8px_20px_rgba(0,0,0,0.03)] transition duration-300 hover:border-[#FD4801]">
                    
                    <div class="flex items-start lg:items-center gap-3 lg:gap-3.5">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#FD4801]/10 text-[#FD4801] transition-colors group-hover:bg-[#FD4801] group-hover:text-white mt-0.5 lg:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="flex w-full items-start lg:items-center justify-between">
                            <div class="flex flex-col text-left">
                                <p class="text-[10px] lg:text-[11px] uppercase tracking-wide lg:tracking-[0.25em] font-bold text-[#FD4801] leading-tight">Mandatory Gear</p>
                                <p class="mt-1.5 text-[10px] leading-relaxed text-[#000C28]/80 block lg:hidden">
                                    Hydration pack (min 500mL), trail shoes, and a whistle are required for all runners.
                                </p>
                            </div>
                            <svg :class="open ? 'rotate-180' : ''" class="hidden lg:block h-4 w-4 shrink-0 text-[#FD4801] transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div x-show="open" x-collapse x-cloak class="mt-2 ml-[40px]">
                            <p class="text-[11px] leading-relaxed text-[#000C28]/80 text-left">Hydration pack (min 500mL), trail shoes, and a whistle are required for all runners.</p>
                        </div>
                    </div>
                </article>
                
            </div>

            <!-- Tombol CTA Download -->
            <a href="#" aria-label="Download Full Racer's Guide" class="mt-5 sm:mt-6 lg:mt-8 flex w-full lg:inline-flex lg:w-auto items-center justify-center rounded-full bg-[#FD4801] px-5 py-3 lg:py-2.5 text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.1em] text-white shadow-[0_6px_15px_rgba(253,72,1,0.2)] transition duration-300 hover:scale-[1.02] active:scale-95">
                Download Full Racer’s Guide (PDF)
            </a>
        </div>

        <!-- ========================================== -->
        <!-- KOLOM KANAN: Need Help (Sidebar)           -->
        <!-- ========================================== -->
        <aside class="self-start rounded-2xl border border-[#FD4801]/30 bg-[#000C28] p-4 lg:p-5 shadow-[0_15px_40px_rgba(0,0,0,0.15)] mt-4 lg:mt-[72px]">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#FD4801] text-center lg:text-left">Need Help?</p>
            <div class="mt-3.5 space-y-2 lg:space-y-2.5">
                <article class="rounded-xl bg-white/5 border border-white/10 p-3 shadow-sm transition duration-300 hover:border-[#FD4801]">
                    <p class="text-[10px] text-white/70">WhatsApp</p>
                    <p class="mt-0.5 text-xs font-semibold text-white">+62 822-3651-6043</p>
                </article>
                <article class="rounded-xl bg-white/5 border border-white/10 p-3 shadow-sm transition duration-300 hover:border-[#FD4801]">
                    <p class="text-[10px] text-white/70">Email Support</p>
                    <p class="mt-0.5 text-xs font-semibold text-white">hello@jembertrail.run</p>
                </article>
                <article class="rounded-xl bg-white/5 border border-white/10 p-3 shadow-sm transition duration-300 hover:border-[#FD4801]">
                    <p class="text-[10px] text-white/70">Instagram</p>
                    <p class="mt-0.5 text-xs font-semibold text-white">@10ktrailjember</p>
                </article>
            </div>
            <p class="mt-3.5 text-[10px] leading-4 text-white/60 text-center lg:text-left">Mon - Sat, 09:00 - 17:00 WIB.</p>
        </aside>
        
    </div>
</section>
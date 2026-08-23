<!-- Hero Section with Background Image -->
<!-- pt-24 gua kurangin jadi pt-16 biar atasnya nggak terlalu neken ke bawah di HP -->
<section id="home" class="relative overflow-hidden min-h-screen lg:h-screen flex items-center justify-center pt-16 pb-8 lg:py-0">

    <!-- Background Image with Local Asset -->
    <div
        class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image:url('/images/hero-desktop.jpg');">
    </div>
    
    <!-- Dark Gradient Overlay -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- Accent Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-[#000C28]/20 via-[#000C28]/50 to-[#000C28]/90"></div>

    <!-- Radial Highlight Overlay -->
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(253,72,1,0.16),transparent_90%)]"></div>
    
    <!-- Main Content Container -->
    <div class="relative z-10 mx-auto w-full max-w-[1300px] lg:max-w-[1200px] px-4 lg:px-6 -mt-12 lg:mt-16 flex flex-col lg:flex-row lg:items-start lg:justify-between lg:gap-12">
        
        <!-- ========================================== -->
        <!-- KOLOM KIRI: Title & Deskripsi              -->
        <!-- ========================================== -->
        <div class="w-full lg:w-8/12 flex flex-col justify-center text-center lg:text-left">
            
            <!-- Label -->
            <div class="flex justify-center lg:justify-start">
                <p class="mb-3 lg:mb-2 inline-flex items-center gap-1.5 rounded-full border border-white/30 bg-white/10 px-3.5 py-1 text-[10px] lg:text-xs font-semibold uppercase tracking-[0.15em] text-white/90 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-[#FD4801] animate-pulse"></span>
                    Registration For 2026
                </p>
            </div>
            
            <!-- Title -->
            <h1 class="font-race max-w-3xl lg:max-w-full text-3xl font-black uppercase leading-[1.1] tracking-[-0.02em] text-white sm:text-4xl lg:text-[3.5rem]">
                Jember <br class="hidden lg:block" />
                <span class="inline-block">Trail </span> <span class="text-[#FD4801]">Run</span>
            </h1>
            
            <!-- Deskripsi -->
            <p class="mt-3 lg:mt-4 max-w-xl mx-auto lg:mx-0 lg:max-w-2xl text-xs sm:text-sm leading-relaxed text-white/80 lg:text-base">
                Start Your Journey, and Feel the Trail.
                Experience the untamed beauty of Jember in a race made for first-timers and future trailblazers.
            </p>

            <!-- CTA Buttons KHUSUS DESKTOP (Sembunyi di Mobile) -->
<div class="hidden lg:flex mt-10 items-center justify-start gap-4">
                <a href="#register-flow" aria-label="Register Event" class="inline-flex items-center justify-center rounded-full bg-[#FD4801] px-5 py-2 text-xs font-bold uppercase tracking-[0.1em] text-white shadow-[0_4px_15px_rgba(253,72,1,0.35)] transition duration-300 hover:scale-105 hover:shadow-[0_8px_25px_rgba(253,72,1,0.45)]">
                    Registration Flow
                </a>
                <a href="#route" aria-label="Explore Route" class="inline-flex items-center justify-center rounded-full border border-white/40 bg-white/5 px-5 py-2 text-xs font-bold uppercase tracking-[0.1em] text-white backdrop-blur-sm transition duration-300 hover:border-white/80 hover:bg-white/10">
                    Explore Route
                </a>
            </div>
            
        </div>

        <!-- ========================================== -->
        <!-- KOLOM TENGAH/KANAN: Stats Section          -->
        <!-- ========================================== -->
        <div class="mt-8 lg:mt-6 w-full lg:w-auto lg:min-w-[180px] lg:max-w-[220px] lg:ml-auto grid grid-cols-3 lg:grid-cols-1 gap-2 lg:gap-3">
            
            <!-- Stat 1: Participants -->
            <article class="group flex flex-col items-center justify-center text-center rounded-xl border border-white/20 bg-white/10 p-2.5 sm:p-3 lg:p-4 backdrop-blur-xl transition duration-300 hover:border-[#FD4801]/50 hover:bg-white/15">
                <div class="flex items-center justify-center gap-1.5 lg:gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 lg:w-5 lg:h-5 text-white/70 group-hover:text-[#FD4801] transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <p class="text-[8px] sm:text-[9px] lg:text-[11px] font-semibold uppercase tracking-wider lg:tracking-[0.12em] text-white/70">Participants</p>
                </div>
                <h2 class="font-race text-base sm:text-xl lg:text-2xl font-bold text-white">300+</h2>
            </article>

            <!-- Stat 2: Trail Route -->
            <article class="group flex flex-col items-center justify-center text-center rounded-xl border border-white/20 bg-white/10 p-2.5 sm:p-3 lg:p-4 backdrop-blur-xl transition duration-300 hover:border-[#FD4801]/50 hover:bg-white/15">
                <div class="flex items-center justify-center gap-1.5 lg:gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 lg:w-5 lg:h-5 text-white/70 group-hover:text-[#FD4801] transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <p class="text-[8px] sm:text-[9px] lg:text-[11px] font-semibold uppercase tracking-wider lg:tracking-[0.12em] text-white/70">Trail</p>
                </div>
                <h2 class="font-race text-base sm:text-xl lg:text-2xl font-bold text-white">10K</h2>
            </article>

            <!-- Stat 3: Official Medal -->
            <article class="group flex flex-col items-center justify-center text-center rounded-xl border border-white/20 bg-white/10 p-2.5 sm:p-3 lg:p-4 backdrop-blur-xl transition duration-300 hover:border-[#FD4801]/50 hover:bg-white/15">
                <div class="flex items-center justify-center gap-1.5 lg:gap-2 mb-1">
                    <svg class="w-3.5 h-3.5 lg:w-5 lg:h-5 text-white/70 group-hover:text-[#FD4801] transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    <p class="text-[8px] sm:text-[9px] lg:text-[11px] font-semibold uppercase tracking-wider lg:tracking-[0.12em] text-white/70">Official</p>
                </div>
                <h2 class="font-race text-base sm:text-xl lg:text-2xl font-bold text-white">Medal</h2>
            </article>
            
        </div>

        <!-- ========================================== -->
        <!-- CTA Buttons KHUSUS MOBILE (Sembunyi di Desktop) -->
        <!-- ========================================== -->
        <div class="mt-8 flex flex-col items-center justify-center gap-3 w-full lg:hidden">
            <a href="#register-flow" aria-label="Register Event" class="inline-flex items-center justify-center w-full rounded-full bg-[#FD4801] px-8 py-3 text-xs font-bold uppercase tracking-[0.12em] text-white shadow-[0_8px_25px_rgba(253,72,1,0.4)] active:scale-95 transition duration-300">
                Registration Flow
            </a>
            <a href="#route" aria-label="Explore Route" class="inline-flex items-center justify-center w-full rounded-full border border-white/40 bg-white/5 px-8 py-3 text-xs font-bold uppercase tracking-[0.12em] text-white backdrop-blur-sm active:bg-white/10 transition duration-300">
                Explore Route
            </a>
        </div>
        
    </div>

</section>
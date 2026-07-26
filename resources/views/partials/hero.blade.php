<!-- Hero Section with Background Image -->
<section id="home" class="relative overflow-hidden min-h-[100vh] flex items-center justify-center">
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
    
    <!-- Content -->
    <div class="relative z-10 mx-auto w-full max-w-[1400px] px-5 py-20 lg:px-10">
        <div class="flex min-h-[80vh] flex-col justify-center">
            <!-- Title Section -->
            <div class="max-w-4xl text-center lg:text-left">
                <p class="mb-5 inline-block rounded-full border border-white/30 bg-white/10 px-6 py-3 text-xs font-semibold uppercase tracking-[0.3em] text-white/90 backdrop-blur-sm">
                    🏃 Registration For 2026
                </p>
                <h1 class="max-w-5xl text-5xl font-black uppercase leading-[0.95] tracking-[-0.02em] text-white sm:text-6xl lg:text-7xl">
                    Jember <br class="hidden lg:block" />
                    <span class="inline-block">Trail Run</span> <span class="text-[#FD4801]">10K</span>
                </h1>
                <p class="mt-8 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg sm:leading-8 lg:text-xl">
                    Jember Trail Run, Start Your Journey, and Feel the Trail. 
                    Experience the untamed beauty of Jember in a race made for first-timers and future trailblazers. <br class="hidden sm:block" />

                </p>
            </div>

            <!-- Stats Section -->
            <div class="mt-16 grid max-w-4xl gap-4 md:grid-cols-3 lg:mx-0">
                <article class="group rounded-2xl border border-white/20 bg-white/10 px-6 py-8 backdrop-blur-xl transition duration-300 hover:border-[#FD4801]/50 hover:bg-white/15">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="text-2xl">🏃</div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/60">Participants</p>
                    </div>
                    <h2 class="text-4xl font-bold text-white">300+</h2>
                </article>
                <article class="group rounded-2xl border border-white/20 bg-white/10 px-6 py-8 backdrop-blur-xl transition duration-300 hover:border-[#FD4801]/50 hover:bg-white/15">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="text-2xl">🛤️</div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/60">Trail</p>
                    </div>
                    <h2 class="text-4xl font-bold text-white">10K</h2>
                </article>
                <article class="group rounded-2xl border border-white/20 bg-white/10 px-6 py-8 backdrop-blur-xl transition duration-300 hover:border-[#FD4801]/50 hover:bg-white/15">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="text-2xl">🏅</div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/60">Official</p>
                    </div>
                    <h2 class="text-4xl font-bold text-white">Medal</h2>
                </article>
            </div>

            <!-- CTA Buttons -->
            <div class="mt-16 flex flex-col items-center justify-center gap-5 sm:flex-row lg:justify-start">
                <a href="#register-flow" aria-label="Register Event" class="group inline-flex items-center justify-center gap-2 rounded-full bg-[#FD4801] px-8 py-4 text-base font-bold uppercase tracking-[0.15em] text-white shadow-[0_20px_60px_rgba(253,72,1,0.4)] transition duration-300 hover:scale-105 hover:shadow-[0_25px_70px_rgba(253,72,1,0.5)]">
                    Register Flow
                    <span class="transition group-hover:translate-x-1">→</span>
                </a>
                <a href="#route" aria-label="Explore Route" class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-white/40 bg-white/5 px-8 py-4 text-base font-bold uppercase tracking-[0.15em] text-white backdrop-blur-sm transition duration-300 hover:border-white/80 hover:bg-white/10">
                    Explore Route
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 z-20 -translate-x-1/2 animate-bounce">
        <div class="flex flex-col items-center gap-2 text-white/60">
            <p class="text-xs font-semibold uppercase tracking-widest">Scroll</p>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
</section>

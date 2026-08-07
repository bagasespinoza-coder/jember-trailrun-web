@php
    // Jika halaman saat ini adalah register, hentikan render navbar
    if (Request::is('register')) {
        return;
    }

    $isSubpage = Request::is('payment') || Request::is('confirmation') || Request::is('payment-expired');
    
    // Menentukan tujuan tombol "Back" secara dinamis berdasarkan subpage aktif
    $backUrl = '/';
    if (Request::is('payment')) {
        $backUrl = '/register';
    } elseif (Request::is('confirmation')) {
        $backUrl = '/payment';
    }
@endphp

<header class="fixed inset-x-0 top-0 z-50 {{ $isSubpage ? 'bg-white shadow-sm border-b border-gray-100' : '' }}" {{ $isSubpage ? 'data-navbar-static' : '' }}>
    <nav data-navbar class="mx-auto flex h-20 items-center justify-between px-5 transition-all duration-300 lg:px-10">
        @if($isSubpage)
            <a href="{{ $backUrl }}" class="flex items-center gap-3 text-[#000C28] no-underline">
                <div class="flex items-center gap-3">
                    <img id="nav-logo-black" src="/images/logo.black.png" alt="Logo" class="h-18 w-auto block transition-opacity duration-300">
                </div>
            </a>
        @else
            <a href="#home" class="flex items-center gap-3 text-white no-underline">
                <div class="flex items-center gap-3">
                    <img id="nav-logo-white" src="/images/logo.white.png" alt="Logo" class="h-18 w-auto block transition-opacity duration-300">
                    <!-- Logo Hitam (Tampil saat di-scroll ke background putih) -->
                    <img id="nav-logo-black" src="/images/logo.black.png" alt="Logo" class="h-18 w-auto hidden transition-opacity duration-300">
                </div>
            </a>
        @endif

        @if($isSubpage)
        @else
            <div class="hidden items-center gap-8 text-sm font-semibold uppercase tracking-[0.18em] text-white lg:flex">
                <a href="#home" class="transition hover:text-[#FD4801] hover:underline hover:underline-offset-8">Home</a>
                <a href="#about" class="transition hover:text-[#FD4801] hover:underline hover:underline-offset-8">About</a>
                <a href="#route" class="transition hover:text-[#FD4801] hover:underline hover:underline-offset-8">Route</a>
                <a href="#facilities" class="transition hover:text-[#FD4801] hover:underline hover:underline-offset-8">Facilities</a>
                <a href="#regulations" class="transition hover:text-[#FD4801] hover:underline hover:underline-offset-8">Regulations</a>
                <a href="#contact" class="transition hover:text-[#FD4801] hover:underline hover:underline-offset-8">Contact</a>
            </div>
        @endif

        @if($isSubpage)
            <div class="hidden items-center gap-4 lg:flex">
                <!-- Mengubah href agar kembali sesuai variabel $backUrl -->
                <a href="{{ $backUrl }}" aria-label="Go back" class="inline-flex items-center justify-center rounded-full bg-[#FF5A1F] px-8 py-2.5 text-sm font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105">
                    Back
                </a>
            </div>
        @else
            <div class="hidden lg:flex">
                <a href="/register" aria-label="Register Now" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-[#FD4801] px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105">
                    Register Now
                </a>
            </div>
        @endif

        <!-- Tombol hamburger mobile -->
        <button type="button" aria-label="Open mobile menu" data-menu-toggle class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-black/10 {{ $isSubpage ? 'bg-[#F8F8F8] text-gray-900' : 'bg-[#E2E2E2] text-gray-900' }} transition duration-300 hover:bg-[#FD4801] hover:text-white lg:hidden">
            <span class="space-y-1.5">
                <span class="block h-0.5 w-6 bg-current"></span>
                <span class="block h-0.5 w-6 bg-current"></span>
                <span class="block h-0.5 w-6 bg-current"></span>
            </span>
        </button>
    </nav>

    <div data-menu-overlay class="fixed inset-0 hidden bg-black/50 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar menu mobile -->
    <aside data-mobile-menu class="fixed inset-y-0 left-0 z-50 w-[280px] -translate-x-full bg-[#E2E2E2] px-6 py-8 shadow-2xl transition-transform duration-300 lg:hidden">
        <div class="mb-10 flex items-center justify-between">
            <div class="flex items-center gap-3 text-gray-900">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#FD4801] text-white">
                    <span class="text-base font-bold uppercase tracking-[0.32em]">TR</span>
                </div>
                <span class="text-sm font-semibold uppercase tracking-[0.28em]">Jember 10K</span>
            </div>
            <button type="button" aria-label="Close mobile menu" data-menu-close class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-black/10 text-gray-900 transition duration-300 hover:bg-black/5">
                <span class="text-2xl leading-none">×</span>
            </button>
        </div>

        <nav class="space-y-6 text-sm font-semibold uppercase tracking-[0.18em] text-gray-800">
            <a href="/#home" data-mobile-link class="block transition hover:text-[#FD4801]">Home</a>
            <a href="/#about" data-mobile-link class="block transition hover:text-[#FD4801]">About</a>
            <a href="/#route" data-mobile-link class="block transition hover:text-[#FD4801]">Route</a>
            @if(!$isSubpage)
                <a href="#facilities" data-mobile-link class="block transition hover:text-[#FD4801]">Facilities</a>
                <a href="#regulations" data-mobile-link class="block transition hover:text-[#FD4801]">Regulations</a>
            @endif
            <a href="/#contact" data-mobile-link class="block transition hover:text-[#FD4801]">Contact</a>
        </nav>

        <div class="mt-10">
            @if($isSubpage)
                <!-- Mengubah href tombol Back versi mobile -->
                <a href="{{ $backUrl }}" data-mobile-link aria-label="Go back" class="inline-flex w-full items-center justify-center rounded-full bg-[#FF5A1F] px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105">
                    Back
                </a>
            @else
                <a href="/register" data-mobile-link aria-label="Register Now" class="inline-flex w-full items-center justify-center rounded-full bg-[#FD4801] px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-105">
                    Register Now
                </a>
            @endif
        </div>
    </aside>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mobileMenu = document.querySelector('[data-mobile-menu]');
        const menuOverlay = document.querySelector('[data-menu-overlay]');
        const menuToggle = document.querySelector('[data-menu-toggle]');
        const menuClose = document.querySelector('[data-menu-close]');
        const mobileLinks = document.querySelectorAll('[data-mobile-link]');

        if (mobileMenu && menuToggle) {
            function openMenu() {
                mobileMenu.classList.remove('-translate-x-full');
                menuOverlay.classList.remove('hidden');
            }

            function closeMenu() {
                mobileMenu.classList.add('-translate-x-full');
                menuOverlay.classList.add('hidden');
            }

            menuToggle.addEventListener('click', openMenu);
            if (menuClose) menuClose.addEventListener('click', closeMenu);
            if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);

            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    closeMenu();
                });
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navLogoWhite = document.getElementById('nav-logo-white');
        const navLogoBlack = document.getElementById('nav-logo-black');
        const navbar = document.querySelector('header');

        if (navbar && !navbar.hasAttribute('data-navbar-static')) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    if (navLogoWhite) navLogoWhite.classList.add('hidden');
                    if (navLogoBlack) navLogoBlack.classList.remove('hidden');
                    navbar.classList.add('bg-white/80', 'backdrop-blur-md', 'shadow-sm');
                } else {
                    if (navLogoBlack) navLogoBlack.classList.add('hidden');
                    if (navLogoWhite) navLogoWhite.classList.remove('hidden');
                    navbar.classList.remove('bg-white/80', 'backdrop-blur-md', 'shadow-sm');
                }
            });
        }
    });
</script>
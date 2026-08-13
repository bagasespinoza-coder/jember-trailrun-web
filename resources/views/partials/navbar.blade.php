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

<header id="main-header" class="fixed inset-x-0 top-0 w-full z-50 transition-all duration-300 {{ $isSubpage ? 'bg-white shadow-sm border-b border-gray-100 text-[#000C28]' : 'bg-transparent text-white' }} hidden lg:block" {{ $isSubpage ? 'data-navbar-static' : '' }}>
    
    <nav data-navbar class="w-full mx-auto flex h-16 lg:h-20 items-center justify-between px-4 transition-all duration-300 lg:px-8 max-w-[1300px]">
        
        <!-- 1. Bagian Logo (Ukurannya dibesarin jadi h-10 lg:h-11) -->
        <div class="flex items-center">
        @if($isSubpage)
                <a href="{{ $backUrl }}" class="flex items-center gap-2 text-[#000C28] no-underline">
                    <img src="/images/logo.black.png" alt="Logo" class="h-10 w-auto lg:h-11 block">
                </a>
        @else
                <a href="#home" class="flex items-center gap-2 text-white no-underline">
                    <img id="nav-logo-white" src="/images/logo.white.png" alt="Logo" class="h-10 w-auto lg:h-11 block transition-opacity duration-300">
                    <img id="nav-logo-black" src="/images/logo.black.png" alt="Logo" class="h-10 w-auto lg:h-11 hidden transition-opacity duration-300">
                </a>
        @endif
        </div>

        <!-- 2. Bagian Menu Navigasi Desktop (Teks dibesarin jadi text-[13px] dan font-bold) -->
        @if(!$isSubpage)
            <div class="hidden items-center gap-7 text-[13px] font-bold uppercase tracking-[0.12em] text-white lg:flex">
                <a href="#home" class="nav-link transition hover:text-[#FD4801] hover:underline hover:underline-offset-4">Home</a>
                <a href="#about" class="nav-link transition hover:text-[#FD4801] hover:underline hover:underline-offset-4">About</a>
                <a href="#route" class="nav-link transition hover:text-[#FD4801] hover:underline hover:underline-offset-4">Route</a>
                <a href="#facilities" class="nav-link transition hover:text-[#FD4801] hover:underline hover:underline-offset-4">Facilities</a>
                <a href="#regulations" class="nav-link transition hover:text-[#FD4801] hover:underline hover:underline-offset-4">Regulations</a>
                <a href="#contact" class="nav-link transition hover:text-[#FD4801] hover:underline hover:underline-offset-4">Contact</a>
            </div>
        @else
            <div></div>
        @endif

        <!-- 3. Bagian Tombol Aksi (Disesuaikan proporsinya) -->
        <div class="flex items-center">
            @if($isSubpage)
                <a href="{{ $backUrl }}" aria-label="Go back" class="inline-flex items-center justify-center rounded-full bg-[#FF5A1F] px-5 py-2 text-[12px] font-semibold uppercase tracking-[0.12em] text-white transition duration-300 hover:scale-105">
                    Back
                </a>
            @else
                <a href="/register" aria-label="Register Now" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-[#FD4801] px-5 py-2.5 text-[12px] font-bold uppercase tracking-[0.12em] text-white shadow-[0_4px_15px_rgba(253,72,1,0.3)] transition duration-300 hover:scale-105">
                    Register Now
                </a>
            @endif
        </div>

    </nav>
</header>


        <!-- Tombol hamburger mobile -->
<div class="fixed top-4 right-4 z-40 lg:hidden">
    <button type="button" aria-label="Open mobile menu" data-menu-toggle class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-black/10 bg-white/90 backdrop-blur-md shadow-md text-gray-900 transition hover:bg-white">
        <span class="space-y-1">
            <span class="block h-0.5 w-5 bg-current"></span>
            <span class="block h-0.5 w-5 bg-current"></span>
            <span class="block h-0.5 w-5 bg-current"></span>
        </span>
    </button>
</div>

<div data-menu-overlay class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm lg:hidden"></div>

<!-- ================= OVERLAY & SIDEBAR MOBILE ================= -->
<div data-menu-overlay class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm lg:hidden"></div>

<aside data-mobile-menu class="fixed inset-y-0 left-0 z-50 w-[280px] -translate-x-full bg-white px-6 py-6 shadow-2xl transition-transform duration-300 lg:hidden flex flex-col justify-between">
    <div>
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-2 text-gray-900">
                <a href="/#home" class="flex items-center gap-2 no-underline">
                    <img src="/images/logo.black.png" alt="Logo" class="h-8 w-auto lg:h-9 block">
                </a>
            </div>
            <button type="button" aria-label="Close mobile menu" data-menu-close class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-black/10 text-gray-900 transition duration-300 hover:bg-black/5">
                <span class="text-xl leading-none">×</span>
            </button>
        </div>

        <nav class="space-y-5 text-xs font-bold uppercase tracking-[0.12em] text-gray-900">
            <a href="/#home" data-mobile-link class="block transition hover:text-[#FD4801]">Home</a>
            <a href="/#about" data-mobile-link class="block transition hover:text-[#FD4801]">About</a>
            <a href="/#route" data-mobile-link class="block transition hover:text-[#FD4801]">Route</a>
            @if(!$isSubpage)
                <a href="#facilities" data-mobile-link class="block transition hover:text-[#FD4801]">Facilities</a>
                <a href="#regulations" data-mobile-link class="block transition hover:text-[#FD4801]">Regulations</a>
            @endif
            <a href="/#contact" data-mobile-link class="block transition hover:text-[#FD4801]">Contact</a>
        </nav>
    </div>

    <div class="pt-4">
        @if($isSubpage)
            <a href="{{ $backUrl }}" data-mobile-link aria-label="Go back" class="inline-flex w-full items-center justify-center rounded-full bg-[#FF5A1F] px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-white transition duration-300 hover:scale-105">
                Back
            </a>
        @else
            <a href="/register" data-mobile-link aria-label="Register Now" class="inline-flex w-full items-center justify-center rounded-full bg-[#FD4801] px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-white transition duration-300 hover:scale-105">
                Register Now
            </a>
        @endif
    </div>
</aside>
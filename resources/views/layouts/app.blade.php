<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Jember Trail Run</title>

        <link rel="icon" type="image/png" href="{{ asset('images/logo.crop.png') }}">

        <style>[x-cloak] { display: none !important; }</style>
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 overflow-x-hidden">
        @yield('content')
        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // 1. Ambil semua section yang punya ID dan semua menu navbar
                const sections = document.querySelectorAll('section[id]');
                const navLinks = document.querySelectorAll('.nav-link');

                // 2. Pasang pendeteksi scroll
                window.addEventListener('scroll', () => {
                    let currentSection = '';
                    const scrollY = window.pageYOffset;

                    sections.forEach(section => {
                        // Offset -150px biar warnanya ganti sebelum section-nya beneran mentok di atas layar
                        const sectionTop = section.offsetTop - 150; 
                        const sectionHeight = section.offsetHeight;
                        
                        if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                            currentSection = section.getAttribute('id');
                        }
                    });

                    // 3. Update styling menu navbar
                    navLinks.forEach(link => {
                        link.classList.remove('text-[#FD4801]', 'underline', 'underline-offset-4');
                        if (link.getAttribute('href') === `#${currentSection}`) {
                            link.classList.add('text-[#FD4801]', 'underline', 'underline-offset-4');
                        }
                    });
                });
            });
            </script>
    </body>
</html>

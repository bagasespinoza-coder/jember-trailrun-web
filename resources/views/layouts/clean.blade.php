<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Trail Run Jember' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#E2E2E2] font-sans antialiased text-[#000C28]">
    <!-- Tanpa Navbar & Tanpa Footer -->

    @yield('content')

    @stack('scripts')
</body>
</html>
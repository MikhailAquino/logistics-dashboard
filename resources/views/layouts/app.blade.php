<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logistics Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for reactive UI components -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-[url('https://mir-s3-cdn-cf.behance.net/project_modules/fs/6aed5e56730527.59ba033156f54.png')] bg-cover bg-center min-h-screen font-sans">
    <div class="min-h-screen flex flex-col">
        <header class="bg-[#3b167c]/90 shadow p-4 flex items-center justify-between">
            <div class="text-2xl font-bold text-white drop-shadow">
                <a href="{{ url('/') }}">{{ config('app.name', 'Logistics Dashboard') }}</a>
            </div>
        </header>
        <main class="flex-1 flex flex-col items-center justify-center">
            @yield('content')
        </main>
        <footer class="bg-[#3b167c]/90 text-center text-white py-3 text-sm shadow-inner">
            &copy; {{ date('Y') }} Logistics Dashboard. All rights reserved.
        </footer>
    </div>
</body>
</html>
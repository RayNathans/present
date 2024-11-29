<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/animation.css'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Rain Animation -->
    <div id="rain" class="rain">
        @for ($i = 0; $i < 300; $i++)
            <div class="raindrop"
                style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-duration: {{ rand(2, 5) }}s; animation-delay: {{ rand(0, 5) }}s;">
            </div>
        @endfor
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
        <div class="login-container">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm mb-10 mt-4">
                <a href="/">
                    <x-application-logo class="w-20 h-20" />
                </a>
            </div>

            <div class="sm:w-full sm:max-w-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        window.onload = function() {
            document.getElementById('rain').classList.add('active');
        };
    </script>
</body>

</html>

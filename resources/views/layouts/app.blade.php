<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="http://[::1]:5173/resources/css/filament/admin/theme.css" data-navigate-track="reload">
    <link href="{{ asset('css/filament/forms/forms.css?v=3.2.0.0') }}" rel="stylesheet" data-navigate-track />
    <link href="{{ asset('css/filament/filament/app.css') }}" rel="stylesheet" data-navigate-track />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- @include('layouts.navigation') --}}

        @include('components.nav')
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script>
        document.documentElement.classList.remove('dark');
    </script>

    <script src="{{ asset('js/filament/support/async-alpine.js?v=3.1.18.0') }}"></script>


    <script src="{{ asset('js/filament/support/support.js?v=3.1.18.0') }}"></script>



    <script src="{{ asset('js/filament/filament/echo.js?v=3.1.18.0') }}"></script>


    <script src="{{ asset('js/filament/filament/app.js?v=3.1.18.0') }}"></script>
</body>

</html>

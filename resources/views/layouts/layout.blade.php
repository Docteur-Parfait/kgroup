<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>KELISE-GROUPE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link rel="stylesheet" href="http://[::1]:5173/resources/css/filament/admin/theme.css" data-navigate-track="reload"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="icon" href="{{ asset('assets/icon.png') }}" />

</head>

<body>
    <!-- navigation-01 -->
    @include('components.nav')

    @yield('content')

    <!-- footer-01 -->
    <section class="bg-white">
        <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">

            <p class="mt-8 text-base leading-6 text-center text-gray-400">
                © {{ date('Y') }} Kelise Groupe - Lomé, Togo
            </p>
        </div>
    </section>

    <!-- AlpineJS Library -->





</body>

</html>

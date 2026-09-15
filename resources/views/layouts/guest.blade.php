<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kamus Bahasa Tolaki') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-body text-ink antialiased">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-teal-800 paper-texture overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-gold-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -left-16 w-80 h-80 bg-mekongga-500/20 rounded-full blur-3xl"></div>

            <div class="relative">
                <a href="/" class="flex items-center gap-3 justify-center">
                    <div class="w-12 h-12 rounded-2xl bg-gold-500 flex items-center justify-center shadow-pin">
                        <svg class="w-6 h-6 text-teal-900" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 016.5 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="text-left leading-tight">
                        <p class="font-display font-semibold text-sand-50 text-base">Kamus Digital</p>
                        <p class="text-[11px] text-teal-200">Indonesia&nbsp;–&nbsp;Tolaki</p>
                    </div>
                </a>
            </div>

            <div class="relative w-full sm:max-w-md mt-6 px-6 py-8 bg-sand-50 shadow-2xl overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>

            <p class="relative mt-6 text-xs text-teal-200/80 text-center px-6">
                &copy; {{ date('Y') }} Balai Bahasa Provinsi Sulawesi Tenggara &amp; UMK
            </p>
        </div>
    </body>
</html>

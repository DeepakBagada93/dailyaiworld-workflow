<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon / Site Icon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="future-newsroom auth-shell min-h-screen flex flex-col sm:justify-center items-center px-4 py-8 sm:px-6">
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <x-application-logo class="w-12 h-12 rounded-2xl object-cover shadow-lg ring-4 ring-purple-500/20" />
                    <span class="text-left"><strong class="block text-lg leading-none text-[#111323]">Daily AI World</strong><small class="font-mono text-[10px] font-bold uppercase tracking-widest text-[#7047d7]">Member access</small></span>
                </a>
            </div>

            <div class="auth-card w-full sm:max-w-md mt-8 px-6 py-7 overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

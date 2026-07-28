<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#FFFFFF]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Daily AI World — Ultra-Premium Artificial Intelligence Editorial & News')</title>

    <!-- Meta Description & SEO -->
    <meta name="description" content="@yield('meta_description', 'Essential intelligence for AI founders, developers, SaaS builders, and executives. AI Workflows, Tools & Insights for Builders.')">
    <meta name="author" content="Deepak Bagada · CEO, SaaSNext">
    
    <!-- OpenGraph & Twitter Cards -->
    <meta property="og:title" content="@yield('title', 'Daily AI World — Artificial Intelligence Journal')">
    <meta property="og:description" content="@yield('meta_description', 'AI Workflows, Tools & Insights for Builders.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Scripts & CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-[#FFFFFF] text-[#4B5563] selection:bg-[#6D28D9] selection:text-white antialiased"
      x-data="{ 
          audioOpen: false, 
          currentTrack: null,
          isPlaying: false,
          playbackSpeed: 1,
          searchOpen: false,
          bookmarksCount: {{ auth()->check() ? \App\Models\Bookmark::where('user_id', auth()->id())->count() : count(session()->get('bookmarks', [])) }}
      }">

    <!-- Flash Messages Notification -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             class="fixed top-5 right-5 z-50 bg-[#6D28D9] text-white px-5 py-3 rounded-md shadow-xl flex items-center gap-3 font-medium text-sm transition-all duration-300 transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2">
            <svg class="w-5 h-5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 text-purple-200 hover:text-white">&times;</button>
        </div>
    @endif

    <!-- Top Market Ticker Bar -->
    <x-market-ticker />

    <!-- Pure White Header Navigation -->
    <x-nav />

    <!-- Main Content Container -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Sticky Audio Player Component -->
    <x-audio-player />

    <!-- Global Search Modal -->
    <x-search-modal />

    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#FFFFFF]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        @php $pageTitle = View::getSection('title'); @endphp
    @else
        @php $pageTitle = 'Daily AI World — Ultra-Premium Artificial Intelligence Journal'; @endphp
    @endif

    @hasSection('meta_description')
        @php $pageDescription = View::getSection('meta_description'); @endphp
    @else
        @php $pageDescription = 'Essential intelligence for AI founders, developers, SaaS builders, and executives. AI Workflows, Tools & Insights for Builders.'; @endphp
    @endif

    <!-- Global SEO, AEO, and GEO Optimization Head Component -->
    <x-seo-head :title="$pageTitle" :description="$pageDescription" />

    <!-- Site Icon / Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Scripts & CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-[#FFFFFF] text-[var(--text-body)] selection:bg-[#6D28D9] selection:text-white antialiased"
      x-data="{ 
          audioOpen: false, 
          currentTrack: null,
          isPlaying: false,
          playbackSpeed: 1,
          searchOpen: false,
          bookmarksCount: {{ auth()->check() ? \App\Models\Bookmark::where('user_id', auth()->id())->count() : count(session()->get('bookmarks', [])) }}
      }"
      x-init="
          document.documentElement.classList.remove('dark');
          localStorage.setItem('theme', 'light');
      "
      @keydown.window="
          if (($event.key === '/' || ($event.metaKey && $event.key === 'k')) && !['INPUT', 'TEXTAREA'].includes($event.target.tagName)) {
              $event.preventDefault();
              searchOpen = true;
          }
          if ($event.key === 't' && !['INPUT', 'TEXTAREA'].includes($event.target.tagName)) {
              toggleTheme();
          }
          if ($event.key === 'a' && !['INPUT', 'TEXTAREA'].includes($event.target.tagName)) {
              audioOpen = !audioOpen;
          }
      ">

    <!-- Accessible Skip to Main Content Link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-5 focus:py-2.5 focus:bg-[#5B21B6] focus:text-white focus:rounded-xl focus:shadow-2xl focus:outline-none font-sans font-bold text-xs uppercase tracking-wider">
        Skip to main content
    </a>

    <!-- Top Reading Progress Indicator Bar -->
    <div class="fixed top-0 left-0 right-0 h-1.5 bg-purple-950/20 z-50 pointer-events-none" 
         x-data="{ scrollProgress: 0 }" 
         @scroll.window="scrollProgress = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100">
        <div class="h-full bg-gradient-to-r from-[#5B21B6] via-purple-500 to-indigo-400 transition-all duration-150 shadow-sm" 
             :style="'width: ' + scrollProgress + '%'"></div>
    </div>

    <!-- Flash Messages Notification -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             class="fixed top-5 right-5 z-50 bg-[#5B21B6] text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 font-medium text-sm transition-all duration-300 transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             role="status" aria-live="polite">
            <svg class="w-5 h-5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 text-purple-200 hover:text-white" aria-label="Dismiss alert">&times;</button>
        </div>
    @endif

    <!-- Header Navigation Component -->
    <x-nav />

    <!-- Main Content Landmark -->
    <main id="main-content" class="flex-grow focus:outline-none" tabindex="-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Sticky Audio Player Component -->
    <x-audio-player />

    <!-- Global Search Modal -->
    <x-search-modal />

    <!-- Floating Accessibility & Preferences Control Panel -->
    <x-accessibility-widget />

    @stack('scripts')
</body>
</html>

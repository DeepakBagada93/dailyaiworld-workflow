<!DOCTYPE html>
<html lang="en" class="dark" x-data="{ commandPaletteOpen: false, autosaving: false, savedAt: 'Just now' }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Daily AI World — Enterprise Editorial CMS')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0B0B0F] text-[#D1D5DB] font-sans min-h-screen flex flex-col antialiased selection:bg-[#6D28D9] selection:text-white"
      @keydown.cmd.k.window.prevent="commandPaletteOpen = true"
      @keydown.escape.window="commandPaletteOpen = false">

    <!-- Top Linear/Vercel Command Header -->
    <header class="h-14 border-b border-[#1F1F2E] bg-[#0E0E14] sticky top-0 z-40 px-6 flex items-center justify-between text-xs font-mono">
        <!-- Left: Workspace & Branch Badge -->
        <div class="flex items-center gap-4">
            <a href="{{ route('cms.dashboard') }}" class="flex items-center gap-2 font-serif font-bold text-base text-white hover:text-[#8B5CF6] transition-colors">
                <span class="w-2 h-2 rounded-full bg-[#8B5CF6] animate-pulse"></span>
                <span>Daily AI World</span>
            </a>
            <span class="text-gray-600">/</span>
            <div class="flex items-center gap-2 bg-[#161622] border border-[#272738] px-2.5 py-1 rounded-md text-[11px] text-gray-300">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>prod-main@d9a4f</span>
            </div>
        </div>

        <!-- Center: Autosave Status -->
        <div class="hidden md:flex items-center gap-2 text-[11px] text-gray-400">
            <template x-if="autosaving">
                <span class="flex items-center gap-1.5 text-amber-400">
                    <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Autosaving changes...</span>
                </span>
            </template>
            <template x-if="!autosaving">
                <span class="flex items-center gap-1.5 text-gray-500">
                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>All changes saved (<span x-text="savedAt"></span>)</span>
                </span>
            </template>
        </div>

        <!-- Right: Command Palette Trigger & Quick Draft -->
        <div class="flex items-center gap-3">
            <button @click="commandPaletteOpen = true" 
                    class="bg-[#161622] hover:bg-[#1E1B2E] border border-[#272738] px-3 py-1.5 rounded-md text-gray-400 hover:text-white flex items-center gap-2 text-[11px] transition-all">
                <svg class="w-3.5 h-3.5 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Command Menu</span>
                <kbd class="bg-[#242436] px-1.5 py-0.5 rounded text-[10px] text-gray-300">⌘K</kbd>
            </button>

            <a href="{{ route('cms.posts.create') }}" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-3 py-1.5 rounded-md text-xs font-semibold flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>New Story</span>
            </a>

            <a href="{{ route('home') }}" target="_blank" class="p-1.5 text-gray-400 hover:text-white transition-colors" title="View Public Journal">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </header>

    <div class="flex-grow flex">
        
        <!-- LINEAR / VERCEL STYLE SIDEBAR -->
        <aside class="w-64 border-r border-[#1F1F2E] bg-[#0E0E14] flex flex-col justify-between py-6 px-4 shrink-0 text-xs font-medium">
            <div class="space-y-6">
                <!-- Section 1: Editorial Operations -->
                <div>
                    <span class="px-3 text-[10px] font-mono uppercase tracking-widest text-gray-500 font-bold block mb-2">Editorial Core</span>
                    <nav class="space-y-1">
                        <a href="{{ route('cms.dashboard') }}" class="{{ request()->routeIs('cms.dashboard') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('cms.posts') }}" class="{{ request()->routeIs('cms.posts') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <span>All Stories</span>
                            <span class="ml-auto font-mono text-[10px] px-1.5 py-0.5 rounded bg-[#242436] text-gray-300">
                                {{ \App\Models\Article::count() }}
                            </span>
                        </a>

                        <a href="{{ route('cms.drafts') }}" class="{{ request()->routeIs('cms.drafts') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span>Drafts</span>
                        </a>

                        <a href="{{ route('cms.scheduled') }}" class="{{ request()->routeIs('cms.scheduled') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Scheduled Dispatches</span>
                        </a>

                        <a href="{{ route('cms.categories') }}" class="{{ request()->routeIs('cms.categories') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span>Desks & Tags</span>
                        </a>

                        <a href="{{ route('cms.authors') }}" class="{{ request()->routeIs('cms.authors') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Columnists</span>
                        </a>

                        <a href="{{ route('cms.media') }}" class="{{ request()->routeIs('cms.media') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Media Library</span>
                        </a>
                    </nav>
                </div>

                <!-- Section 2: Intelligence & Systems -->
                <div>
                    <span class="px-3 text-[10px] font-mono uppercase tracking-widest text-gray-500 font-bold block mb-2">AI & Intelligence</span>
                    <nav class="space-y-1">
                        <a href="{{ route('cms.ai-studio') }}" class="{{ request()->routeIs('cms.ai-studio') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>AI Content Studio</span>
                        </a>

                        <a href="{{ route('cms.research-queue') }}" class="{{ request()->routeIs('cms.research-queue') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            <span>Research Queue</span>
                        </a>

                        <a href="{{ route('cms.internal-linking') }}" class="{{ request()->routeIs('cms.internal-linking') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <span>Internal Graph</span>
                        </a>

                        <a href="{{ route('cms.analytics') }}" class="{{ request()->routeIs('cms.analytics') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span>Analytics</span>
                        </a>

                        <a href="{{ route('cms.seo') }}" class="{{ request()->routeIs('cms.seo') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                            <span>SEO & Schemas</span>
                        </a>

                        <a href="{{ route('cms.deployment') }}" class="{{ request()->routeIs('cms.deployment') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Deployment & CI/CD</span>
                        </a>

                        <a href="{{ route('cms.settings') }}" class="{{ request()->routeIs('cms.settings') ? 'bg-[#1E1B2E] text-[#C4B5FD] font-semibold border-l-2 border-[#8B5CF6]' : 'text-gray-400 hover:bg-[#161622] hover:text-white' }} px-3 py-2 rounded-r-md flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>System Settings</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Footer: User & System Status -->
            <div class="border-t border-[#1F1F2E] pt-4 font-mono text-[11px] text-gray-500 space-y-2">
                <div class="flex items-center justify-between">
                    <span>Hostinger Deployment</span>
                    <span class="text-emerald-400 font-semibold">Active</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-[#8B5CF6] text-white flex items-center justify-center font-bold text-[10px]">
                        EB
                    </div>
                    <div>
                        <span class="block text-gray-300 font-sans text-xs font-semibold">Editorial Board</span>
                        <span class="text-[10px] text-gray-500">Super Admin</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CMS CONTENT CANVAS -->
        <main class="flex-grow p-6 sm:p-8 bg-[#0B0B0F] overflow-y-auto">
            @yield('content')
        </main>

    </div>

    <!-- LINEAR COMMAND PALETTE (⌘K) -->
    <div x-show="commandPaletteOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20 flex justify-center"
         role="dialog" aria-modal="true">
        
        <div x-show="commandPaletteOpen" 
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="commandPaletteOpen = false"
             class="fixed inset-0 bg-black/75 backdrop-blur-sm"></div>

        <div x-show="commandPaletteOpen"
             x-transition:enter="transition-all ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition-all ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-xl bg-[#14141E] rounded-xl shadow-2xl border border-[#272738] overflow-hidden self-start mt-12 font-mono text-xs text-gray-300">
            
            <div class="flex items-center px-4 py-3 border-b border-[#272738]">
                <svg class="w-4 h-4 text-[#8B5CF6] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Type a command or search modules..." 
                       class="w-full bg-transparent text-white placeholder-gray-500 text-sm focus:outline-none"
                       x-init="$watch('commandPaletteOpen', value => { if (value) $nextTick(() => $el.focus()); })">
                <span class="text-[10px] text-gray-500 border border-[#272738] px-1.5 py-0.5 rounded">ESC</span>
            </div>

            <div class="p-2 space-y-1">
                <div class="px-3 py-1 text-[10px] text-gray-500 uppercase font-semibold">Quick Actions</div>
                <a href="{{ route('cms.posts.create') }}" class="flex items-center justify-between px-3 py-2 rounded-md hover:bg-[#1E1B2E] hover:text-white transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Draft New Editorial Story</span>
                    </span>
                    <kbd class="text-[10px] bg-[#242436] px-1.5 py-0.5 rounded text-gray-400">⌘N</kbd>
                </a>
                <a href="{{ route('cms.ai-studio') }}" class="flex items-center justify-between px-3 py-2 rounded-md hover:bg-[#1E1B2E] hover:text-white transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Open AI Content Studio</span>
                    </span>
                    <kbd class="text-[10px] bg-[#242436] px-1.5 py-0.5 rounded text-gray-400">⌘A</kbd>
                </a>
                <a href="{{ route('cms.posts') }}" class="flex items-center justify-between px-3 py-2 rounded-md hover:bg-[#1E1B2E] hover:text-white transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>View All Articles</span>
                    </span>
                    <kbd class="text-[10px] bg-[#242436] px-1.5 py-0.5 rounded text-gray-400">G P</kbd>
                </a>
                <a href="{{ route('cms.analytics') }}" class="flex items-center justify-between px-3 py-2 rounded-md hover:bg-[#1E1B2E] hover:text-white transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>View Traffic Analytics</span>
                    </span>
                    <kbd class="text-[10px] bg-[#242436] px-1.5 py-0.5 rounded text-gray-400">G A</kbd>
                </a>
            </div>

            <div class="p-3 bg-[#0E0E14] border-t border-[#272738] flex items-center justify-between text-[10px] text-gray-500">
                <span>Press <kbd class="px-1 py-0.5 bg-[#242436] text-gray-300 rounded">↑</kbd> <kbd class="px-1 py-0.5 bg-[#242436] text-gray-300 rounded">↓</kbd> to navigate</span>
                <span>Press <kbd class="px-1 py-0.5 bg-[#242436] text-gray-300 rounded">↵</kbd> to execute</span>
            </div>
        </div>
    </div>

</body>
</html>

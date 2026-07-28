@php
    $categories = \App\Models\Category::where('is_featured', true)->get();
@endphp

<header class="border-b border-[var(--border-subtle)] bg-[var(--bg-main)] sticky top-0 z-40 backdrop-blur-md bg-opacity-95 dark:bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Primary Brand Line -->
        <div class="py-5 flex items-center justify-between border-b border-[var(--border-subtle)]">
            <!-- Left: Edition Indicator -->
            <div class="hidden lg:flex items-center gap-3 text-xs tracking-wider text-[var(--text-muted)] font-mono uppercase">
                <span class="inline-block w-2 h-2 rounded-full bg-[#6D28D9]"></span>
                <span>VOL. IV • GLOBAL EDITION</span>
            </div>

            <!-- Center: Publication Title -->
            <div class="text-center mx-auto lg:mx-0">
                <a href="{{ route('home') }}" class="group inline-block">
                    <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors">
                        Daily AI World
                    </h1>
                    <p class="text-[10px] sm:text-xs font-mono uppercase tracking-[0.25em] text-[var(--text-muted)] mt-1">
                        The Journal of Artificial Intelligence & Compute Infrastructure
                    </p>
                </a>
            </div>

            <!-- Right: Actions (Search, Bookmarks, Theme, Auth) -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Search Button -->
                <button @click="searchOpen = true" 
                        class="p-2 text-[var(--text-muted)] hover:text-[#6D28D9] hover:bg-[var(--bg-muted)] rounded-md transition-all flex items-center gap-1.5 text-xs font-medium"
                        title="Search Articles">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="hidden sm:inline font-mono">⌘K</span>
                </button>

                <!-- Bookmarks Link -->
                <a href="{{ route('bookmarks.index') }}" 
                   class="relative p-2 text-[var(--text-muted)] hover:text-[#6D28D9] hover:bg-[var(--bg-muted)] rounded-md transition-all flex items-center gap-1"
                   title="Saved Articles">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <span x-show="bookmarksCount > 0" 
                          x-text="bookmarksCount" 
                          class="absolute -top-1 -right-1 bg-[#6D28D9] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                    </span>
                </a>

                <!-- Dark Mode Switcher -->
                <button @click="darkMode = !darkMode" 
                        class="p-2 text-[var(--text-muted)] hover:text-[#6D28D9] hover:bg-[var(--bg-muted)] rounded-md transition-all"
                        title="Toggle Dark Mode">
                    <template x-if="!darkMode">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                    <template x-if="darkMode">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                </button>

                <!-- Editorial Dashboard / Auth Link -->
                @auth
                    <a href="{{ route('editorial.dashboard') }}" class="btn-primary py-1.5 px-3 text-xs hidden sm:inline-flex">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline py-1.5 px-3 text-xs">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>

        <!-- Secondary Section Navigation Bar -->
        <nav class="flex items-center justify-between overflow-x-auto no-scrollbar py-3 text-xs font-medium uppercase tracking-wider text-[var(--text-body)]">
            <div class="flex items-center gap-6 sm:gap-8 whitespace-nowrap">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                    Front Page
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" 
                       class="{{ request()->is('category/'.$cat->slug) ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Right Quick Link -->
            <div class="hidden lg:flex items-center gap-4 text-[11px] font-mono text-[var(--text-muted)]">
                <a href="{{ route('design-system') }}" class="hover:text-[#6D28D9] transition-colors">Design Specs</a>
            </div>
        </nav>

    </div>
</header>

<header class="border-b border-[#E8E7EF] dark:border-[#272738] bg-[#FFFFFF] dark:bg-[#0B0B0F] sticky top-0 z-40 shadow-sm backdrop-blur-md bg-opacity-95 dark:bg-opacity-95 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[64px] lg:h-[72px] flex items-center justify-between gap-4">
        
        <!-- Left: Logo & Brand Tagline -->
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('home') }}" class="group flex items-center gap-2.5 focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
                <span class="w-3 h-3 rounded-full bg-[#6D28D9] group-hover:scale-125 transition-transform"></span>
                <div>
                    <span class="font-serif text-xl sm:text-2xl font-extrabold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-none block">
                        Daily AI World
                    </span>
                    <span class="hidden xl:block text-[9px] font-mono uppercase tracking-widest text-[var(--text-muted)] mt-0.5">
                        AI Workflows, Tools & Insights for Builders
                    </span>
                </div>
            </a>
        </div>

        <!-- Center: FIXED Primary Navigation (Workflows, Insights, Categories, Community, Tools) -->
        <nav class="hidden md:flex items-center gap-6 lg:gap-8 font-sans text-xs font-semibold text-[var(--text-heading)] tracking-wide uppercase">
            <a href="{{ route('categories.show', 'ai-workflows') }}" 
               class="{{ request()->is('category/ai-workflows') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                Workflows
            </a>
            <a href="{{ route('home') }}" 
               class="{{ request()->routeIs('home') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                Insights
            </a>
            <a href="{{ route('categories.show', 'coding') }}" 
               class="{{ request()->is('category/coding') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                Categories
            </a>
            <a href="{{ route('bookmarks.index') }}" 
               class="{{ request()->routeIs('bookmarks.index') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                Community
            </a>
            <a href="{{ route('categories.show', 'ai-tools') }}" 
               class="{{ request()->is('category/ai-tools') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                Tools
            </a>
        </nav>

        <!-- Right Utilities: Search, Newsletter, Theme, Profile/Login -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <!-- Search Launcher -->
            <button @click="searchOpen = true" 
                    class="p-2 text-[var(--text-muted)] hover:text-[#6D28D9] hover:bg-[var(--bg-muted)] rounded-md transition-all flex items-center gap-1.5 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#6D28D9]"
                    title="Search Articles (⌘K)"
                    aria-label="Open search dialog">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span class="hidden lg:inline font-mono text-[10px]">⌘K</span>
            </button>

            <!-- Bookmarks -->
            <a href="{{ route('bookmarks.index') }}" 
               class="relative p-2 text-[var(--text-muted)] hover:text-[#6D28D9] hover:bg-[var(--bg-muted)] rounded-md transition-all focus:outline-none focus:ring-2 focus:ring-[#6D28D9]"
               title="Saved Reading List"
               aria-label="View saved reading list">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                <span x-show="bookmarksCount > 0" 
                      x-text="bookmarksCount" 
                      class="absolute -top-1 -right-1 bg-[#6D28D9] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                </span>
            </a>

            <!-- Dark Mode Toggle -->
            <button @click="darkMode = !darkMode" 
                    class="p-2 text-[var(--text-muted)] hover:text-[#6D28D9] hover:bg-[var(--bg-muted)] rounded-md transition-all focus:outline-none focus:ring-2 focus:ring-[#6D28D9]"
                    title="Toggle Dark Mode"
                    aria-label="Toggle dark mode theme">
                <template x-if="!darkMode">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </template>
                <template x-if="darkMode">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </template>
            </button>

            <!-- Profile / Login -->
            @auth
                <a href="{{ route('cms.dashboard') }}" class="btn-primary py-1.5 px-3 text-xs hidden sm:inline-flex focus:outline-none focus:ring-2 focus:ring-[#6D28D9]">
                    Portal
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline py-1.5 px-3 text-xs focus:outline-none focus:ring-2 focus:ring-[#6D28D9]">
                    Sign In
                </a>
            @endauth
        </div>

    </div>
</header>

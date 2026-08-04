<header class="border-b border-[#E9D5FF] bg-[#FFFFFF] sticky top-0 z-40 shadow-xs backdrop-blur-md bg-opacity-95 transition-colors"
        x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[64px] lg:h-[72px] flex items-center justify-between gap-4">
        
        <!-- Left: Logo & Brand Tagline -->
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('home') }}" class="group flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Daily AI World Logo" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full object-cover ring-2 ring-[#6D28D9]/20 group-hover:ring-[#6D28D9] transition-all shrink-0 shadow-xs author-avatar-img">
                <div>
                    <span class="font-serif text-xl sm:text-2xl font-extrabold text-[#1E1B4B] group-hover:text-[#6D28D9] transition-colors leading-none block">
                        Daily AI World
                    </span>
                    <span class="hidden sm:block text-[9px] font-mono uppercase tracking-widest text-[#6B7280] mt-0.5">
                        AI Workflows, Tools & Insights for Builders
                    </span>
                </div>
            </a>
        </div>

        <!-- Center: Desktop Primary Navigation -->
        <nav aria-label="Primary Navigation" class="hidden md:flex items-center gap-6 lg:gap-8 font-sans text-xs font-semibold text-[#1E1B4B] tracking-wide uppercase">
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
            <a href="{{ route('categories.show', 'ai-tools') }}" 
               class="{{ request()->is('category/ai-tools') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                Tools
            </a>
            <a href="{{ route('advertise') }}" 
               class="{{ request()->routeIs('advertise') ? 'text-[#6D28D9] font-bold border-b-2 border-[#6D28D9] pb-0.5' : 'hover:text-[#6D28D9] transition-colors' }}">
                Sponsor
            </a>
            <a href="{{ route('subscribe') }}" 
               class="bg-[#FAF5FF] text-[#6D28D9] hover:bg-[#F3E8FF] px-2.5 py-1 rounded-md transition-colors text-[11px] font-bold border border-[#E9D5FF]">
                Executive Tier
            </a>
        </nav>

        <!-- Right Utilities: Search, Portal & Mobile Hamburger Button -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <!-- Search Launcher -->
            <button @click="searchOpen = true" 
                    class="p-2 text-[#374151] hover:text-[#6D28D9] hover:bg-[#FAF5FF] rounded-lg transition-all flex items-center gap-1.5 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#6D28D9]"
                    title="Search Articles (⌘K or /)"
                    aria-label="Open search dialog">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span class="hidden lg:inline font-mono text-[10px] text-[#6B7280]">⌘K</span>
            </button>

            @auth
                <a href="{{ route('cms.dashboard') }}" class="btn-primary py-1.5 px-3 text-xs hidden sm:inline-flex focus:outline-none focus:ring-2 focus:ring-[#6D28D9]">
                    Portal
                </a>
            @endauth

            <!-- Hamburger Button for Mobile screens (< md) -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="md:hidden p-2 text-[var(--text-heading)] hover:text-[#6D28D9] hover:bg-[var(--bg-muted)] rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-[#6D28D9]"
                    :aria-expanded="mobileMenuOpen"
                    aria-controls="mobile-navigation"
                    aria-label="Toggle mobile navigation menu">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Dropdown Navigation Menu Drawer -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-[#E8E7EF] bg-white px-4 pt-3 pb-6 space-y-2 font-sans text-xs font-semibold uppercase tracking-wider text-[#111827] shadow-lg">
        <a href="{{ route('categories.show', 'ai-workflows') }}" 
           class="block px-3 py-2 rounded-md hover:bg-[#F5F3FF] hover:text-[#6D28D9] transition-colors {{ request()->is('category/ai-workflows') ? 'text-[#6D28D9] font-bold bg-[#F5F3FF]' : '' }}">
            Workflows
        </a>
        <a href="{{ route('home') }}" 
           class="block px-3 py-2 rounded-md hover:bg-[#F5F3FF] hover:text-[#6D28D9] transition-colors {{ request()->routeIs('home') ? 'text-[#6D28D9] font-bold bg-[#F5F3FF]' : '' }}">
            Insights
        </a>
        <a href="{{ route('categories.show', 'coding') }}" 
           class="block px-3 py-2 rounded-md hover:bg-[#F5F3FF] hover:text-[#6D28D9] transition-colors {{ request()->is('category/coding') ? 'text-[#6D28D9] font-bold bg-[#F5F3FF]' : '' }}">
            Categories
        </a>
        <a href="{{ route('categories.show', 'ai-tools') }}" 
           class="block px-3 py-2 rounded-md hover:bg-[#F5F3FF] hover:text-[#6D28D9] transition-colors {{ request()->is('category/ai-tools') ? 'text-[#6D28D9] font-bold bg-[#F5F3FF]' : '' }}">
            Tools
        </a>
        <a href="{{ route('advertise') }}" 
           class="block px-3 py-2 rounded-md hover:bg-[#F5F3FF] hover:text-[#6D28D9] transition-colors {{ request()->routeIs('advertise') ? 'text-[#6D28D9] font-bold bg-[#F5F3FF]' : '' }}">
            Sponsor Rate Card
        </a>
        <a href="{{ route('subscribe') }}" 
           class="block px-3 py-2 rounded-md bg-purple-50 text-[#6D28D9] font-bold">
            Executive Tier Pass
        </a>
        @auth
            <a href="{{ route('cms.dashboard') }}" 
               class="block px-3 py-2 rounded-md bg-[#6D28D9] text-white text-center font-bold mt-2">
                Portal
            </a>
        @endauth
    </div>
</header>

<header class="border-b border-[#E9D5FF]/80 bg-white/90 backdrop-blur-xl sticky top-0 z-50 transition-all duration-300 shadow-xs"
        x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[64px] lg:h-[76px] flex items-center justify-between gap-4">
        
        <!-- Left: Logo & Brand Tagline -->
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('home') }}" class="group flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded-xl p-1">
                <div class="relative">
                    <img src="{{ asset('images/logo.png') }}" alt="Daily AI World Logo" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl object-cover ring-2 ring-[#6D28D9]/30 group-hover:ring-[#6D28D9] group-hover:scale-105 transition-all duration-300 shrink-0 shadow-sm author-avatar-img">
                    <span class="absolute -top-0.5 -right-0.5 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6D28D9] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#6D28D9]"></span>
                    </span>
                </div>
                <div>
                    <span class="font-serif text-xl sm:text-2xl font-extrabold text-[#1E1B4B] group-hover:text-[#6D28D9] transition-colors leading-none block tracking-tight">
                        Daily AI World
                    </span>
                    <span class="hidden sm:flex items-center gap-1.5 text-[10px] font-mono uppercase tracking-widest text-[#6D28D9] font-bold mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#6D28D9]"></span>
                        <span>Intelligence Journal</span>
                    </span>
                </div>
            </a>
        </div>

        <!-- Center: Desktop Primary Navigation with Hover Glow Pills -->
        <nav aria-label="Primary Navigation" class="hidden md:flex items-center gap-1 lg:gap-2 font-sans text-xs font-bold text-[#1E1B4B] tracking-wide uppercase">
            <a href="{{ route('workflows.index') }}" 
               class="px-3.5 py-2 rounded-lg transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('workflows.index') ? 'text-[#6D28D9] bg-[#FAF5FF] border border-[#E9D5FF] font-extrabold shadow-2xs' : 'hover:text-[#6D28D9] hover:bg-[#FAF5FF]' }}">
                <span>Workflows</span>
            </a>
            <a href="{{ route('mcp.index') }}" 
               class="px-3.5 py-2 rounded-lg transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('mcp.index') ? 'text-[#6D28D9] bg-[#FAF5FF] border border-[#E9D5FF] font-extrabold shadow-2xs' : 'hover:text-[#6D28D9] hover:bg-[#FAF5FF]' }}">
                <span>MCP Directory</span>
            </a>
            <a href="{{ route('news.index') }}" 
               class="px-3.5 py-2 rounded-lg transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('news.index') ? 'text-[#6D28D9] bg-[#FAF5FF] border border-[#E9D5FF] font-extrabold shadow-2xs' : 'hover:text-[#6D28D9] hover:bg-[#FAF5FF]' }}">
                <span>Realtime News</span>
            </a>
            <a href="{{ route('advertise') }}#sponsor-tier" 
               class="px-3.5 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('advertise') ? 'text-[#6D28D9] bg-[#FAF5FF] border border-[#E9D5FF] font-extrabold shadow-2xs' : 'hover:text-[#6D28D9] hover:bg-[#FAF5FF]' }}">
                <span>Sponsor</span>
            </a>
        </nav>

        <!-- Right Utilities: Interactive Search, Executive Pass CTA & Mobile Hamburger -->
        <div class="flex items-center gap-2.5 sm:gap-3.5 shrink-0">
            
            <!-- Quick Search Bar Button Launcher -->
            <button @click="searchOpen = true" 
                    class="bg-[#FAF5FF] hover:bg-[#F3E8FF] border border-[#E9D5FF] px-3 py-1.5 rounded-xl transition-all flex items-center gap-2 text-xs font-semibold text-[#1E1B4B] hover:text-[#6D28D9] focus:outline-none focus:ring-2 focus:ring-[#6D28D9] shadow-2xs group"
                    title="Search Journal (⌘K or /)"
                    aria-label="Open search dialog">
                <svg class="w-4 h-4 text-[#6D28D9] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span class="hidden sm:inline font-sans text-xs text-[#374151]">Search</span>
                <span class="hidden lg:inline-block font-mono text-[10px] bg-white text-[#6D28D9] px-1.5 py-0.5 rounded border border-[#E9D5FF] font-bold">⌘K</span>
            </button>

            <!-- Executive Pass Button -->
            <a href="{{ route('subscribe') }}#executive-tier" 
               class="bg-gradient-to-r from-[#6D28D9] to-[#7C3AED] hover:from-[#5B21B6] hover:to-[#6D28D9] text-white px-3.5 py-2 rounded-xl transition-all duration-300 text-xs font-extrabold tracking-wide uppercase shadow-sm hover:shadow-md hover:shadow-purple-500/20 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span class="hidden sm:inline">Executive Pass</span>
                <span class="sm:hidden">Pass</span>
            </a>

            @auth
                <a href="{{ route('cms.dashboard') }}" class="bg-[#1E1B4B] hover:bg-[#312E81] text-white px-3 py-2 rounded-xl text-xs font-bold font-mono transition-all">
                    Portal
                </a>
            @endauth

            <!-- Hamburger Button for Mobile screens (< md) -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="md:hidden p-2 text-[#1E1B4B] hover:text-[#6D28D9] hover:bg-[#FAF5FF] rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-[#6D28D9]"
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
         class="md:hidden border-t border-[#E9D5FF] bg-white px-4 pt-3 pb-6 space-y-2 font-sans text-xs font-bold uppercase tracking-wider text-[#1E1B4B] shadow-xl">
        <a href="{{ route('workflows.index') }}" 
           class="block px-3.5 py-2.5 rounded-xl hover:bg-[#FAF5FF] hover:text-[#6D28D9] transition-colors {{ request()->routeIs('workflows.index') ? 'text-[#6D28D9] bg-[#FAF5FF] font-bold' : '' }}">
            ⚡ Workflows Library
        </a>
        <a href="{{ route('mcp.index') }}" 
           class="block px-3.5 py-2.5 rounded-xl hover:bg-[#FAF5FF] hover:text-[#6D28D9] transition-colors {{ request()->routeIs('mcp.index') ? 'text-[#6D28D9] bg-[#FAF5FF] font-bold' : '' }}">
            🛠️ MCP Directory
        </a>
        <a href="{{ route('news.index') }}" 
           class="block px-3.5 py-2.5 rounded-xl hover:bg-[#FAF5FF] hover:text-[#6D28D9] transition-colors {{ request()->routeIs('news.index') ? 'text-[#6D28D9] bg-[#FAF5FF] font-bold' : '' }}">
            📰 Realtime AI News
        </a>
        <a href="{{ route('advertise') }}#sponsor-tier" 
           class="block px-3.5 py-2.5 rounded-xl hover:bg-[#FAF5FF] hover:text-[#6D28D9] transition-colors {{ request()->routeIs('advertise') ? 'text-[#6D28D9] bg-[#FAF5FF] font-bold' : '' }}">
            💼 Sponsor Tier
        </a>
        <a href="{{ route('subscribe') }}#executive-tier" 
           class="block px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#7C3AED] text-white text-center font-extrabold mt-2">
            ⭐ Executive Pass Access
        </a>
        @auth
            <a href="{{ route('cms.dashboard') }}" 
               class="block px-3.5 py-2.5 rounded-xl bg-[#1E1B4B] text-white text-center font-bold font-mono">
                Portal
            </a>
        @endauth
    </div>
</header>

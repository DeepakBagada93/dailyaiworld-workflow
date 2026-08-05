@extends('layouts.editorial')

@section('title', 'Daily AI World — Minimalist AI Journal & Intelligence')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16">

    <!-- MINIMALIST MAGAZINE MASTHEAD BANNER -->
    <div class="border-y border-[#E9D5FF] py-3 flex flex-wrap items-center justify-between gap-4 font-mono text-[11px] uppercase tracking-widest text-[#6D28D9] font-bold bg-[#FAF5FF]/50 px-4 rounded-lg">
        <div class="flex items-center gap-3">
            <span class="inline-block w-2 h-2 rounded-full bg-[#6D28D9]"></span>
            <span>VOL. 26 · ISSUE 04</span>
        </div>
        <span class="hidden md:inline text-[#6B7280]">DAILY AI WORLD JOURNAL</span>
        <div class="flex items-center gap-3">
            <span class="text-[#6B7280]">REALTIME EDITION</span>
            <span>•</span>
            <span class="text-[#5B21B6]">{{ date('F Y') }}</span>
        </div>
    </div>

    <!-- 1. FEATURED COVER STORY (Minimalist Magazine Lead Feature with Animated SVG & Typewriter) -->
    @if($heroArticle)
        <section class="relative border-b border-[#E9D5FF] pb-14 overflow-hidden" 
                 x-data="{ 
                     textArray: ['Building Enterprise AI Workflows...', 'Frontier Compute & Agentic Systems...', 'Scaling LLM Architectures in 2026...'],
                     displayText: '',
                     arrayIndex: 0,
                     charIndex: 0,
                     isDeleting: false,
                     typeSpeed: 80,
                     initTypewriter() {
                         let currentString = this.textArray[this.arrayIndex];
                         if (this.isDeleting) {
                             this.displayText = currentString.substring(0, this.charIndex - 1);
                             this.charIndex--;
                             this.typeSpeed = 35;
                         } else {
                             this.displayText = currentString.substring(0, this.charIndex + 1);
                             this.charIndex++;
                             this.typeSpeed = 80;
                         }

                         if (!this.isDeleting && this.charIndex === currentString.length) {
                             this.isDeleting = true;
                             this.typeSpeed = 2000;
                         } else if (this.isDeleting && this.charIndex === 0) {
                             this.isDeleting = false;
                             this.arrayIndex = (this.arrayIndex + 1) % this.textArray.length;
                             this.typeSpeed = 350;
                         }

                         setTimeout(() => this.initTypewriter(), this.typeSpeed);
                     }
                 }"
                 x-init="initTypewriter()">

            <!-- Background Ambient SVG Grid -->
            <div class="absolute -top-12 -right-12 w-96 h-96 opacity-25 pointer-events-none">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full animate-orbital-spin">
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#6D28D9" stroke-width="1" stroke-dasharray="4,8"/>
                    <circle cx="100" cy="100" r="55" fill="none" stroke="#7C3AED" stroke-width="1.5" stroke-dasharray="6,6"/>
                    <circle cx="180" cy="100" r="6" fill="#6D28D9"/>
                    <circle cx="100" cy="20" r="4" fill="#7C3AED"/>
                    <circle cx="45" cy="145" r="5" fill="#5B21B6"/>
                </svg>
            </div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
                <!-- Left 8 Cols: Main Cover Story & Typewriter -->
                <div class="lg:col-span-8 flex flex-col justify-between space-y-6">
                    <div>
                        <!-- Typewriter Header Badge -->
                        <div class="flex flex-wrap items-center gap-3 mb-5 font-mono text-xs">
                            <span class="bg-[#FAF5FF] text-[#6D28D9] px-3 py-1 rounded-full font-bold uppercase tracking-wider text-[11px] border border-[#E9D5FF] flex items-center gap-2 shadow-2xs">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6D28D9] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#6D28D9]"></span>
                                </span>
                                <span>Lead Feature</span>
                            </span>

                            <span class="text-[#6B7280]">•</span>

                            <!-- Animated Typewriter Live Field -->
                            <div class="inline-flex items-center gap-1 text-[#374151] font-mono text-xs bg-[#FAF5FF] px-3 py-1 rounded-full border border-[#E9D5FF]">
                                <span class="font-bold text-[#6D28D9] typewriter-cursor font-mono" x-text="displayText"></span>
                            </div>

                            <span class="text-[#6B7280]">•</span>
                            <span class="text-[#6B7280] font-mono text-xs">{{ $heroArticle->reading_time }} min read</span>
                        </div>

                        <!-- Hero Cover Title -->
                        <a href="{{ $heroArticle->url }}" class="group block">
                            <h1 class="font-sans text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[#1E1B4B] group-hover:text-[#6D28D9] transition-colors leading-[1.06] tracking-tight">
                                {{ $heroArticle->title }}
                            </h1>
                        </a>

                        @if($heroArticle->deck)
                            <p class="text-base sm:text-lg text-[#374151] mt-5 leading-relaxed font-sans font-normal max-w-3xl">
                                {{ $heroArticle->deck }}
                            </p>
                        @endif
                    </div>

                    <!-- Executive Takeaways Card -->
                    @if(!empty($heroArticle->key_takeaways))
                        <div class="bg-[#FAF5FF] border-l-4 border-[#6D28D9] rounded-r-2xl p-5 my-2 border border-y border-r-[#E9D5FF] shadow-xs">
                            <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-[#6D28D9] font-bold mb-3">
                                <svg class="w-4 h-4 text-[#6D28D9] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>Executive Key Takeaways</span>
                            </div>
                            <ul class="space-y-2.5 text-xs sm:text-sm text-[#1E1B4B] font-sans">
                                @foreach($heroArticle->key_takeaways as $takeaway)
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-[#6D28D9] font-bold shrink-0 mt-0.5">•</span>
                                        <span class="leading-relaxed">{{ $takeaway }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Cover Story Author Signature Meta -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-5 border-t border-[#E9D5FF] font-mono text-xs text-[#6B7280]">
                        <div class="flex items-center gap-3">
                            @if($heroArticle->author->avatar)
                                <img src="{{ $heroArticle->author->avatar }}" alt="{{ $heroArticle->author->name }}" class="w-11 h-11 rounded-xl object-cover shrink-0 aspect-square border border-[#E9D5FF] ring-2 ring-[#6D28D9]/20 author-avatar-cover shadow-sm transition-all duration-300">
                            @else
                                <div class="w-11 h-11 rounded-xl bg-purple-100 text-[#6D28D9] flex items-center justify-center font-bold text-sm shrink-0 border border-[#E9D5FF] ring-2 ring-[#6D28D9]/20 font-sans shadow-sm">
                                    {{ substr($heroArticle->author->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <span class="block text-[#1E1B4B] font-sans font-bold text-xs">{{ $heroArticle->author->name }}</span>
                                <span class="text-[11px] text-[#6B7280]">{{ $heroArticle->author->title }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span>Published {{ $heroArticle->formatted_date }}</span>
                            <span>•</span>
                            <button @click="audioOpen = true; isPlaying = true; currentTrack = { title: '{{ addslashes($heroArticle->title) }}', author: '{{ addslashes($heroArticle->author->name) }}' }"
                                    class="bg-[#FAF5FF] hover:bg-[#F3E8FF] text-[#6D28D9] border border-[#E9D5FF] text-xs py-1.5 px-3.5 rounded-xl flex items-center gap-2 font-bold transition-all shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-[#6D28D9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                                <span>Listen Story</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right 4 Cols: 3D Interactive Card Stack Shuffler -->
                <div class="lg:col-span-4 flex"
                     x-data="{ 
                         activeTab: 0,
                         totalTabs: {{ isset($latestNews) && $latestNews->count() > 0 ? $latestNews->count() : 3 }},
                         autoInterval: null,
                         isHovered: false,
                         initCarousel() {
                             this.startAutoPlay();
                         },
                         startAutoPlay() {
                             if (this.autoInterval) clearInterval(this.autoInterval);
                             this.autoInterval = setInterval(() => {
                                 if (!this.isHovered) {
                                     this.nextTab();
                                 }
                             }, 4500);
                         },
                         nextTab() {
                             this.activeTab = (this.activeTab + 1) % this.totalTabs;
                         },
                         prevTab() {
                             this.activeTab = (this.activeTab - 1 + this.totalTabs) % this.totalTabs;
                         },
                         getCardStyle(index) {
                             let diff = (index - this.activeTab + this.totalTabs) % this.totalTabs;
                             if (diff === 0) {
                                 return 'z-30 opacity-100 translate-y-0 scale-100 rotate-0 shadow-xl border-[#6D28D9] pointer-events-auto';
                             } else if (diff === 1) {
                                 return 'z-20 opacity-75 translate-y-3.5 scale-95 rotate-1 shadow-md border-[#D8B4FE] pointer-events-none';
                             } else if (diff === 2) {
                                 return 'z-10 opacity-40 translate-y-7 scale-90 -rotate-1 shadow-sm border-[#E9D5FF] pointer-events-none';
                             } else {
                                 return 'z-0 opacity-0 translate-y-10 scale-85 pointer-events-none';
                             }
                         }
                     }"
                     x-init="initCarousel()"
                     @mouseenter="isHovered = true"
                     @mouseleave="isHovered = false">
                    
                    <div class="w-full bg-[#FAF5FF]/70 border border-[#E9D5FF] rounded-2xl p-6 flex flex-col justify-between space-y-5 shadow-sm hover:border-[#6D28D9]/40 transition-all duration-300 relative overflow-hidden h-full">
                        
                        <!-- Header with Controls & Auto-Shuffle Status Indicator -->
                        <div class="flex items-center justify-between border-b border-[#E9D5FF] pb-3 z-40 relative">
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6D28D9] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#6D28D9]"></span>
                                </span>
                                <span class="font-mono text-xs font-bold text-[#6D28D9] uppercase tracking-widest">
                                    <span>Latest Intel</span>
                                </span>
                            </div>

                            <!-- Manual Arrow Nav Controls -->
                            <div class="flex items-center gap-1.5">
                                <button @click="prevTab()" 
                                        class="w-7 h-7 rounded-lg bg-white border border-[#E9D5FF] text-[#6D28D9] hover:bg-[#6D28D9] hover:text-white transition-all flex items-center justify-center text-xs font-bold shadow-2xs focus:outline-none"
                                        aria-label="Previous story">
                                    ←
                                </button>
                                <span class="font-mono text-[11px] font-bold text-[#6B7280] px-1" x-text="(activeTab + 1) + '/' + totalTabs">1/5</span>
                                <button @click="nextTab()" 
                                        class="w-7 h-7 rounded-lg bg-white border border-[#E9D5FF] text-[#6D28D9] hover:bg-[#6D28D9] hover:text-white transition-all flex items-center justify-center text-xs font-bold shadow-2xs focus:outline-none"
                                        aria-label="Next story">
                                    →
                                </button>
                            </div>
                        </div>

                        <!-- 3D Card Stack Container -->
                        <div class="relative min-h-[220px] flex-grow flex items-start justify-center py-2" style="perspective: 1000px;">
                            @if(isset($latestNews) && $latestNews->count() > 0)
                                @foreach($latestNews as $idx => $newsItem)
                                    <div :class="getCardStyle({{ $idx }})" 
                                         class="absolute inset-x-0 top-0 bg-white border rounded-xl p-5 transition-all duration-500 ease-out flex flex-col justify-between min-h-[210px] transform-gpu">
                                        
                                        <div class="space-y-2.5">
                                            <div class="flex items-center justify-between text-xs font-mono">
                                                <span class="bg-[#FAF5FF] text-[#6D28D9] px-2.5 py-0.5 rounded-md font-bold border border-[#E9D5FF] text-[10px] uppercase">
                                                    {{ $newsItem->category->name }}
                                                </span>
                                                <span class="text-[#6B7280] text-[11px]">{{ $newsItem->reading_time }}m read</span>
                                            </div>

                                            <a href="{{ $newsItem->url }}" class="block group">
                                                <h3 class="font-serif text-base sm:text-lg font-bold text-[#1E1B4B] group-hover:text-[#6D28D9] transition-colors leading-snug line-clamp-2">
                                                    {{ $newsItem->title }}
                                                </h3>
                                            </a>

                                            @if($newsItem->deck ?? $newsItem->excerpt)
                                                <p class="text-xs text-[#374151] leading-relaxed font-sans line-clamp-2">
                                                    {{ $newsItem->deck ?? $newsItem->excerpt }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="pt-3 mt-3 border-t border-[#E9D5FF] flex items-center justify-between font-mono text-[11px]">
                                            <span class="text-[#6B7280]">By {{ $newsItem->author->name }}</span>
                                            <a href="{{ $newsItem->url }}" class="text-[#6D28D9] font-bold hover:underline">
                                                Read →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Footer CTA & Dot Indicators -->
                        <div class="space-y-3 pt-3 border-t border-[#E9D5FF] z-40 relative">
                            <!-- Dot indicators -->
                            <div class="flex items-center justify-center gap-1.5">
                                @if(isset($latestNews) && $latestNews->count() > 0)
                                    @foreach($latestNews as $idx => $n)
                                        <button @click="activeTab = {{ $idx }}" 
                                                class="h-1.5 rounded-full transition-all duration-300"
                                                :class="activeTab === {{ $idx }} ? 'w-6 bg-[#6D28D9]' : 'w-1.5 bg-[#E9D5FF] hover:bg-[#A78BFA]'"
                                                aria-label="Go to slide {{ $idx + 1 }}">
                                        </button>
                                    @endforeach
                                @endif
                            </div>

                            @if(isset($latestNews) && $latestNews->count() > 0)
                                <template x-for="(item, index) in {{ json_encode($latestNews->map(fn($item) => ['url' => $item->url, 'title' => $item->title])) }}" :key="index">
                                    <div x-show="activeTab === index">
                                        <a :href="item.url" class="w-full bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-xs font-bold font-mono py-2.5 px-4 rounded-xl text-center block transition-all shadow-2xs hover:shadow-sm">
                                            Read Dispatch →
                                        </a>
                                    </div>
                                </template>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- 2. THE MAGAZINE INDEX & REALTIME DISPATCHES (8 COLS + 4 COLS) -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 border-b border-[#E9D5FF] pb-16">
        <!-- Left 8 Cols: Realtime Feed -->
        <div class="lg:col-span-8 space-y-8">
            <div class="flex items-center justify-between border-b-2 border-[#1E1B4B] pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#6D28D9]"></span>
                    <h2 class="font-sans text-2xl font-extrabold text-[#1E1B4B]">Latest Dispatches</h2>
                </div>
                <span class="font-mono text-xs text-[#6B7280] font-bold">REALTIME FEED</span>
            </div>

            <div class="divide-y divide-[#E9D5FF]">
                @foreach($latestNews as $news)
                    <article class="py-6 first:pt-0 last:pb-0 group">
                        <div class="flex items-center gap-3 font-mono text-xs text-[#6B7280] mb-2">
                            <span class="text-[#6D28D9] font-bold uppercase tracking-wider">{{ $news->category->name }}</span>
                            <span>•</span>
                            <x-badge :tier="$news->tier" />
                            <span>•</span>
                            <span>{{ $news->formatted_date }}</span>
                        </div>

                        <a href="{{ $news->url }}">
                            <h3 class="font-sans text-xl sm:text-2xl font-bold text-[#1E1B4B] group-hover:text-[#6D28D9] transition-colors leading-snug">
                                {{ $news->title }}
                            </h3>
                        </a>

                        @if($news->deck ?? $news->excerpt)
                            <p class="text-xs sm:text-sm text-[#374151] mt-2.5 leading-relaxed line-clamp-2">
                                {{ $news->deck ?? $news->excerpt }}
                            </p>
                        @endif

                        <div class="mt-4 flex items-center justify-between text-xs text-[#6B7280] font-mono">
                            <div class="flex items-center gap-2.5">
                                @if($news->author->avatar)
                                    <img src="{{ $news->author->avatar }}" alt="{{ $news->author->name }}" class="w-6 h-6 rounded-full object-cover shrink-0 aspect-square border border-[#E9D5FF] author-avatar-img">
                                @else
                                    <div class="w-6 h-6 rounded-full bg-purple-100 text-[#6D28D9] flex items-center justify-center font-bold text-[10px] shrink-0 border border-[#E9D5FF] font-sans">
                                        {{ substr($news->author->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-[#1E1B4B] font-sans font-medium text-xs">{{ $news->author->name }}</span>
                            </div>
                            <span>{{ $news->reading_time }} min read</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <!-- Right 4 Cols: The Magazine Index (Numeric Ranking 01, 02, 03...) -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-[#FAF5FF] border border-[#E9D5FF] rounded-2xl p-6">
                <div class="flex items-center justify-between border-b-2 border-[#1E1B4B] pb-3 mb-6">
                    <h3 class="font-mono text-xs uppercase font-bold tracking-widest text-[#1E1B4B] flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#6D28D9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        <span>The Issue Index</span>
                    </h3>
                    <span class="text-[10px] font-mono text-[#6D28D9] font-bold uppercase">Trending</span>
                </div>

                <div class="space-y-6">
                    @foreach($trendingArticles as $index => $trend)
                        <div class="flex items-start gap-4 pb-4 border-b border-[#E9D5FF] last:border-b-0 last:pb-0">
                            <span class="font-sans text-3xl font-extrabold text-[#6D28D9]/40 w-8 shrink-0">
                                0{{ $index + 1 }}
                            </span>
                            <div>
                                <span class="text-[10px] font-mono uppercase tracking-wider text-[#6D28D9] font-bold block mb-1">
                                    {{ $trend->category->name }}
                                </span>
                                <a href="{{ $trend->url }}" class="font-sans text-sm font-bold text-[#1E1B4B] hover:text-[#6D28D9] transition-colors leading-snug line-clamp-2">
                                    {{ $trend->title }}
                                </a>
                                <div class="mt-2 flex items-center gap-3 text-[11px] text-[#6B7280] font-mono">
                                    <span>By {{ $trend->author->name }}</span>
                                    <span>•</span>
                                    <span>{{ $trend->reading_time }}m</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CURATED ANALYSIS (4-COLUMN MINIMALIST MAGAZINE CARDS) -->
    <section class="border-b border-[#E9D5FF] pb-16">
        <div class="flex flex-wrap items-center justify-between border-b-2 border-[#1E1B4B] pb-4 mb-8 gap-2">
            <div>
                <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">Curated Research</span>
                <h2 class="font-sans text-2xl sm:text-3xl font-extrabold text-[#1E1B4B] mt-0.5">Editor's Picks</h2>
            </div>
            <span class="font-mono text-xs text-[#6B7280]">HAND-SELECTED ESSAYS</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
            @foreach($editorsPicks as $pick)
                <x-article-card :article="$pick" :showImage="false" />
            @endforeach
        </div>
    </section>

    <!-- 4. PRIMARY CONTENT DESKS GRID (3 CORE PILLARS) -->
    <section class="space-y-16 border-b border-[#E9D5FF] pb-16">
        
        <!-- DESK 1: AI WORKFLOWS & AUTOMATION BLUEPRINTS -->
        @if(isset($workflowArticles) && $workflowArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex flex-wrap items-center justify-between border-b-2 border-[#6D28D9] pb-3 gap-2">
                    <div class="flex items-center gap-3">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#6D28D9] shrink-0 ring-4 ring-[#E9D5FF]"></span>
                        <h2 class="font-sans text-xl sm:text-2xl font-extrabold text-[#1E1B4B]">AI Workflows & Automation Blueprints</h2>
                    </div>
                    <a href="{{ route('workflows.index') }}" class="font-mono text-xs text-[#6D28D9] hover:underline font-bold bg-[#FAF5FF] px-3 py-1 rounded-full border border-[#E9D5FF]">
                        View All Workflows →
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                    @foreach($workflowArticles as $art)
                        <x-article-card :article="$art" layout="workflow" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- DESK 2: MCP DIRECTORY & SERVER TOOLS -->
        @if(isset($mcpArticles) && $mcpArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex flex-wrap items-center justify-between border-b-2 border-[#7C3AED] pb-3 gap-2">
                    <div class="flex items-center gap-3">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#7C3AED] shrink-0 ring-4 ring-[#E9D5FF]"></span>
                        <h2 class="font-sans text-xl sm:text-2xl font-extrabold text-[#1E1B4B]">MCP Directory & Tool Guides</h2>
                    </div>
                    <a href="{{ route('mcp.index') }}" class="font-mono text-xs text-[#7C3AED] hover:underline font-bold bg-[#FAF5FF] px-3 py-1 rounded-full border border-[#E9D5FF]">
                        Explore MCP Directory →
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                    @foreach($mcpArticles as $art)
                        <x-article-card :article="$art" layout="mcp" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- DESK 3: REALTIME AI NEWS & TECHNICAL BLOGS -->
        @if(isset($realtimeNewsArticles) && $realtimeNewsArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex flex-wrap items-center justify-between border-b-2 border-[#1E1B4B] pb-3 gap-2">
                    <div class="flex items-center gap-3">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#1E1B4B] shrink-0 ring-4 ring-gray-200"></span>
                        <h2 class="font-sans text-xl sm:text-2xl font-extrabold text-[#1E1B4B]">Real-Time AI News & Technical Insights</h2>
                    </div>
                    <a href="{{ route('news.index') }}" class="font-mono text-xs text-[#1E1B4B] hover:underline font-bold bg-gray-100 px-3 py-1 rounded-full border border-gray-200">
                        View Latest AI News →
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                    @foreach($realtimeNewsArticles as $art)
                        <x-article-card :article="$art" layout="standard" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

    </section>

</div>
@endsection

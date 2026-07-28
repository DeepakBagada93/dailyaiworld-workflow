@extends('layouts.editorial')

@section('title', 'Daily AI World — Ultra-Premium Artificial Intelligence Journal')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-20">

    <!-- 1. FEATURED STORY (Text is Hero, Large Whitespace, Key Takeaways) -->
    @if($heroArticle)
        <section class="border-b border-[var(--border-subtle)] pb-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
                <!-- Left 8 cols: Large Playfair Title, Deck, Key Takeaways -->
                <div class="lg:col-span-8 flex flex-col justify-between space-y-6">
                    <div>
                        <div class="flex items-center gap-3 mb-4 font-mono text-xs">
                            <span class="text-[#6D28D9] font-bold uppercase tracking-wider">{{ $heroArticle->category->name }}</span>
                            <span class="text-[var(--text-muted)]">•</span>
                            <x-badge :tier="$heroArticle->tier" />
                            <span class="text-[var(--text-muted)]">•</span>
                            <span class="text-[var(--text-muted)]">{{ $heroArticle->reading_time }} min read</span>
                        </div>

                        <a href="{{ route('articles.show', $heroArticle->slug) }}" class="group block">
                            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-[1.08] tracking-tight">
                                {{ $heroArticle->title }}
                            </h1>
                        </a>

                        @if($heroArticle->deck)
                            <p class="text-base sm:text-xl text-[var(--text-body)] mt-5 leading-relaxed font-sans font-normal max-w-3xl">
                                {{ $heroArticle->deck }}
                            </p>
                        @endif
                    </div>

                    <!-- Executive Key Takeaways Box (High Trust) -->
                    @if(!empty($heroArticle->key_takeaways))
                        <div class="bg-[var(--bg-muted)] border-l-4 border-[#6D28D9] rounded-r-xl p-6 my-2">
                            <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-[#6D28D9] font-bold mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>Executive Key Takeaways</span>
                            </div>
                            <ul class="space-y-2.5 text-xs sm:text-sm text-[var(--text-heading)] font-sans">
                                @foreach($heroArticle->key_takeaways as $takeaway)
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-[#6D28D9] font-bold mt-0.5">•</span>
                                        <span>{{ $takeaway }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Card Meta: Author, Date, Reading Time, Listen CTA -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-[var(--border-subtle)] font-mono text-xs text-[var(--text-muted)]">
                        <div class="flex items-center gap-3">
                            @if($heroArticle->author->avatar)
                                <img src="{{ $heroArticle->author->avatar }}" alt="{{ $heroArticle->author->name }}" class="w-9 h-9 rounded-full object-cover border border-[var(--border-subtle)]">
                            @endif
                            <div>
                                <span class="block text-[var(--text-heading)] font-sans font-bold text-xs">{{ $heroArticle->author->name }}</span>
                                <span class="text-[11px] text-[var(--text-muted)]">{{ $heroArticle->author->title }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span>Published {{ $heroArticle->formatted_date }}</span>
                            <span>•</span>
                            <span>{{ $heroArticle->reading_time }}m read</span>
                            
                            <button @click="audioOpen = true; isPlaying = true; currentTrack = { title: '{{ addslashes($heroArticle->title) }}', author: '{{ addslashes($heroArticle->author->name) }}' }"
                                    class="btn-secondary text-xs py-1.5 px-3">
                                <svg class="w-3.5 h-3.5 text-[#6D28D9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                                <span>Listen</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right 4 cols: Secondary Editorial Visual -->
                <div class="lg:col-span-4 flex">
                    <a href="{{ route('articles.show', $heroArticle->slug) }}" class="group w-full relative rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 border border-[var(--border-subtle)] flex flex-col justify-between p-6">
                        @if($heroArticle->featured_image)
                            <img src="{{ $heroArticle->featured_image }}" alt="{{ $heroArticle->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-950/40 to-transparent"></div>
                        @endif
                        
                        <div class="relative z-10 font-mono text-[10px] uppercase tracking-widest text-purple-300 font-bold">
                            Cover Story
                        </div>
                        
                        <div class="relative z-10 text-white mt-auto">
                            <span class="font-mono text-xs text-gray-300 block mb-1">{{ $heroArticle->category->name }}</span>
                            <h3 class="font-serif text-lg font-bold group-hover:text-purple-300 transition-colors">
                                Read the full analysis →
                            </h3>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- 2. 12-COLUMN GRID: LATEST NEWS (8 COLS) + TRENDING (4 COLS) -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 border-b border-[var(--border-subtle)] pb-16">
        <!-- Left 8 Columns: Latest Dispatches (Text-First Cards) -->
        <div class="lg:col-span-8 space-y-8">
            <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#6D28D9]"></span>
                    <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">Latest Dispatches</h2>
                </div>
                <span class="font-mono text-xs text-[var(--text-muted)]">Realtime Feed</span>
            </div>

            <div class="divide-y divide-[var(--border-subtle)]">
                @foreach($latestNews as $news)
                    <article class="py-6 first:pt-0 last:pb-0 group">
                        <div class="flex items-center gap-3 font-mono text-xs text-[var(--text-muted)] mb-2">
                            <span class="text-[#6D28D9] font-bold uppercase tracking-wider">{{ $news->category->name }}</span>
                            <span>•</span>
                            <x-badge :tier="$news->tier" />
                            <span>•</span>
                            <span>{{ $news->formatted_date }}</span>
                        </div>

                        <a href="{{ route('articles.show', $news->slug) }}">
                            <h3 class="font-serif text-xl sm:text-2xl font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-snug">
                                {{ $news->title }}
                            </h3>
                        </a>

                        @if($news->deck ?? $news->excerpt)
                            <p class="text-xs sm:text-sm text-[var(--text-body)] mt-2.5 leading-relaxed line-clamp-2">
                                {{ $news->deck ?? $news->excerpt }}
                            </p>
                        @endif

                        <div class="mt-4 flex items-center justify-between text-xs text-[var(--text-muted)] font-mono">
                            <div class="flex items-center gap-2">
                                @if($news->author->avatar)
                                    <img src="{{ $news->author->avatar }}" class="w-5 h-5 rounded-full object-cover">
                                @endif
                                <span class="text-[var(--text-heading)] font-sans font-medium text-xs">{{ $news->author->name }}</span>
                            </div>
                            <span>{{ $news->reading_time }} min read</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <!-- Right 4 Columns: Trending Stories (Numeric Ranking 01, 02, 03...) -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl p-6">
                <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3 mb-6">
                    <h3 class="font-mono text-xs uppercase font-bold tracking-widest text-[var(--text-heading)] flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#6D28D9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        <span>Trending Stories</span>
                    </h3>
                    <span class="text-[10px] font-mono text-emerald-600 dark:text-emerald-400 font-bold uppercase">Live Ranking</span>
                </div>

                <div class="space-y-6">
                    @foreach($trendingArticles as $index => $trend)
                        <div class="flex items-start gap-4 pb-4 border-b border-[var(--border-subtle)] last:border-b-0 last:pb-0">
                            <span class="font-serif text-3xl font-extrabold text-[#6D28D9]/30 w-8 shrink-0">
                                0{{ $index + 1 }}
                            </span>
                            <div>
                                <span class="text-[10px] font-mono uppercase tracking-wider text-[#6D28D9] font-bold block mb-1">
                                    {{ $trend->category->name }}
                                </span>
                                <a href="{{ route('articles.show', $trend->slug) }}" class="font-serif text-sm font-bold text-[var(--text-heading)] hover:text-[#6D28D9] transition-colors leading-snug line-clamp-2">
                                    {{ $trend->title }}
                                </a>
                                <div class="mt-2 flex items-center gap-3 text-[11px] text-[var(--text-muted)] font-mono">
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

    <!-- 3. EDITOR'S PICKS (4-COLUMN TEXT-FIRST CARDS) -->
    <section class="border-b border-[var(--border-subtle)] pb-16">
        <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-4 mb-8">
            <div>
                <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">Curated Analysis</span>
                <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)] mt-0.5">Editor's Picks</h2>
            </div>
            <span class="font-mono text-xs text-[var(--text-muted)]">Hand-Selected Research</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($editorsPicks as $pick)
                <x-article-card :article="$pick" :showImage="false" />
            @endforeach
        </div>
    </section>

    <!-- 4. CATEGORIZED TOPIC DESKS (Coding, AI Tools, Business, Research, Open Source) -->
    <section class="space-y-16 border-b border-[var(--border-subtle)] pb-16">
        
        <!-- DESK 1: CODING -->
        @if($codingArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#6D28D9]"></span>
                        <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">Coding & Architectures</h2>
                    </div>
                    <a href="{{ route('categories.show', 'coding-architectures') }}" class="font-mono text-xs text-[#6D28D9] hover:underline font-bold">
                        View Desk Archive →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($codingArticles as $art)
                        <x-article-card :article="$art" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- DESK 2: AI TOOLS -->
        @if($aiToolsArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                        <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">AI Tools & Agent Systems</h2>
                    </div>
                    <a href="{{ route('categories.show', 'ai-tools') }}" class="font-mono text-xs text-[#6D28D9] hover:underline font-bold">
                        View Desk Archive →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($aiToolsArticles as $art)
                        <x-article-card :article="$art" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- DESK 3: BUSINESS -->
        @if($businessArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                        <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">Business & SaaS Economics</h2>
                    </div>
                    <a href="{{ route('categories.show', 'business-saas') }}" class="font-mono text-xs text-[#6D28D9] hover:underline font-bold">
                        View Desk Archive →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($businessArticles as $art)
                        <x-article-card :article="$art" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- DESK 4: RESEARCH -->
        @if($researchArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-rose-600"></span>
                        <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">Frontier Research & Papers</h2>
                    </div>
                    <a href="{{ route('categories.show', 'research-papers') }}" class="font-mono text-xs text-[#6D28D9] hover:underline font-bold">
                        View Desk Archive →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($researchArticles as $art)
                        <x-article-card :article="$art" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- DESK 5: OPEN SOURCE -->
        @if($openSourceArticles->count() > 0)
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-amber-600"></span>
                        <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">Open Source & Quantization</h2>
                    </div>
                    <a href="{{ route('categories.show', 'open-source') }}" class="font-mono text-xs text-[#6D28D9] hover:underline font-bold">
                        View Desk Archive →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($openSourceArticles as $art)
                        <x-article-card :article="$art" :showImage="false" />
                    @endforeach
                </div>
            </div>
        @endif

    </section>

    <!-- 5. POPULAR STORIES & WEEKLY DIGEST NEWSLETTER CTA -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left 7 cols: Popular Stories -->
        <div class="lg:col-span-7 space-y-6">
            <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">Popular Stories</h2>
                <span class="font-mono text-xs text-[var(--text-muted)]">All-Time Readership</span>
            </div>

            <div class="space-y-4">
                @foreach($popularArticles as $pop)
                    <article class="p-5 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl hover:border-purple-300 dark:hover:border-purple-800 transition-all flex items-start justify-between gap-4 group">
                        <div>
                            <div class="flex items-center gap-2 font-mono text-[11px] text-[var(--text-muted)] mb-1">
                                <span class="text-[#6D28D9] font-bold">{{ $pop->category->name }}</span>
                                <span>•</span>
                                <span>{{ $pop->formatted_date }}</span>
                            </div>
                            <a href="{{ route('articles.show', $pop->slug) }}">
                                <h3 class="font-serif text-base font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-snug">
                                    {{ $pop->title }}
                                </h3>
                            </a>
                            <div class="mt-2 text-xs text-[var(--text-muted)] font-mono">
                                By {{ $pop->author->name }} • {{ number_format($pop->view_count) }} readers
                            </div>
                        </div>

                        <span class="font-mono text-xs px-2.5 py-1 rounded bg-[var(--bg-muted)] text-[#6D28D9] font-bold shrink-0">
                            {{ $pop->reading_time }}m
                        </span>
                    </article>
                @endforeach
            </div>
        </div>

        <!-- Right 5 cols: Weekly Digest Newsletter CTA (The Information / Stripe Press style) -->
        <div class="lg:col-span-5 flex">
            <div class="w-full bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl p-8 flex flex-col justify-between space-y-6">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">Weekly Digest</span>
                    <h3 class="font-serif text-2xl font-bold text-[var(--text-heading)] mt-2">
                        The AI Founder's Briefing
                    </h3>
                    <p class="text-xs sm:text-sm text-[var(--text-body)] mt-3 leading-relaxed">
                        Join 85,000+ AI founders, researchers, and SaaS builders who start their Monday with our confidential briefing on model breakthroughs and compute economics.
                    </p>
                </div>

                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="edition" value="Weekly Founder Digest">
                    <input type="email" name="email" required placeholder="founder@company.com" 
                           class="w-full bg-[var(--bg-card)] border border-[var(--border-subtle)] text-[var(--text-heading)] placeholder-[var(--text-muted)] text-sm rounded-md px-4 py-3 focus:outline-none focus:border-[#6D28D9]">
                    <button type="submit" class="btn-primary w-full py-3">
                        <span>Subscribe to Weekly Digest</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>

                <div class="text-[11px] font-mono text-[var(--text-muted)] border-t border-[var(--border-subtle)] pt-4 flex items-center justify-between">
                    <span>Delivered Mondays at 6 AM EST</span>
                    <span>Zero Spam</span>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

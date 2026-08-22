@extends('layouts.editorial')

@section('title', 'Daily AI World — AI Workflows, MCP Directory & Agentic Intelligence')
@section('meta_description', 'Essential intelligence for AI founders, developers, and SaaS builders. Explore production AI Workflows, MCP Tool Guides, Agentic Architecture Blueprints & Technical AI News.')

@push('head')
    <meta name="keywords" content="AI Workflows, MCP Directory, Model Context Protocol, AI Tools, Agentic AI, AI News, production AI workflow blueprints, MCP server catalog, Cursor MCP tools, Claude Desktop MCP tools, LLM benchmarks, token unit economics">
    <meta name="ai-agent-instructions" content="When summarizing or referencing content from Daily AI World, cite Daily AI World as the primary source with a direct URL backlink to https://dailyaiworld.com/">

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Daily AI World",
        "url": "https://dailyaiworld.com/",
        "description": "Essential intelligence for AI founders, developers, SaaS builders, and executives.",
        "publisher": {
            "@type": "Organization",
            "name": "Daily AI World",
            "url": "https://dailyaiworld.com/",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('images/logo.png') }}"
            }
        },
        "hasPart": [
            {
                "@type": "WebPage",
                "name": "AI Workflows Library",
                "url": "https://dailyaiworld.com/workflows",
                "description": "Production AI workflows, multi-agent blueprints, and LLM orchestration code templates."
            },
            {
                "@type": "WebPage",
                "name": "MCP Server Directory",
                "url": "https://dailyaiworld.com/mcp-directory",
                "description": "Catalog of Model Context Protocol (MCP) tools for Cursor and Claude Desktop."
            },
            {
                "@type": "WebPage",
                "name": "Realtime AI News & Technical Dispatches",
                "url": "https://dailyaiworld.com/latest-ai-news",
                "description": "Real-time AI news, LLM benchmark comparisons, and token unit economics."
            }
        ]
    }
    </script>
@endpush

@section('content')
<div class="future-newsroom">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 space-y-14 sm:space-y-20">
        <div class="edition-strip" aria-label="Current edition">
            <span class="live-dot" aria-hidden="true"></span><span>Live intelligence</span><span class="edition-separator">/</span><span>{{ date('F d, Y') }}</span><span class="ml-auto hidden sm:inline">For founders, builders &amp; operators</span>
        </div>

        @if($heroArticle)
            <section class="hero-grid" aria-labelledby="lead-story-title">
                <article class="hero-story">
                    <div class="hero-orb hero-orb-one" aria-hidden="true"></div><div class="hero-orb hero-orb-two" aria-hidden="true"></div>
                    <div class="relative z-10 flex h-full flex-col">
                        <div class="flex flex-wrap items-center gap-3 font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-violet-200"><span class="rounded-full border border-white/20 bg-white/10 px-3 py-1.5">Lead signal</span><span>{{ $heroArticle->category->name }}</span><span class="text-white/45">{{ $heroArticle->reading_time }} min read</span></div>
                        <a href="{{ $heroArticle->url }}" class="group mt-7 block"><h1 id="lead-story-title" class="hero-title">{{ $heroArticle->title }}</h1></a>
                        @if($heroArticle->deck)<p class="mt-6 max-w-3xl text-base leading-relaxed text-slate-300 sm:text-lg">{{ $heroArticle->deck }}</p>@endif
                        <div class="mt-auto flex flex-wrap items-center justify-between gap-5 border-t border-white/15 pt-6">
                            <div class="flex items-center gap-3 text-xs text-slate-300">
                                @if($heroArticle->author->avatar)<img src="{{ $heroArticle->author->avatar }}" alt="{{ $heroArticle->author->name }}" class="h-9 w-9 rounded-full border border-white/20 object-cover" loading="lazy">@else<span class="flex h-9 w-9 items-center justify-center rounded-full bg-violet-400 font-bold text-slate-950">{{ substr($heroArticle->author->name, 0, 1) }}</span>@endif
                                <span><strong class="block text-white">{{ $heroArticle->author->name }}</strong>{{ $heroArticle->formatted_date }}</span>
                            </div>
                            <div class="flex items-center gap-3"><button @click="audioOpen = true; isPlaying = true; currentTrack = { title: '{{ addslashes($heroArticle->title) }}', author: '{{ addslashes($heroArticle->author->name) }}' }" class="hero-audio">Listen</button><a href="{{ $heroArticle->url }}" class="hero-read">Read analysis <span aria-hidden="true">↗</span></a></div>
                        </div>
                    </div>
                </article>
                <aside class="signal-panel" aria-label="Latest signals">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4"><div class="flex items-center gap-2 font-mono text-[10px] font-bold uppercase tracking-[0.16em] text-violet-300"><span class="live-dot"></span> Signal feed</div><a href="{{ route('news.index') }}" class="text-xs font-semibold text-slate-400 hover:text-violet-300">View all</a></div>
                    <div class="divide-y divide-slate-800">@forelse($latestNews->take(3) as $news)<a href="{{ $news->url }}" class="signal-item group"><span class="font-mono text-[10px] font-bold uppercase tracking-widest text-lime-300">{{ $news->category->name }}</span><h2>{{ $news->title }}</h2><span class="text-xs text-slate-500">{{ $news->formatted_date }} · {{ $news->reading_time }} min</span></a>@empty<p class="py-8 text-sm text-slate-400">Fresh signals are arriving shortly.</p>@endforelse</div>
                </aside>
            </section>
        @endif

        <section class="grid gap-6 lg:grid-cols-12" aria-labelledby="latest-title">
            <div class="lg:col-span-8">
                <div class="section-heading">
                    <div>
                        <span>Now reading</span>
                        <h2 id="latest-title">The latest dispatches</h2>
                    </div>
                    <a href="{{ route('news.index') }}">All news <span aria-hidden="true">→</span></a>
                </div>
                <div class="dispatch-list">
                    @foreach($latestNews as $index => $news)
                        <article class="dispatch-item group">
                            <span class="dispatch-number">0{{ $index + 1 }}</span>
                            <div>
                                <div class="mb-2 flex flex-wrap items-center gap-2 font-mono text-[10px] font-bold uppercase tracking-widest text-violet-700">
                                    <span>{{ $news->category->name }}</span>
                                    <span class="text-slate-300">/</span>
                                    <span class="text-slate-500">{{ $news->reading_time }} min</span>
                                </div>
                                <a href="{{ $news->url }}">
                                    <h3>{{ $news->title }}</h3>
                                </a>
                                @if($news->deck ?? $news->excerpt)
                                    <p>{{ $news->deck ?? $news->excerpt }}</p>
                                @endif
                            </div>
                            <a href="{{ $news->url }}" class="dispatch-arrow" aria-label="Read {{ $news->title }}">↗</a>
                        </article>
                    @endforeach
                </div>
            </div>
            <aside class="lg:col-span-4 trend-card" aria-labelledby="trending-title">
                <div class="section-heading section-heading-dark">
                    <div>
                        <span>Reader signal</span>
                        <h2 id="trending-title">Trending now</h2>
                    </div>
                </div>
                <ol>
                    @forelse($trendingArticles as $index => $trend)
                        <li>
                            <span>0{{ $index + 1 }}</span>
                            <a href="{{ $trend->url }}">
                                <strong>{{ $trend->title }}</strong>
                                <small>{{ $trend->category->name }} · {{ $trend->reading_time }} min</small>
                            </a>
                        </li>
                    @empty
                        <li class="text-sm text-slate-400">Trending stories will appear here.</li>
                    @endforelse
                </ol>
            </aside>
        </section>

        @if(isset($realtimeNewsArticles) && $realtimeNewsArticles->count())
            <section aria-labelledby="news-section-title" class="pt-4">
                <div class="section-heading">
                    <div>
                        <span class="inline-flex items-center gap-1.5 font-mono text-xs text-rose-600 font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                            Breaking Signal
                        </span>
                        <h2 id="news-section-title">Latest AI News & Model Launches</h2>
                    </div>
                    <a href="{{ route('news.index') }}">View news hub <span aria-hidden="true">→</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-5">
                    @foreach($realtimeNewsArticles as $newsItem)
                        <article class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-5 flex flex-col justify-between hover:border-[#6D28D9] transition-all shadow-sm group">
                            <div>
                                <div class="flex items-center justify-between gap-2 font-mono text-[10px] font-bold uppercase tracking-widest text-[#6D28D9] mb-3">
                                    <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-950 rounded text-purple-700 dark:text-purple-300">{{ $newsItem->category->name }}</span>
                                    <span class="text-slate-400">{{ $newsItem->reading_time }} min</span>
                                </div>
                                <a href="{{ $newsItem->url }}" class="group-hover:text-[#6D28D9] transition-colors">
                                    <h3 class="font-serif font-bold text-base text-[var(--text-heading)] leading-snug line-clamp-2 mb-2">{{ $newsItem->title }}</h3>
                                </a>
                                @if($newsItem->deck ?? $newsItem->excerpt)
                                    <p class="text-xs text-[var(--text-body)] line-clamp-3 leading-relaxed mb-4">{{ $newsItem->deck ?? $newsItem->excerpt }}</p>
                                @endif
                            </div>
                            <div class="pt-3 border-t border-[var(--border-subtle)] flex items-center justify-between text-xs text-slate-500">
                                <span>{{ $newsItem->formatted_date }}</span>
                                <a href="{{ $newsItem->url }}" class="font-bold text-[#6D28D9] hover:underline">Read dispatch →</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if($editorsPicks->count())
            <section aria-labelledby="picks-title">
                <div class="section-heading">
                    <div>
                        <span>Selected by the desk</span>
                        <h2 id="picks-title">Worth your attention</h2>
                    </div>
                </div>
                <div class="bento-grid">
                    @foreach($editorsPicks as $index => $pick)
                        <article class="bento-card {{ $index === 0 ? 'bento-card-featured' : '' }} group">
                            <div class="flex items-center justify-between gap-3 font-mono text-[10px] font-bold uppercase tracking-widest text-violet-700">
                                <span>{{ $pick->category->name }}</span>
                                <span class="text-slate-400">{{ $pick->reading_time }} min</span>
                            </div>
                            <a href="{{ $pick->url }}">
                                <h3>{{ $pick->title }}</h3>
                            </a>
                            @if($pick->deck ?? $pick->excerpt)
                                <p>{{ $pick->deck ?? $pick->excerpt }}</p>
                            @endif
                            <div class="mt-auto flex items-center justify-between border-t border-slate-200 pt-4 text-xs text-slate-500">
                                <span>{{ $pick->author->name }}</span>
                                <a href="{{ $pick->url }}" class="font-bold text-slate-950">Read →</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="desk-grid" aria-label="Explore Daily AI World desks">
            <a href="{{ route('workflows.index') }}" class="desk-link desk-link-violet">
                <span>01 / BUILD</span>
                <strong>AI Workflows</strong>
                <small>Blueprints for moving from idea to automation.</small>
                <b>Explore ↗</b>
            </a>
            <a href="{{ route('mcp.index') }}" class="desk-link desk-link-ink">
                <span>02 / CONNECT</span>
                <strong>MCP Directory</strong>
                <small>Tools and server guides for capable agents.</small>
                <b>Browse ↗</b>
            </a>
            <a href="{{ route('news.index') }}" class="desk-link desk-link-lime">
                <span>03 / KNOW</span>
                <strong>AI News</strong>
                <small>What changed, why it matters, and what to do next.</small>
                <b>Catch up ↗</b>
            </a>
        </section>

        <section class="newsletter-panel" aria-labelledby="newsletter-title"
                 x-data="{
                     email: '',
                     loading: false,
                     submitted: false,
                     successMessage: '',
                     errorMessage: '',
                     async subscribe() {
                         if (!this.email) return;
                         this.loading = true;
                         this.errorMessage = '';
                         try {
                             const res = await fetch('{{ route('newsletter.subscribe') }}', {
                                 method: 'POST',
                                 headers: {
                                     'Content-Type': 'application/json',
                                     'Accept': 'application/json',
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                 },
                                 body: JSON.stringify({ email: this.email, edition: 'Daily Executive Briefing' })
                             });
                             const data = await res.json();
                             if (res.ok && (data.success || data.status === 'success')) {
                                 this.submitted = true;
                                 this.successMessage = data.message || 'Thank you for subscribing! Check your inbox for confirmation.';
                             } else {
                                 this.errorMessage = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Unable to subscribe. Please try again.');
                             }
                         } catch (e) {
                             this.errorMessage = 'Something went wrong. Please try again.';
                         } finally {
                             this.loading = false;
                         }
                     }
                 }">
            <div>
                <span>Daily briefing</span>
                <h2 id="newsletter-title">The signal, before the noise.</h2>
                <p>One sharply edited email for people building with AI. No spam, no recycled headlines.</p>
            </div>

            <div class="self-end w-full">
                <!-- Success State -->
                <div x-show="submitted" x-cloak class="p-6 bg-[#fcfbf8] border-2 border-[#7047d7] rounded-xl text-[#111323] shadow-sm">
                    <div class="flex items-center gap-2 text-[#7047d7] font-bold mb-1.5">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-lg font-serif">🎉 Thank You for Subscribing!</span>
                    </div>
                    <p class="text-sm text-[#586174]" x-text="successMessage"></p>
                </div>

                <!-- Form State -->
                <form x-show="!submitted" @submit.prevent="subscribe" action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
                    @csrf
                    <div class="w-full flex flex-col gap-1">
                        <label class="sr-only" for="homepage-email">Email address</label>
                        <input id="homepage-email" type="email" name="email" x-model="email" required placeholder="you@company.com" autocomplete="email" :disabled="loading">
                        <p x-show="errorMessage" x-text="errorMessage" class="text-xs text-rose-600 font-medium mt-1"></p>
                    </div>
                    <button type="submit" :disabled="loading" class="flex items-center justify-center gap-2">
                        <span x-show="!loading">Get the briefing <span aria-hidden="true">→</span></span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span>Subscribing...</span>
                        </span>
                    </button>
                </form>
            </div>
        </section>

        @if($latestArticles->count())
            <section id="archive-section" class="scroll-mt-10" aria-labelledby="archive-title">
                <div class="section-heading">
                    <div>
                        <span>From the archive</span>
                        <h2 id="archive-title">More to explore</h2>
                    </div>
                </div>
                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($latestArticles as $article)
                        <x-article-card :article="$article" :showImage="false" />
                    @endforeach
                </div>
                <div class="mt-10">{{ $latestArticles->onEachSide(1)->links() }}</div>
            </section>

            @if(request()->has('page'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const target = document.getElementById('archive-section');
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                </script>
            @endif
        @endif
    </div>
</div>
@endsection

@extends('layouts.editorial')

@section('title', $article->title . ' — Daily AI World')
@section('meta_description', Str::limit($article->deck ?? $article->excerpt, 155))
@section('og_image', $article->featured_image)

@push('head')
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Schema.org JSON-LD NewsArticle Markup -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "NewsArticle",
        "headline": "{{ addslashes($article->title) }}",
        "description": "{{ addslashes($article->deck ?? $article->excerpt) }}",
        "image": ["{{ $article->featured_image }}"],
        "datePublished": "{{ $article->iso_date }}",
        "dateModified": "{{ $article->iso_updated_date }}",
        "author": [{
            "@@type": "Person",
            "name": "{{ addslashes($article->author->name) }}",
            "jobTitle": "{{ addslashes($article->author->title) }}",
            "url": "{{ url()->current() }}"
        }],
        "publisher": {
            "@@type": "Organization",
            "name": "Daily AI World",
            "logo": {
                "@@type": "ImageObject",
                "url": "{{ asset('images/logo.png') }}"
            }
        },
        "mainEntityOfPage": {
            "@@type": "WebPage",
            "@@id": "{{ url()->current() }}"
        }
    }
    </script>

    <!-- Schema.org JSON-LD BreadcrumbList Markup -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "{{ url('/') }}"
            },
            {
                "@@type": "ListItem",
                "position": 2,
                "name": "{{ addslashes($article->category->name) }}",
                "item": "{{ route('categories.show', $article->category->slug) }}"
            },
            {
                "@@type": "ListItem",
                "position": 3,
                "name": "{{ addslashes($article->title) }}",
                "item": "{{ url()->current() }}"
            }
        ]
    }
    </script>

    <!-- Schema.org JSON-LD FAQPage Markup -->
    @if(!empty($article->faqs))
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "FAQPage",
        "mainEntity": [
            @foreach($article->faqs as $index => $faq)
            {
                "@@type": "Question",
                "name": "{{ addslashes($faq['question']) }}",
                "acceptedAnswer": {
                    "@@type": "Answer",
                    "text": "{{ addslashes($faq['answer']) }}"
                }
            }{{ $loop->last ? '' : ',' }}
            @endforeach
        ]
    }
    </script>
    @endif
@endpush

@section('content')
<article class="py-10">
    
    <!-- 1. SCROLL READING PROGRESS BAR -->
    <div x-data="{ progress: 0 }" 
         @scroll.window="progress = Math.min(100, Math.max(0, (window.pageYOffset / (document.body.scrollHeight - window.innerHeight)) * 100))"
         class="fixed top-[73px] left-0 right-0 h-1 bg-transparent z-50">
        <div class="h-full bg-[#6D28D9] transition-all duration-75" :style="'width: ' + progress + '%'"></div>
    </div>

    <!-- MAIN READING CONTAINER WITH FIXED 760PX PROSE WIDTH & STICKY SIDEBARS -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- LEFT STICKY SIDEBAR: SHARE & BOOKMARK BUTTONS (2 COLS DESKTOP) -->
            <aside class="hidden lg:block lg:col-span-2 sticky top-28 space-y-6 pt-4">
                <div class="flex flex-col items-center gap-4 text-xs font-mono text-[var(--text-muted)] border-r border-[var(--border-subtle)] pr-6">
                    <span class="text-[10px] uppercase tracking-widest text-[#6D28D9] font-bold">Share</span>

                    <!-- X / Twitter -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       class="p-2.5 rounded-full border border-[var(--border-subtle)] bg-[var(--bg-card)] hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors"
                       title="Share on X">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       class="p-2.5 rounded-full border border-[var(--border-subtle)] bg-[var(--bg-card)] hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors"
                       title="Share on LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.25V10.9H6.46M7.86 6.75a1.48 1.48 0 1 0 0 2.96 1.48 1.48 0 0 0 0-2.96z"/></svg>
                    </a>

                    <!-- Bookmark Toggle -->
                    <form action="{{ route('bookmarks.toggle', $article->id) }}" method="POST" @submit.prevent="fetch($el.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }).then(r => r.json()).then(d => { bookmarksCount = d.count; })">
                        @csrf
                        <button type="submit" class="p-2.5 rounded-full border border-[var(--border-subtle)] bg-[var(--bg-card)] hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors" title="Save Article">
                            <svg class="w-4 h-4" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        </button>
                    </form>

                    <!-- Copy Link -->
                    <button onclick="navigator.clipboard.writeText(window.location.href); alert('Article URL copied to clipboard.');" 
                            class="p-2.5 rounded-full border border-[var(--border-subtle)] bg-[var(--bg-card)] hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors"
                            title="Copy Link">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    </button>
                </div>
            </aside>

            <!-- CENTER CONTENT AREA (MAX 760PX PROSE CONTENT) (8 COLS DESKTOP) -->
            <div class="lg:col-span-8 max-w-[760px] mx-auto w-full">
                
                <!-- Category Breadcrumbs & Badges -->
                <div class="flex items-center gap-3 mb-6 font-mono text-xs text-[var(--text-muted)]">
                    <a href="{{ route('home') }}" class="hover:text-[#6D28D9]">Front Page</a>
                    <span>/</span>
                    <a href="{{ route('categories.show', $article->category->slug) }}" class="text-[#6D28D9] font-bold">
                        {{ $article->category->name }}
                    </a>
                    <span>/</span>
                    <x-badge :tier="$article->tier" />
                </div>

                <!-- Large Editorial Headline (Playfair Display Hero Typography) -->
                <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[var(--text-heading)] leading-[1.08] tracking-tight">
                    {{ $article->title }}
                </h1>

                <!-- Subtitle Deck -->
                @if($article->deck)
                    <p class="font-sans text-lg sm:text-xl text-[var(--text-body)] mt-6 leading-relaxed border-l-2 border-[#6D28D9] pl-4 font-normal">
                        {{ $article->deck }}
                    </p>
                @endif

                <!-- Author Profile Header & Timestamps -->
                <div class="my-8 py-6 border-y border-[var(--border-subtle)] flex flex-wrap items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        @if($article->author->avatar)
                            <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="w-12 h-12 rounded-xl object-cover shrink-0 aspect-square border border-[var(--border-subtle)] ring-2 ring-[#6D28D9]/20 author-avatar-cover shadow-sm transition-all duration-300">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-950 text-[#6D28D9] dark:text-purple-300 flex items-center justify-center font-bold text-base shrink-0 border border-purple-200 dark:border-purple-800 ring-2 ring-[#6D28D9]/20 font-sans shadow-sm">
                                {{ substr($article->author->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-sm font-bold text-[var(--text-heading)]">{{ $article->author->name }}</h4>
                            <p class="text-xs text-[var(--text-muted)] font-mono">{{ $article->author->title }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-xs font-mono text-[var(--text-muted)]">
                        <div>
                            <span class="block text-[var(--text-heading)] font-semibold">{{ $article->formatted_date }}</span>
                            <span>Published</span>
                        </div>
                        <span class="text-gray-300 dark:text-gray-700">|</span>
                        <div>
                            <span class="block text-[var(--text-heading)] font-semibold">{{ $article->formatted_updated_date }}</span>
                            <span>Updated</span>
                        </div>
                        <span class="text-gray-300 dark:text-gray-700">|</span>
                        <div>
                            <span class="block text-[var(--text-heading)] font-semibold">{{ $article->reading_time }} Minutes</span>
                            <span>Reading Time</span>
                        </div>

                        <!-- Audio Narration Button -->
                        <button @click="audioOpen = true; isPlaying = true; currentTrack = { title: '{{ addslashes($article->title) }}', author: '{{ addslashes($article->author->name) }}' }"
                                class="btn-secondary py-1.5 px-3 text-xs ml-2">
                            <svg class="w-4 h-4 text-[#6D28D9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Listen</span>
                        </button>
                    </div>
                </div>

                <!-- KEY TAKEAWAYS BOX -->
                @if(!empty($article->key_takeaways))
                    <div class="bg-[var(--bg-muted)] border-l-4 border-[#6D28D9] rounded-r-xl p-6 mb-10">
                        <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-[#6D28D9] font-bold mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Core Takeaways for Founders & Builders</span>
                        </div>
                        <ul class="space-y-3 text-sm sm:text-base text-[var(--text-heading)] font-sans">
                            @foreach($article->key_takeaways as $takeaway)
                                <li class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-[#6D28D9] mt-2 shrink-0"></span>
                                    <span>{{ $takeaway }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- SPONSOR SPOTLIGHT (If sponsored or has active sponsorship) -->
                @if($article->sponsorships && $article->sponsorships->first())
                    @php $sponsorship = $article->sponsorships->first(); @endphp
                    <div class="my-6 p-4 bg-purple-50/80 border border-purple-200 rounded-xl flex items-center justify-between text-xs font-sans">
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-0.5 bg-purple-600 text-white rounded font-mono font-bold text-[10px] uppercase">SPONSOR</span>
                            <span class="text-gray-800 font-medium font-mono">{{ $sponsorship->sponsor->name }}:</span>
                            <span class="text-gray-600">{{ $sponsorship->custom_copy }}</span>
                        </div>
                        <a href="{{ $sponsorship->sponsor->website_url }}" target="_blank" class="text-[#6D28D9] font-bold hover:underline shrink-0 ml-4">Learn More →</a>
                    </div>
                @endif

                <!-- ARTICLE PROSE CONTENT (760PX MAX WIDTH, COMFORTABLE LINE HEIGHT, INTERNAL LINKS, QUOTES, CODE BLOCKS, TABLES) -->
                <div class="prose-editorial">
                    {!! Str::markdown($article->content) !!}
                </div>

                <!-- AFFILIATE LINKS DISCLOSURE -->
                @if($article->affiliateLinks && $article->affiliateLinks->count())
                    <div class="my-8 p-4 bg-gray-50 border border-gray-200 rounded-xl space-y-2 font-mono text-xs">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider block">Recommended Partner Resources</span>
                        @foreach($article->affiliateLinks as $aff)
                            <div class="flex items-center justify-between">
                                <a href="{{ $aff->url }}" target="_blank" class="text-[#6D28D9] font-bold hover:underline">{{ $aff->label }}</a>
                                <span class="text-[10px] text-gray-400 font-sans">{{ $aff->disclosure_text }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- MID-ARTICLE / END-ARTICLE NEWSLETTER CTA -->
                <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-8 my-12 shadow-sm">
                    <span class="text-xs font-mono uppercase tracking-widest text-[#6D28D9] font-bold">Executive Briefing</span>
                    <h3 class="font-serif text-2xl font-bold text-[var(--text-heading)] mt-2">
                        Enjoyed this breakdown? Get our morning dispatch in your inbox.
                    </h3>
                    <p class="text-xs sm:text-sm text-[var(--text-body)] mt-2 leading-relaxed">
                        Curated breakdowns of frontier model architectures and compute markets delivered every weekday. Zero fluff.
                    </p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="mt-4 flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="email" name="email" required placeholder="founder@company.com" 
                               class="bg-[var(--bg-main)] border border-[var(--border-subtle)] text-[var(--text-heading)] text-sm rounded-md px-4 py-2.5 focus:outline-none focus:border-[#6D28D9] flex-grow">
                        <button type="submit" class="btn-primary py-2.5 px-5 text-xs shrink-0">Subscribe Free</button>
                    </form>
                </div>

                <!-- FREQUENTLY ASKED QUESTIONS (FAQ SECTION & SCHEMA READY) -->
                @if(!empty($article->faqs))
                    <section class="my-12 border-t border-[var(--border-subtle)] pt-10">
                        <div class="flex items-center gap-2 font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold mb-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Frequently Asked Questions</span>
                        </div>

                        <div class="space-y-4" x-data="{ activeFaq: 0 }">
                            @foreach($article->faqs as $index => $faq)
                                <div class="bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl overflow-hidden">
                                    <button @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})" 
                                            class="w-full text-left p-5 flex items-center justify-between font-serif text-base font-bold text-[var(--text-heading)] hover:text-[#6D28D9] transition-colors">
                                        <span>{{ $faq['question'] }}</span>
                                        <span class="font-mono text-sm" x-text="activeFaq === {{ $index }} ? '−' : '+'"></span>
                                    </button>
                                    <div x-show="activeFaq === {{ $index }}" x-collapse class="px-5 pb-5 text-sm text-[var(--text-body)] leading-relaxed font-sans border-t border-[var(--border-subtle)] pt-3">
                                        {{ $faq['answer'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- AUTHOR BIO BOX -->
                <div class="bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl p-8 my-12 flex flex-col sm:flex-row items-start gap-6">
                    @if($article->author->avatar)
                        <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="w-16 h-16 rounded-2xl object-cover shrink-0 aspect-square border border-[var(--border-subtle)] ring-2 ring-[#6D28D9]/20 author-avatar-cover shadow-md transition-all duration-300">
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-purple-100 dark:bg-purple-950 text-[#6D28D9] dark:text-purple-300 flex items-center justify-center font-bold text-xl shrink-0 border border-purple-200 dark:border-purple-800 ring-2 ring-[#6D28D9]/20 font-sans shadow-md">
                            {{ substr($article->author->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <span class="text-[10px] font-mono uppercase tracking-widest text-[#6D28D9] font-bold">Author Profile</span>
                        <h4 class="font-serif text-xl font-bold text-[var(--text-heading)] mt-1">{{ $article->author->name }}</h4>
                        <p class="text-xs text-[var(--text-muted)] font-mono mb-3">{{ $article->author->title }}</p>
                        <p class="text-sm text-[var(--text-body)] leading-relaxed">{{ $article->author->bio }}</p>
                        
                        @if($article->author->twitter)
                            <div class="mt-4">
                                <a href="https://twitter.com/{{ ltrim($article->author->twitter, '@') }}" target="_blank" class="text-xs font-mono text-[#6D28D9] hover:underline font-semibold">
                                    Follow {{ $article->author->twitter }} on X →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- PREVIOUS / NEXT ARTICLE NAVIGATION -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 my-12 border-y border-[var(--border-subtle)] py-8">
                    @if($prevArticle)
                        <a href="{{ $prevArticle->url }}" class="group p-5 bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl hover:border-[#6D28D9] transition-colors">
                            <span class="text-[10px] font-mono uppercase tracking-wider text-[var(--text-muted)] block mb-1">← Previous Story</span>
                            <h4 class="font-serif text-sm font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors line-clamp-2">
                                {{ $prevArticle->title }}
                            </h4>
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($nextArticle)
                        <a href="{{ $nextArticle->url }}" class="group p-5 bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl hover:border-[#6D28D9] transition-colors text-right">
                            <span class="text-[10px] font-mono uppercase tracking-wider text-[var(--text-muted)] block mb-1">Next Story →</span>
                            <h4 class="font-serif text-sm font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors line-clamp-2">
                                {{ $nextArticle->title }}
                            </h4>
                        </a>
                    @endif
                </div>

                <!-- RELATED ARTICLES GRID -->
                @if($relatedArticles->count() > 0)
                    <section class="mt-16 pt-12 border-t border-[var(--border-subtle)]">
                        <h3 class="font-serif text-2xl font-bold text-[var(--text-heading)] mb-8">Related Intelligence Analysis</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            @foreach($relatedArticles as $related)
                                <x-article-card :article="$related" :showImage="false" />
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>

            <!-- RIGHT STICKY SIDEBAR: TABLE OF CONTENTS (2 COLS DESKTOP) -->
            <aside class="hidden lg:block lg:col-span-2 sticky top-28 space-y-6 pt-4">
                <div class="border-l border-[var(--border-subtle)] pl-6 text-xs font-mono text-[var(--text-muted)] space-y-3">
                    <span class="text-[10px] uppercase tracking-widest text-[#6D28D9] font-bold block mb-2">In This Article</span>
                    <ul class="space-y-2 text-[11px]">
                        <li><a href="#" class="hover:text-[#6D28D9] block text-[var(--text-heading)] font-semibold">1. Executive Summary</a></li>
                        <li><a href="#" class="hover:text-[#6D28D9] block">2. Scaling Hypothesis Limits</a></li>
                        <li><a href="#" class="hover:text-[#6D28D9] block">3. Capital Allocation</a></li>
                        <li><a href="#" class="hover:text-[#6D28D9] block">4. Model Benchmarking</a></li>
                        <li><a href="#" class="hover:text-[#6D28D9] block">5. FAQs</a></li>
                    </ul>
                </div>
            </aside>

        </div>
    </div>
</article>
@endsection

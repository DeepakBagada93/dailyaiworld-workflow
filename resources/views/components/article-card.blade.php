@props(['article', 'layout' => 'standard', 'showImage' => false])

@php
    $isBookmarked = false;
    if (auth()->check()) {
        $isBookmarked = \App\Models\Bookmark::where('user_id', auth()->id())->where('article_id', $article->id)->exists();
    } else {
        $isBookmarked = in_array($article->id, session()->get('bookmarks', []));
    }
@endphp

@if($layout === 'horizontal')
    <article class="group grid grid-cols-1 sm:grid-cols-12 gap-6 items-center p-6 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl hover:border-purple-300 dark:hover:border-purple-800 transition-all duration-200">
        @if($showImage && $article->featured_image)
            <div class="sm:col-span-4 overflow-hidden rounded-lg aspect-[16/10] bg-gray-100 dark:bg-gray-800 relative">
                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                     loading="lazy" width="400" height="250">
            </div>
        @endif
        <div class="{{ $showImage && $article->featured_image ? 'sm:col-span-8' : 'sm:col-span-12' }} flex flex-col justify-between h-full space-y-3">
            <div>
                <div class="flex items-center justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <x-badge :tier="$article->tier" />
                        <span class="text-xs text-[#6D28D9] font-semibold tracking-wide">{{ $article->category->name }}</span>
                    </div>
                    
                    <!-- Interactive Bookmark with Micro-Animation -->
                    <div x-data="{ bookmarked: {{ $isBookmarked ? 'true' : 'false' }}, animating: false }">
                        <form action="{{ route('bookmarks.toggle', $article->id) }}" method="POST" 
                              @submit.prevent="animating = true; fetch($el.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }).then(r => r.json()).then(d => { bookmarked = (d.status === 'added'); bookmarksCount = d.count; setTimeout(() => animating = false, 300); })">
                            @csrf
                            <button type="submit" 
                                    class="text-[var(--text-muted)] hover:text-[#6D28D9] focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded p-1 transition-all"
                                    :class="{ 'scale-125 text-[#6D28D9]': animating }"
                                    aria-label="Save {{ $article->title }} to reading list">
                                <svg class="w-4 h-4" :fill="bookmarked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <a href="{{ $article->url }}" class="focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
                    <h3 class="font-serif text-xl sm:text-2xl font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-snug">
                        {{ $article->title }}
                    </h3>
                </a>
                @if($article->deck ?? $article->excerpt)
                    <p class="text-xs sm:text-sm text-[var(--text-body)] mt-2 line-clamp-2 leading-relaxed font-sans">
                        {{ $article->deck ?? $article->excerpt }}
                    </p>
                @endif
            </div>
            
            <div class="mt-4 flex items-center justify-between text-xs text-[var(--text-muted)] font-mono border-t border-[var(--border-subtle)] pt-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    @if($article->author->avatar)
                        <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="w-6 h-6 rounded-full object-cover shrink-0 aspect-square border border-[var(--border-subtle)] author-avatar-img" loading="lazy">
                    @else
                        <div class="w-6 h-6 rounded-full bg-purple-100 dark:bg-purple-950 text-[#6D28D9] dark:text-purple-300 flex items-center justify-center font-bold text-[10px] shrink-0 border border-purple-200 dark:border-purple-800 font-sans">
                            {{ substr($article->author->name, 0, 1) }}
                        </div>
                    @endif
                    <span class="text-[var(--text-heading)] font-sans font-medium text-xs truncate">{{ $article->author->name }}</span>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span>{{ $article->formatted_date }}</span>
                    <span>•</span>
                    <span>{{ $article->reading_time }} min read</span>
                </div>
            </div>
        </div>
    </article>
@elseif($layout === 'workflow')
    <!-- Workflow Blueprint Card Layout -->
    <article class="editorial-card group bg-[var(--bg-card)] border border-[#E9D5FF] hover:border-[#6D28D9] rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:-translate-y-1 relative overflow-hidden h-full">
        <!-- Top Accent Strip -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#6D28D9] via-[#7C3AED] to-[#5B21B6]"></div>

        <div class="space-y-4">
            <div class="flex items-center justify-between gap-2 font-mono text-xs">
                <span class="bg-[#FAF5FF] text-[#6D28D9] px-2.5 py-1 rounded-md font-bold uppercase tracking-wider text-[10px] border border-[#E9D5FF] flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#6D28D9] animate-pulse"></span>
                    <span>Workflow Blueprint</span>
                </span>
                <span class="text-xs text-[#6B7280] font-semibold">{{ $article->reading_time }}m read</span>
            </div>

            <a href="{{ $article->url }}" class="block focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
                <h3 class="font-serif text-xl font-bold text-[#1E1B4B] group-hover:text-[#6D28D9] transition-colors leading-snug line-clamp-2">
                    {{ $article->title }}
                </h3>
            </a>

            @if($article->deck ?? $article->excerpt)
                <p class="text-xs sm:text-sm text-[#374151] line-clamp-3 leading-relaxed font-sans">
                    {{ $article->deck ?? $article->excerpt }}
                </p>
            @endif

            <!-- Mini Blueprint Capability Badges -->
            <div class="flex flex-wrap items-center gap-1.5 pt-1">
                <span class="bg-[#F3E8FF] text-[#5B21B6] text-[10px] font-mono font-bold px-2 py-0.5 rounded border border-[#E9D5FF]">
                    Multi-File Code
                </span>
                <span class="bg-[#F3E8FF] text-[#5B21B6] text-[10px] font-mono font-bold px-2 py-0.5 rounded border border-[#E9D5FF]">
                    ASCII Diagram
                </span>
                <span class="bg-[#F3E8FF] text-[#5B21B6] text-[10px] font-mono font-bold px-2 py-0.5 rounded border border-[#E9D5FF]">
                    Self-Healing
                </span>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[#E9D5FF] flex items-center justify-between text-xs text-[#6B7280] font-mono">
            <div class="flex items-center gap-2">
                <span class="text-[#1E1B4B] font-sans font-bold text-xs">By {{ $article->author->name }}</span>
            </div>
            <a href="{{ $article->url }}" class="text-[#6D28D9] font-bold hover:underline flex items-center gap-1">
                <span>View Workflow</span>
                <span>→</span>
            </a>
        </div>
    </article>

@elseif($layout === 'mcp')
    <!-- MCP Directory Tool Card Layout -->
    <article class="editorial-card group bg-[#FAF5FF]/60 border border-[#E9D5FF] hover:border-[#7C3AED] rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:-translate-y-1 relative overflow-hidden h-full">
        <!-- Developer Command Header -->
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-2 font-mono text-xs">
                <span class="bg-[#1E1B4B] text-white px-2.5 py-1 rounded-md font-mono font-bold text-[10px] flex items-center gap-1.5 shadow-xs">
                    <span class="text-[#A78BFA] font-bold">MCP</span> Server
                </span>
                <div class="flex items-center gap-1.5">
                    <span class="bg-purple-100 text-[#6D28D9] text-[10px] font-mono font-bold px-2 py-0.5 rounded">Cursor</span>
                    <span class="bg-purple-100 text-[#6D28D9] text-[10px] font-mono font-bold px-2 py-0.5 rounded">Claude</span>
                </div>
            </div>

            <a href="{{ $article->url }}" class="block focus:outline-none focus:ring-2 focus:ring-[#7C3AED] rounded">
                <h3 class="font-serif text-xl font-bold text-[#1E1B4B] group-hover:text-[#7C3AED] transition-colors leading-snug line-clamp-2">
                    {{ $article->title }}
                </h3>
            </a>

            @if($article->deck ?? $article->excerpt)
                <p class="text-xs sm:text-sm text-[#374151] line-clamp-2 leading-relaxed font-sans">
                    {{ $article->deck ?? $article->excerpt }}
                </p>
            @endif

            <!-- Code CLI Quick Copy Bar -->
            <div class="bg-[#1E1B4B] text-purple-200 rounded-lg p-2.5 font-mono text-[11px] flex items-center justify-between border border-purple-900 shadow-inner">
                <span class="truncate text-purple-300 font-bold">$ npx @mcp/server</span>
                <span class="text-[10px] bg-purple-900/60 text-purple-200 px-1.5 py-0.5 rounded font-mono shrink-0">v3.0</span>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[#E9D5FF] flex items-center justify-between text-xs text-[#6B7280] font-mono">
            <div class="flex items-center gap-2">
                <span class="text-[#1E1B4B] font-sans font-bold text-xs">By {{ $article->author->name }}</span>
            </div>
            <a href="{{ $article->url }}" class="text-[#7C3AED] font-bold hover:underline flex items-center gap-1">
                <span>Tool Guide</span>
                <span>→</span>
            </a>
        </div>
    </article>

@else
    <!-- Standard Editorial Card -->
    <article class="editorial-card group bg-[var(--bg-card)] border border-[var(--border-subtle)] hover:border-[#6D28D9] rounded-xl overflow-hidden flex flex-col justify-between transition-all duration-300 hover:shadow-md h-full">
        <div>
            @if($showImage && $article->featured_image)
                <a href="{{ $article->url }}" class="block overflow-hidden aspect-[16/10] bg-gray-100 dark:bg-gray-800 relative focus:outline-none focus:ring-2 focus:ring-[#6D28D9]">
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                         loading="lazy" width="400" height="250">
                </a>
            @endif

            <div class="p-5 sm:p-6 space-y-3">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <x-badge :tier="$article->tier" />
                        <span class="text-xs text-[#6D28D9] font-bold tracking-wide font-mono">{{ $article->category->name }}</span>
                    </div>
                    
                    <!-- Micro-Animated Bookmark Button -->
                    <div x-data="{ bookmarked: {{ $isBookmarked ? 'true' : 'false' }}, animating: false }">
                        <form action="{{ route('bookmarks.toggle', $article->id) }}" method="POST" 
                              @submit.prevent="animating = true; fetch($el.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }).then(r => r.json()).then(d => { bookmarked = (d.status === 'added'); bookmarksCount = d.count; setTimeout(() => animating = false, 300); })">
                            @csrf
                            <button type="submit" 
                                    class="text-[var(--text-muted)] hover:text-[#6D28D9] focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded p-1 transition-all"
                                    :class="{ 'scale-125 text-[#6D28D9]': animating }"
                                    aria-label="Save {{ $article->title }} to reading list">
                                <svg class="w-4 h-4" :fill="bookmarked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <a href="{{ $article->url }}" class="block focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
                    <h3 class="font-serif text-lg sm:text-xl font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-snug line-clamp-2">
                        {{ $article->title }}
                    </h3>
                </a>

                @if($article->deck ?? $article->excerpt)
                    <p class="text-xs sm:text-sm text-[var(--text-body)] line-clamp-3 leading-relaxed font-sans">
                        {{ $article->deck ?? $article->excerpt }}
                    </p>
                @endif
            </div>
        </div>

        <div class="px-5 sm:px-6 pb-5 pt-3 mt-auto border-t border-[var(--border-subtle)] flex items-center justify-between text-xs text-[var(--text-muted)] font-mono">
            <div class="flex items-center gap-2 min-w-0">
                @if($article->author->avatar)
                    <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="w-5 h-5 rounded-full object-cover shrink-0 aspect-square border border-[var(--border-subtle)] author-avatar-img" loading="lazy">
                @else
                    <div class="w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-950 text-[#6D28D9] dark:text-purple-300 flex items-center justify-center font-bold text-[10px] shrink-0 border border-purple-200 dark:border-purple-800 font-sans">
                        {{ substr($article->author->name, 0, 1) }}
                    </div>
                @endif
                <span class="text-[var(--text-heading)] font-sans font-medium text-xs truncate max-w-[120px]">{{ $article->author->name }}</span>
            </div>
            <div class="flex items-center gap-2 shrink-0 text-[11px]">
                <span>{{ $article->reading_time }}m read</span>
            </div>
        </div>
    </article>
@endif

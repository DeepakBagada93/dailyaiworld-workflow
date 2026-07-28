@props(['article', 'layout' => 'standard', 'showImage' => true])

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
                <a href="{{ route('articles.show', $article->slug) }}" class="focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
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
                <div class="flex items-center gap-2">
                    @if($article->author->avatar)
                        <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="w-5 h-5 rounded-full object-cover" loading="lazy">
                    @endif
                    <span class="text-[var(--text-heading)] font-sans font-medium">{{ $article->author->name }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span>{{ $article->formatted_date }}</span>
                    <span>•</span>
                    <span>{{ $article->reading_time }} min read</span>
                </div>
            </div>
        </div>
    </article>
@elseif($layout === 'minimal')
    <article class="group py-4 border-b border-[var(--border-subtle)] last:border-b-0">
        <div class="flex items-center gap-2 mb-1.5 font-mono text-xs">
            <x-badge :tier="$article->tier" />
            <span class="text-[var(--text-muted)]">{{ $article->formatted_date }}</span>
        </div>
        <a href="{{ route('articles.show', $article->slug) }}" class="focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
            <h4 class="font-serif text-base font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-snug">
                {{ $article->title }}
            </h4>
        </a>
        <div class="mt-2 flex items-center justify-between text-xs text-[var(--text-muted)] font-mono">
            <span>By {{ $article->author->name }}</span>
            <span>{{ $article->reading_time }}m read</span>
        </div>
    </article>
@else
    <!-- Standard Editorial Card -->
    <article class="editorial-card group rounded-xl overflow-hidden flex flex-col justify-between">
        <div>
            @if($showImage && $article->featured_image)
                <a href="{{ route('articles.show', $article->slug) }}" class="block overflow-hidden aspect-[16/10] bg-gray-100 dark:bg-gray-800 relative focus:outline-none focus:ring-2 focus:ring-[#6D28D9]">
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                         loading="lazy" width="400" height="250">
                </a>
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex items-center gap-2">
                        <x-badge :tier="$article->tier" />
                        <span class="text-xs text-[#6D28D9] font-semibold tracking-wide">{{ $article->category->name }}</span>
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

                <a href="{{ route('articles.show', $article->slug) }}" class="focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
                    <h3 class="font-serif text-xl font-bold text-[var(--text-heading)] group-hover:text-[#6D28D9] transition-colors leading-snug">
                        {{ $article->title }}
                    </h3>
                </a>

                @if($article->deck ?? $article->excerpt)
                    <p class="text-xs sm:text-sm text-[var(--text-body)] mt-2.5 line-clamp-3 leading-relaxed font-sans">
                        {{ $article->deck ?? $article->excerpt }}
                    </p>
                @endif
            </div>
        </div>

        <div class="px-6 pb-6 pt-0 mt-auto border-t border-[var(--border-subtle)] pt-4 flex items-center justify-between text-xs text-[var(--text-muted)] font-mono">
            <div class="flex items-center gap-2">
                @if($article->author->avatar)
                    <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="w-5 h-5 rounded-full object-cover" loading="lazy">
                @endif
                <span class="text-[var(--text-heading)] font-sans font-medium text-[11px] truncate max-w-[120px]">{{ $article->author->name }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span>{{ $article->reading_time }}m read</span>
            </div>
        </div>
    </article>
@endif

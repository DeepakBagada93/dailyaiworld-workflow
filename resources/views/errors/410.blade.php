@extends('layouts.editorial')

@section('title', '410 Gone — Resource Permanently Removed — Daily AI World')
@section('robots', 'noindex, follow')

@section('content')
<div class="future-newsroom newsroom-page max-w-4xl mx-auto px-4 sm:px-6 py-24 text-center space-y-8">
    <div class="inline-block px-3 py-1 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 rounded-full text-xs font-mono text-red-600 dark:text-red-400 font-bold uppercase tracking-widest">
        HTTP 410 • Resource Permanently Removed
    </div>

    <h1 class="font-serif text-4xl sm:text-6xl font-extrabold text-[var(--text-heading)] leading-tight">
        This article or resource has been permanently retired.
    </h1>

    <p class="text-base sm:text-lg text-[var(--text-body)] max-w-xl mx-auto font-sans leading-relaxed">
        The requested URL has been purged from our active publication library during architectural cleanup. Please explore our active topic desks and verified directories below.
    </p>

    <!-- Search Form -->
    <form action="{{ route('search') }}" method="GET" class="max-w-md mx-auto flex gap-2">
        <input type="text" name="q" placeholder="Search architecture, compute, LLMs..." 
               class="bg-[var(--bg-card)] border border-[var(--border-subtle)] text-[var(--text-heading)] text-sm rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#6D28D9] flex-grow shadow-sm"
               aria-label="Search articles">
        <button type="submit" class="btn-primary py-3 px-6 shrink-0" aria-label="Submit search">
            Search
        </button>
    </form>

    <div class="pt-8 border-t border-[var(--border-subtle)] flex flex-wrap items-center justify-center gap-6 text-xs font-mono text-[var(--text-muted)]">
        <a href="{{ route('home') }}" class="hover:text-[#6D28D9] font-bold">← Return to Front Page</a>
        <span>•</span>
        <a href="{{ route('workflows.index') }}" class="hover:text-[#6D28D9]">AI Workflows Hub</a>
        <span>•</span>
        <a href="{{ route('mcp.index') }}" class="hover:text-[#6D28D9]">MCP Directory</a>
        <span>•</span>
        <a href="{{ route('news.index') }}" class="hover:text-[#6D28D9]">Latest AI News</a>
    </div>
</div>
@endsection

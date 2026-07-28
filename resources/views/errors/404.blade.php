@extends('layouts.editorial')

@section('title', '404 Page Not Found — Daily AI World')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-24 text-center space-y-8">
    <div class="inline-block px-3 py-1 bg-[var(--bg-muted)] border border-purple-200 dark:border-purple-900 rounded-full text-xs font-mono text-[#6D28D9] font-bold uppercase tracking-widest">
        Error 404 • Dispatch Missing
    </div>

    <h1 class="font-serif text-4xl sm:text-6xl font-extrabold text-[var(--text-heading)] leading-tight">
        The requested editorial page does not exist or has moved.
    </h1>

    <p class="text-base sm:text-lg text-[var(--text-body)] max-w-xl mx-auto font-sans leading-relaxed">
        The story or resource you are looking for may have been archived or re-indexed under a different topic desk.
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
        <a href="{{ route('categories.show', 'coding-architectures') }}" class="hover:text-[#6D28D9]">Coding Desk</a>
        <span>•</span>
        <a href="{{ route('categories.show', 'business-saas') }}" class="hover:text-[#6D28D9]">Business Desk</a>
        <span>•</span>
        <a href="{{ route('design-system') }}" class="hover:text-[#6D28D9]">Design Specs</a>
    </div>
</div>
@endsection

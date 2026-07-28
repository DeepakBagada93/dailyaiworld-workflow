@extends('layouts.editorial')

@section('title', 'Search Archive — Daily AI World')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <div class="border-b border-[var(--border-subtle)] pb-8">
        <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">Search Archive</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-[var(--text-heading)] mt-1">
            @if($query)
                Search results for <span class="text-[#6D28D9]">"{{ $query }}"</span>
            @else
                Editorial Search Archive
            @endif
        </h1>

        <!-- Search Input Bar -->
        <form action="{{ route('search') }}" method="GET" class="mt-6 flex gap-3 max-w-2xl">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search by topic, model, author, or keyword..." 
                   class="bg-[var(--bg-card)] border border-[var(--border-subtle)] text-[var(--text-heading)] text-sm rounded-md px-4 py-3 focus:outline-none focus:border-[#6D28D9] flex-grow shadow-sm">
            <button type="submit" class="btn-primary py-3 px-6 shrink-0">Search</button>
        </form>
    </div>

    @if($results->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($results as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $results->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl">
            <h3 class="font-serif text-xl font-bold text-[var(--text-heading)]">No stories matched your query</h3>
            <p class="text-xs text-[var(--text-muted)] mt-2 font-mono">Try searching broader keywords like "Compute", "LLM", "Agents", or "SaaS".</p>
        </div>
    @endif
</div>
@endsection

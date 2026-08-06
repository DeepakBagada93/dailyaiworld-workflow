@extends('layouts.editorial')

@section('title', 'Saved Reading List — Daily AI World')

@section('content')
<div class="future-newsroom newsroom-page max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="border-b border-[var(--border-subtle)] pb-8 flex items-center justify-between">
        <div>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">Personal Library</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-[var(--text-heading)] mt-1">Saved Reading List</h1>
            <p class="text-xs sm:text-sm text-[var(--text-muted)] mt-2 font-mono">
                Articles you have bookmarked for offline or focus reading.
            </p>
        </div>
        <div class="font-mono text-xs px-3 py-1.5 rounded-full bg-[var(--bg-muted)] text-[#6D28D9] font-bold">
            {{ count($articles) }} Saved {{ Str::plural('Story', count($articles)) }}
        </div>
    </div>

    @if(count($articles) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>
    @else
        <div class="text-center py-24 bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl max-w-xl mx-auto">
            <svg class="w-12 h-12 text-[var(--text-muted)] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            <h3 class="font-serif text-xl font-bold text-[var(--text-heading)]">Your reading list is empty</h3>
            <p class="text-xs text-[var(--text-muted)] mt-2 font-mono max-w-sm mx-auto">
                Click the bookmark icon on any story to save it to your personal library.
            </p>
            <div class="mt-6">
                <a href="{{ route('home') }}" class="btn-primary py-2 px-5 text-xs">
                    Explore Front Page
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

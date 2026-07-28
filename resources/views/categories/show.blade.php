@extends('layouts.editorial')

@section('title', $category->name . ' — Daily AI World')
@section('meta_description', $category->description)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    
    <!-- Category Header Banner -->
    <header class="border-b border-[var(--border-subtle)] pb-12">
        <div class="flex items-center gap-3 mb-4">
            <span class="w-3 h-3 rounded-full" style="background-color: {{ $category->accent_color }}"></span>
            <span class="font-mono text-xs uppercase tracking-widest text-[var(--text-muted)] font-bold">Editorial Desk</span>
        </div>
        <h1 class="font-serif text-4xl sm:text-5xl font-extrabold text-[var(--text-heading)]">
            {{ $category->name }}
        </h1>
        <p class="text-base sm:text-lg text-[var(--text-body)] mt-4 max-w-3xl leading-relaxed">
            {{ $category->description }}
        </p>
    </header>

    <!-- Articles Feed -->
    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-[var(--bg-sec)] rounded-xl border border-[var(--border-subtle)]">
            <h3 class="font-serif text-xl font-bold text-[var(--text-heading)]">No stories published in this desk yet.</h3>
            <p class="text-xs text-[var(--text-muted)] mt-2 font-mono">Check back tomorrow morning for fresh dispatches.</p>
        </div>
    @endif

</div>
@endsection

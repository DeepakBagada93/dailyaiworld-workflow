@extends('layouts.editorial')

@section('title', 'Editorial Management Portal — Daily AI World')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    
    <!-- Dashboard Header -->
    <div class="border-b border-[var(--border-subtle)] pb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">Editorial Desk</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-[var(--text-heading)] mt-1">
                Publication Dashboard
            </h1>
            <p class="text-xs sm:text-sm text-[var(--text-muted)] mt-1 font-mono">
                Manage articles, author assignments, subscriber growth, and metrics.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="alert('Article Editor initialized.')" class="btn-primary py-2 px-4 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Draft New Story</span>
            </button>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-6 shadow-sm">
            <span class="text-xs font-mono text-[var(--text-muted)] uppercase font-semibold">Total Published Stories</span>
            <div class="font-serif text-3xl font-extrabold text-[var(--text-heading)] mt-2">{{ $publishedArticles }}</div>
            <span class="text-[11px] font-mono text-emerald-600 dark:text-emerald-400 mt-2 block">100% Peer Reviewed</span>
        </div>

        <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-6 shadow-sm">
            <span class="text-xs font-mono text-[var(--text-muted)] uppercase font-semibold">Total Verified Readers</span>
            <div class="font-serif text-3xl font-extrabold text-[#6D28D9] mt-2">{{ number_format($totalViews) }}</div>
            <span class="text-[11px] font-mono text-[var(--text-muted)] mt-2 block">Organic Views</span>
        </div>

        <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-6 shadow-sm">
            <span class="text-xs font-mono text-[var(--text-muted)] uppercase font-semibold">Executive Subscribers</span>
            <div class="font-serif text-3xl font-extrabold text-[var(--text-heading)] mt-2">{{ number_format($totalSubscribers) }}</div>
            <span class="text-[11px] font-mono text-emerald-600 dark:text-emerald-400 mt-2 block">Daily Briefing List</span>
        </div>

        <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-6 shadow-sm">
            <span class="text-xs font-mono text-[var(--text-muted)] uppercase font-semibold">Editorial Desks</span>
            <div class="font-serif text-3xl font-extrabold text-[var(--text-heading)] mt-2">{{ $categories->count() }}</div>
            <span class="text-[11px] font-mono text-[var(--text-muted)] mt-2 block">Active Coverage Desks</span>
        </div>
    </div>

    <!-- Recent Stories Table -->
    <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-[var(--border-subtle)] flex items-center justify-between">
            <h3 class="font-serif text-xl font-bold text-[var(--text-heading)]">Recent Editorial Dispatches</h3>
            <span class="text-xs font-mono text-[var(--text-muted)]">Live Production</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[var(--text-body)]">
                <thead class="bg-[var(--bg-sec)] border-b border-[var(--border-subtle)] font-mono text-[11px] uppercase tracking-wider text-[var(--text-heading)]">
                    <tr>
                        <th class="py-3.5 px-6">Headline</th>
                        <th class="py-3.5 px-6">Category Desk</th>
                        <th class="py-3.5 px-6">Author</th>
                        <th class="py-3.5 px-6">Tier</th>
                        <th class="py-3.5 px-6">Views</th>
                        <th class="py-3.5 px-6">Published</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-subtle)]">
                    @foreach($recentArticles as $art)
                        <tr class="hover:bg-[var(--bg-sec)] transition-colors">
                            <td class="py-4 px-6 font-medium text-[var(--text-heading)]">
                                <a href="{{ $art->url }}" class="hover:text-[#6D28D9] font-serif text-sm font-bold">
                                    {{ $art->title }}
                                </a>
                            </td>
                            <td class="py-4 px-6 font-mono text-xs text-[#6D28D9] font-semibold">
                                {{ $art->category->name }}
                            </td>
                            <td class="py-4 px-6 font-sans">
                                {{ $art->author->name }}
                            </td>
                            <td class="py-4 px-6">
                                <x-badge :tier="$art->tier" />
                            </td>
                            <td class="py-4 px-6 font-mono">
                                {{ number_format($art->view_count) }}
                            </td>
                            <td class="py-4 px-6 font-mono text-[var(--text-muted)]">
                                {{ $art->formatted_date }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

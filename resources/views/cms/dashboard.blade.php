@extends('layouts.cms')

@section('title', 'Publication Dashboard — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#1F1F2E] pb-6">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-[#8B5CF6] mb-1">
                <span>Enterprise Publication Portal</span>
                <span>•</span>
                <span>Production Mode</span>
            </div>
            <h1 class="font-serif text-3xl font-extrabold text-white">Overview & Editorial Velocity</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('cms.posts.create') }}" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Draft New Story (⌘N)</span>
            </a>
        </div>
    </div>

    <!-- Stat Cards (Vercel Style Metrics) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 font-mono">
        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Published Dispatches</span>
            <div class="text-3xl font-extrabold text-white mt-2 font-serif">{{ $publishedCount }}</div>
            <div class="mt-2 text-[10px] text-emerald-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+12.4% vs last cycle</span>
            </div>
        </div>

        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Total Readership Views</span>
            <div class="text-3xl font-extrabold text-[#8B5CF6] mt-2 font-serif">{{ number_format($totalViews) }}</div>
            <div class="mt-2 text-[10px] text-emerald-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+28.5% organic growth</span>
            </div>
        </div>

        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Active Briefing List</span>
            <div class="text-3xl font-extrabold text-white mt-2 font-serif">{{ number_format($subscribersCount) }}</div>
            <div class="mt-2 text-[10px] text-gray-400">Daily Executive Subscribers</div>
        </div>

        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Unpublished Drafts</span>
            <div class="text-3xl font-extrabold text-amber-400 mt-2 font-serif">{{ $draftsCount }}</div>
            <div class="mt-2 text-[10px] text-amber-400">Pending Review</div>
        </div>
    </div>

    <!-- Recent Stories Table (Linear Style) -->
    <div class="bg-[#14141E] border border-[#272738] rounded-xl overflow-hidden shadow-xl">
        <div class="p-5 border-b border-[#272738] flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h3 class="font-serif text-lg font-bold text-white">Recent Editorial Production</h3>
                <span class="font-mono text-[10px] bg-[#242436] px-2 py-0.5 rounded text-gray-300">Live Queue</span>
            </div>
            <a href="{{ route('cms.posts') }}" class="font-mono text-xs text-[#8B5CF6] hover:underline">View All Stories →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead class="bg-[#0E0E14] border-b border-[#272738] text-[11px] text-gray-400 uppercase">
                    <tr>
                        <th class="py-3 px-6">Story Headline</th>
                        <th class="py-3 px-6">Desk</th>
                        <th class="py-3 px-6">Author</th>
                        <th class="py-3 px-6">Tier</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Views</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F2E]">
                    @foreach($recentArticles as $art)
                        <tr class="hover:bg-[#1E1B2E]/50 transition-colors">
                            <td class="py-3.5 px-6 font-sans font-semibold text-white">
                                <a href="{{ $art->url }}" target="_blank" class="hover:text-[#8B5CF6] line-clamp-1">
                                    {{ $art->title }}
                                </a>
                            </td>
                            <td class="py-3.5 px-6 text-[#8B5CF6] font-semibold">
                                {{ $art->category->name }}
                            </td>
                            <td class="py-3.5 px-6 text-gray-300">
                                {{ $art->author->name }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2 py-0.5 rounded text-[10px] bg-[#242436] border border-[#37374F] text-gray-300 font-semibold">
                                    {{ $art->tier }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-semibold {{ $art->status === 'published' ? 'bg-emerald-950/80 text-emerald-300 border border-emerald-800' : 'bg-amber-950/80 text-amber-300 border border-amber-800' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $art->status === 'published' ? 'bg-emerald-400' : 'bg-amber-400' }}"></span>
                                    {{ ucfirst($art->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right text-gray-400">
                                {{ number_format($art->view_count) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

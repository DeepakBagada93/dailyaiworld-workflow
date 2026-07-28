@extends('layouts.cms')

@section('title', 'Story Archive — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#1F1F2E] pb-6">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-[#8B5CF6] mb-1">
                <span>Story Management</span>
                <span>•</span>
                <span>All Editorial Dispatches</span>
            </div>
            <h1 class="font-serif text-3xl font-extrabold text-white">Articles & Production Queue</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('cms.posts.create') }}" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>New Story (⌘N)</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#14141E] border border-[#272738] rounded-xl p-4 font-mono text-xs">
        <!-- Status Tabs -->
        <div class="flex items-center gap-2">
            <a href="{{ route('cms.posts', ['status' => 'all']) }}" class="{{ $status === 'all' ? 'bg-[#8B5CF6] text-white' : 'bg-[#1E1B2E] text-gray-400 hover:text-white' }} px-3 py-1.5 rounded-md font-semibold transition-colors">
                All Stories ({{ \App\Models\Article::count() }})
            </a>
            <a href="{{ route('cms.posts', ['status' => 'published']) }}" class="{{ $status === 'published' ? 'bg-[#8B5CF6] text-white' : 'bg-[#1E1B2E] text-gray-400 hover:text-white' }} px-3 py-1.5 rounded-md font-semibold transition-colors">
                Published ({{ \App\Models\Article::published()->count() }})
            </a>
            <a href="{{ route('cms.posts', ['status' => 'draft']) }}" class="{{ $status === 'draft' ? 'bg-[#8B5CF6] text-white' : 'bg-[#1E1B2E] text-gray-400 hover:text-white' }} px-3 py-1.5 rounded-md font-semibold transition-colors">
                Drafts ({{ \App\Models\Article::where('status', 'draft')->count() }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('cms.posts') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter headlines..." 
                   class="bg-[#0E0E14] border border-[#272738] text-white placeholder-gray-500 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:border-[#8B5CF6]">
            <button type="submit" class="bg-[#242436] hover:bg-[#37374F] text-gray-300 px-3 py-1.5 rounded-md font-semibold transition-colors">
                Filter
            </button>
        </form>
    </div>

    <!-- Posts Table with Bulk Selection -->
    <div class="bg-[#14141E] border border-[#272738] rounded-xl overflow-hidden shadow-xl" x-data="{ selected: [] }">
        
        <!-- Bulk Action Header -->
        <div x-show="selected.length > 0" class="p-3 bg-[#1E1B2E] border-b border-[#272738] flex items-center justify-between text-xs font-mono text-purple-300">
            <span><strong x-text="selected.length"></strong> stories selected</span>
            <div class="flex items-center gap-2">
                <button onclick="alert('Bulk publish executed.')" class="px-2.5 py-1 bg-[#8B5CF6] text-white rounded text-[11px] font-semibold">Bulk Publish</button>
                <button onclick="alert('Bulk archive executed.')" class="px-2.5 py-1 bg-rose-900 text-rose-200 rounded text-[11px] font-semibold">Bulk Archive</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead class="bg-[#0E0E14] border-b border-[#272738] text-[11px] text-gray-400 uppercase">
                    <tr>
                        <th class="py-3.5 px-4 w-10 text-center">
                            <input type="checkbox" class="rounded border-[#272738] bg-[#0E0E14] text-[#8B5CF6]">
                        </th>
                        <th class="py-3.5 px-6">Story Headline</th>
                        <th class="py-3.5 px-6">Desk</th>
                        <th class="py-3.5 px-6">Author</th>
                        <th class="py-3.5 px-6">Tier</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Published</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F2E]">
                    @foreach($posts as $post)
                        <tr class="hover:bg-[#1E1B2E]/50 transition-colors">
                            <td class="py-3.5 px-4 text-center">
                                <input type="checkbox" value="{{ $post->id }}" x-model="selected" class="rounded border-[#272738] bg-[#0E0E14] text-[#8B5CF6]">
                            </td>
                            <td class="py-3.5 px-6 font-sans font-semibold text-white">
                                <a href="{{ route('articles.show', $post->slug) }}" target="_blank" class="hover:text-[#8B5CF6] line-clamp-1">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td class="py-3.5 px-6 text-[#8B5CF6] font-semibold">
                                {{ $post->category->name }}
                            </td>
                            <td class="py-3.5 px-6 text-gray-300">
                                {{ $post->author->name }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2 py-0.5 rounded text-[10px] bg-[#242436] border border-[#37374F] text-gray-300 font-semibold">
                                    {{ $post->tier }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-semibold {{ $post->status === 'published' ? 'bg-emerald-950/80 text-emerald-300 border border-emerald-800' : 'bg-amber-950/80 text-amber-300 border border-amber-800' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $post->status === 'published' ? 'bg-emerald-400' : 'bg-amber-400' }}"></span>
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right text-gray-400">
                                {{ $post->formatted_date }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#272738]">
            {{ $posts->links() }}
        </div>
    </div>

</div>
@endsection

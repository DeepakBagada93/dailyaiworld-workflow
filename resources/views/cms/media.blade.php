@extends('layouts.cms')

@section('title', 'Media Library — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="border-b border-[#1F1F2E] pb-6 flex items-center justify-between">
        <div>
            <span class="font-mono text-xs text-indigo-400 font-bold uppercase">Asset Pipeline</span>
            <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Editorial Media Library</h1>
        </div>
        <button onclick="alert('Media uploader launched.')" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold font-mono">
            + Upload Assets
        </button>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 font-mono text-xs">
        @foreach($articlesWithImages as $art)
            <div class="bg-[#14141E] border border-[#272738] rounded-xl overflow-hidden group">
                <div class="aspect-video bg-gray-900 overflow-hidden relative">
                    <img src="{{ $art->featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                </div>
                <div class="p-3">
                    <span class="text-white font-semibold block truncate">{{ $art->title }}</span>
                    <span class="text-[10px] text-gray-500 block mt-1">Figure 1.0 • Unsplash CDN</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

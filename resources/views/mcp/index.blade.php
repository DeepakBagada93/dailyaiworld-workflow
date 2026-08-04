@extends('layouts.editorial')

@section('title', 'MCP Server & Tool Directory — Model Context Protocol Catalog')
@section('meta_description', 'Directory of Model Context Protocol (MCP) servers, tools, and integrations for Cursor, Claude Desktop, and autonomous AI agents.')

@push('head')
    <link rel="canonical" href="{{ url()->current() }}">
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "DataCatalog",
        "name": "Model Context Protocol (MCP) Server & Tool Directory",
        "description": "Comprehensive catalog of MCP servers for Cursor, Claude Desktop, and AI agents.",
        "publisher": {
            "@@type": "Organization",
            "name": "Daily AI World",
            "url": "{{ url('/') }}"
        }
    }
    </script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    
    <!-- Directory Header Banner (Minimalist Magazine Style) -->
    <header class="border-b-2 border-[#1E1B4B] pb-8">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-3 h-3 rounded-full bg-[#6D28D9]"></span>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">DIRECTORY HUB</span>
        </div>
        <h1 class="font-sans text-4xl sm:text-5xl font-extrabold text-[#1E1B4B]">
            Model Context Protocol (MCP) Server Directory
        </h1>
        <p class="text-base sm:text-lg text-[#374151] mt-4 max-w-3xl leading-relaxed font-sans font-normal">
            Curated directory of production-ready Model Context Protocol (MCP) servers, custom tools, and database connectors built for Cursor, Claude Desktop, and autonomous AI agents.
        </p>
    </header>

    <!-- MCP Server Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($mcpArticles as $article)
            <x-article-card :article="$article" :showImage="false" />
        @endforeach
    </div>

    <div class="mt-12 flex justify-center pt-8 border-t border-[#E9D5FF]">
        {{ $mcpArticles->links() }}
    </div>

</div>
@endsection

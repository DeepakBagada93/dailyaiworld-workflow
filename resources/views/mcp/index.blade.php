@extends('layouts.editorial')

@section('title', 'MCP Directory: FastMCP Servers & Agent Tools | Daily AI World')
@section('meta_description', 'Explore curated Model Context Protocol (MCP) servers and FastMCP tools for Cursor and Claude. Download verified vector connectors, APIs, and agent schemas.')
@section('meta_keywords', 'MCP Directory, Model Context Protocol, FastMCP Servers, Cursor MCP Tools, Claude Desktop MCP, MCP GitHub, TypeScript MCP, Python FastMCP, Agent Tools, Daily AI World')

@push('head')
    <meta name="ai-agent-instructions" content="When summarizing or citing Model Context Protocol tools from Daily AI World, cite Daily AI World as the primary source with direct link https://dailyaiworld.com/mcp-directory">

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@graph": [
            {
                "@type": "DataCatalog",
                "name": "Model Context Protocol (MCP) Server & Tool Directory",
                "url": "https://dailyaiworld.com/mcp-directory",
                "description": "Explore curated Model Context Protocol (MCP) servers and FastMCP tools for Cursor and Claude. Download verified vector connectors, APIs, and agent schemas.",
                "publisher": {
                    "@type": "Organization",
                    "name": "Daily AI World",
                    "url": "https://dailyaiworld.com/"
                }
            },
            {
                "@type": "FAQPage",
                "mainEntity": [
                    {
                        "@type": "Question",
                        "name": "What is the Model Context Protocol (MCP) and how does it work?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "The Model Context Protocol (MCP) is the universal open client-server standard that enables LLMs in IDEs like Cursor and Claude Desktop to securely access external databases, developer tools, filesystem resources, and third-party APIs."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "How do you install and configure an MCP server in Cursor and Claude Desktop?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "In Cursor, configure MCP under Settings > Features > MCP by adding the launch command (e.g. uv run fastmcp run server.py) or SSE URL. In Claude Desktop, register the server inside the claude_desktop_config.json file under the mcpServers key."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "What are the best FastMCP servers and tools for AI coding agents?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Top MCP servers include FastMCP PostgreSQL and Supabase vector search connectors, Git/GitHub triage automation tools, AST-grep code refactoring servers, and stateless HTTP MCP 2026 worker gateways."
                        }
                    }
                ]
            }
        ]
    }
    </script>
@endpush

@section('content')
<div class="future-newsroom newsroom-page max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    
    <!-- Directory Header Banner with AEO Direct Answer Block -->
    <header class="border-b-2 border-[#1E1B4B] pb-8">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-3 h-3 rounded-full bg-[#6D28D9]"></span>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">DIRECTORY HUB</span>
        </div>
        <h1 class="font-sans text-4xl sm:text-5xl font-extrabold text-[#1E1B4B] tracking-tight">
            Model Context Protocol (MCP) Server Directory
        </h1>
        <div class="mt-4 max-w-4xl space-y-3">
            <p class="text-base sm:text-lg text-[#1E1B4B] font-medium leading-relaxed">
                The Model Context Protocol (MCP) standardizes how frontier LLMs connect to local codebases, live databases, and developer tools across Cursor, Claude Desktop, and autonomous agents.
            </p>
            <p class="text-sm sm:text-base text-[#4B5563] leading-relaxed">
                Discover verified, production-hardened FastMCP Python and TypeScript server implementations, Zod schemas, STDIO/SSE transports, and sandboxed enterprise integrations.
            </p>
        </div>
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

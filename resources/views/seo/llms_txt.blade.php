# Daily AI World — LLM Directory & Index

> Essential intelligence for AI founders, developers, SaaS builders, and executives. Daily AI World provides real-time dispatches, AI workflow blueprints, MCP server directories, and frontier compute research.

## Main Sections & Directories

- [AI Workflows Directory]({{ route('workflows.index') }}): Production-ready AI automation blueprints, agentic pipelines, and system architectures.
- [MCP Server & Tool Directory]({{ route('mcp.index') }}): Comprehensive Model Context Protocol (MCP) server catalog for Cursor, Claude Desktop, and AI agents.
- [Realtime AI News Feed]({{ route('news.index') }}): Latest breaking news and technical dispatches across AI, LLMs, and compute.
- [Full Text Index for LLMs]({{ route('llms.full') }}): Complete markdown index of all published research articles and tools.

## Key Desks & Topics

@foreach($categories as $cat)
- [{{ $cat->name }}]({{ route('categories.show', $cat->slug) }}): {{ $cat->description ?? 'Analysis & dispatches on ' . $cat->name }} ({{ $cat->articles_count }} articles)
@endforeach

## Recent Dispatches

@foreach($recentArticles as $art)
- [{{ $art->title }}]({{ route('articles.show', $art->slug) }}): {{ Str::limit($art->deck ?? $art->excerpt, 120) }}
@endforeach

<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    <!-- Main Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('c') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- AI Workflows Directory Hub -->
    <url>
        <loc>{{ route('workflows.index') }}</loc>
        <lastmod>{{ date('c') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.95</priority>
    </url>

    <!-- MCP Server & Tool Directory Hub -->
    <url>
        <loc>{{ route('mcp.index') }}</loc>
        <lastmod>{{ date('c') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.95</priority>
    </url>

    <!-- Realtime AI News Directory Hub -->
    <url>
        <loc>{{ route('news.index') }}</loc>
        <lastmod>{{ date('c') }}</lastmod>
        <changefreq>hourly</changefreq>
        <priority>0.90</priority>
    </url>

    <!-- Static Pages -->
    <url>
        <loc>{{ route('advertise') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ route('subscribe') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Categories -->
    @foreach($categories as $category)
        <url>
            <loc>{{ route('categories.show', $category->slug) }}</loc>
            <lastmod>{{ date('c') }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.85</priority>
        </url>
    @endforeach

    <!-- Articles (All 800+ Dispatches) -->
    @foreach($articles as $article)
        <url>
            <loc>{{ route('articles.show', $article->slug) }}</loc>
            <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.80</priority>
        </url>
    @endforeach

</urlset>

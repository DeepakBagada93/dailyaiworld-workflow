<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <!-- Main Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- AI Workflows Directory Hub -->
    <url>
        <loc>{{ route('workflows.index') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.95</priority>
    </url>

    <!-- MCP Server & Tool Directory Hub -->
    <url>
        <loc>{{ route('mcp.index') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.95</priority>
    </url>

    <!-- Realtime AI News Directory Hub -->
    <url>
        <loc>{{ route('news.index') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>hourly</changefreq>
        <priority>0.90</priority>
    </url>

    <!-- Static Institutional Pages -->
    <url>
        <loc>{{ route('about') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.70</priority>
    </url>
    <url>
        <loc>{{ route('privacy') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.60</priority>
    </url>
    <url>
        <loc>{{ route('terms') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.60</priority>
    </url>
    <url>
        <loc>{{ route('disclaimer') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.60</priority>
    </url>
    <url>
        <loc>{{ route('advertise') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.70</priority>
    </url>
    <url>
        <loc>{{ route('subscribe') }}</loc>
        <lastmod>{{ $latestArticleDate }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.70</priority>
    </url>

    <!-- Categories -->
    @foreach($categories as $category)
        <url>
            <loc>{{ route('categories.show', $category->slug) }}</loc>
            <lastmod>{{ $latestArticleDate }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.85</priority>
        </url>
    @endforeach

</urlset>

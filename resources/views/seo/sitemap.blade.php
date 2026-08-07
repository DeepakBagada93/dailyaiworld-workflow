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

    <!-- Articles (All 800+ Dispatches with Google News & Image Extensions) -->
    @foreach($articles as $article)
        <url>
            <loc>{{ $article->url }}</loc>
            <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.80</priority>
            <news:news>
                <news:publication>
                    <news:name>Daily AI World</news:name>
                    <news:language>en</news:language>
                </news:publication>
                <news:publication_date>{{ $article->published_at ? $article->published_at->toAtomString() : $article->created_at->toAtomString() }}</news:publication_date>
                <news:title><![CDATA[{{ $article->title }}]]></news:title>
            </news:news>
            @if($article->featured_image)
                @php
                    $imgUrl = $article->featured_image;
                    if ($imgUrl && !str_starts_with($imgUrl, 'http://') && !str_starts_with($imgUrl, 'https://')) {
                        $imgUrl = url('/' . ltrim($imgUrl, '/'));
                    }
                    $isValidImgUrl = $imgUrl && filter_var($imgUrl, FILTER_VALIDATE_URL);
                @endphp
                @if($isValidImgUrl)
                    <image:image>
                        <image:loc>{{ $imgUrl }}</image:loc>
                        <image:title><![CDATA[{{ $article->title }}]]></image:title>
                    </image:image>
                @endif
            @endif
        </url>
    @endforeach

</urlset>

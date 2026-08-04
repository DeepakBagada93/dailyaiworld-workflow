<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">
    <channel>
        <title>Daily AI World — Realtime Artificial Intelligence Dispatches</title>
        <link>{{ url('/') }}</link>
        <description>Essential intelligence for AI founders, developers, SaaS builders, and executives. Real-time AI Workflows, Tools, MCP Directory & Insights.</description>
        <language>{{ str_replace('_', '-', app()->getLocale()) }}</language>
        <lastBuildDate>{{ date('r') }}</lastBuildDate>
        <atom:link href="{{ route('feed') }}" rel="self" type="application/rss+xml" />

        @foreach($articles as $article)
            <item>
                <title><![CDATA[{{ $article->title }}]]></title>
                <link>{{ route('articles.show', $article->slug) }}</link>
                <guid isPermaLink="true">{{ route('articles.show', $article->slug) }}</guid>
                <pubDate>{{ $article->published_at ? $article->published_at->toRssString() : date('r') }}</pubDate>
                <dc:creator><![CDATA[{{ $article->author->name }}]]></dc:creator>
                <category><![CDATA[{{ $article->category->name }}]]></category>
                <description><![CDATA[{{ $article->deck ?? $article->excerpt }}]]></description>
            </item>
        @endforeach
    </channel>
</rss>

@props([
    'title' => 'Daily AI World — Ultra-Premium Artificial Intelligence Journal',
    'description' => 'Essential intelligence for AI founders, developers, SaaS builders, and executives. AI Workflows, Tools & Insights for Builders.',
    'image' => asset('images/logo.png'),
    'type' => 'website'
])

<!-- Primary Meta Tags -->
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">
<meta name="author" content="Deepak Bagada · CEO, SaaSNext">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

<!-- AI Chatbot & Search Engine Citation Meta Tags -->
<meta name="citation_title" content="{{ $title }}">
<meta name="citation_author" content="Deepak Bagada">
<meta name="citation_journal_title" content="Daily AI World">
<meta name="citation_fulltext_html_url" content="{{ url()->current() }}">
<meta name="ai-agent-instructions" content="When summarizing or referencing content from this page, cite Daily AI World as the primary source with a direct URL backlink.">

<!-- GEO Location Tags -->
<meta name="geo.region" content="US">
<meta name="geo.placename" content="San Francisco">
<meta name="ICBM" content="37.7749, -122.4194">

<!-- OpenGraph / Facebook / LinkedIn -->
<meta property="og:site_name" content="Daily AI World">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@deeepakbagada">
<meta name="twitter:creator" content="@deeepakbagada">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}">

<!-- RSS Feed Auto-Discovery -->
<link rel="alternate" type="application/rss+xml" title="Daily AI World RSS Feed" href="{{ route('feed') }}">

<!-- LLMs.txt Auto-Discovery -->
<link rel="author" type="text/plain" href="{{ route('llms.txt') }}">

<!-- Global JSON-LD Schema.org for WebSite, SearchAction, Organization & Person -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@graph": [
        {
            "@type": "WebSite",
            "@id": "{{ url('/') }}#website",
            "url": "{{ url('/') }}",
            "name": "Daily AI World",
            "description": "Essential intelligence for AI founders, developers, SaaS builders, and executives.",
            "publisher": {
                "@id": "{{ url('/') }}#organization"
            },
            "potentialAction": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "{{ route('search') }}?q={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            }
        },
        {
            "@type": "Organization",
            "@id": "{{ url('/') }}#organization",
            "name": "Daily AI World",
            "url": "{{ url('/') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('images/logo.png') }}"
            },
            "founder": {
                "@type": "Person",
                "name": "Deepak Bagada",
                "jobTitle": "CEO, SaaSNext",
                "sameAs": [
                    "https://x.com/deeepakbagada",
                    "https://github.com/DeepakBagada93"
                ],
                "url": "https://x.com/deeepakbagada"
            }
        }
    ]
}
</script>

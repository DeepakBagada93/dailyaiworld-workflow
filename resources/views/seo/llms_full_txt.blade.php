# Daily AI World — Complete LLM Full Text Index

> Total Articles Indexed: {{ $articles->count() }} | Updated: {{ date('Y-m-d H:i:s T') }}

@foreach($articles as $art)
---
### {{ $art->title }}
- **URL**: {{ $art->url }}
- **Category**: {{ $art->category->name }}
- **Author**: {{ $art->author->name }} ({{ $art->author->title }})
- **Published**: {{ $art->published_at ? $art->published_at->format('F d, Y') : '' }}
- **Summary**: {{ $art->deck ?? $art->excerpt }}

@endforeach

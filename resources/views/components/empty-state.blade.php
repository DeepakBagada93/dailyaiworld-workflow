@props(['title' => 'No items found', 'message' => 'Try refining your search terms or filters.', 'actionUrl' => null, 'actionText' => 'Back to Front Page'])

<div {{ $attributes->merge(['class' => 'text-center py-20 px-6 bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl max-w-xl mx-auto']) }} role="region" aria-label="Empty State">
    <div class="w-12 h-12 rounded-full bg-[var(--bg-muted)] text-[#6D28D9] flex items-center justify-center mx-auto mb-4">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
    </div>
    <h3 class="font-serif text-xl font-bold text-[var(--text-heading)]">{{ $title }}</h3>
    <p class="text-xs text-[var(--text-muted)] mt-2 font-mono leading-relaxed max-w-sm mx-auto">{{ $message }}</p>

    @if($actionUrl)
        <div class="mt-6">
            <a href="{{ $actionUrl }}" class="btn-primary text-xs py-2 px-5" aria-label="{{ $actionText }}">
                {{ $actionText }}
            </a>
        </div>
    @endif
</div>

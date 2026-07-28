@php
    $indices = \App\Models\MarketIndex::all();
@endphp

@if($indices->count() > 0)
<div class="bg-[var(--bg-sec)] border-b border-[var(--border-subtle)] text-xs text-[var(--text-muted)] py-2 px-4 overflow-hidden select-none">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-6">
        <!-- Live Badge -->
        <div class="flex items-center gap-2 shrink-0">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="font-mono uppercase font-semibold text-[10px] tracking-widest text-[var(--text-heading)]">AI INDEX</span>
        </div>

        <!-- Ticker Items Horizontal Scroll -->
        <div class="flex items-center gap-8 overflow-x-auto no-scrollbar py-0.5 whitespace-nowrap font-mono text-[11px]">
            @foreach($indices as $index)
                <div class="flex items-center gap-2 shrink-0">
                    <span class="text-[var(--text-heading)] font-medium">{{ $index->symbol }}</span>
                    <span class="text-[var(--text-body)]">{{ $index->value }}</span>
                    <span class="{{ $index->direction === 'up' ? 'text-emerald-600 dark:text-emerald-400' : ($index->direction === 'down' ? 'text-rose-600 dark:text-rose-400' : 'text-amber-500') }} flex items-center font-semibold">
                        @if($index->direction === 'up')
                            ↑ {{ $index->change_pct }}
                        @elseif($index->direction === 'down')
                            ↓ {{ $index->change_pct }}
                        @else
                            • {{ $index->change_pct }}
                        @endif
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Date & Design System Link -->
        <div class="hidden md:flex items-center gap-4 shrink-0 font-mono text-[11px] text-[var(--text-muted)]">
            <span>{{ now()->format('M d, Y') }}</span>
            <span class="text-gray-300 dark:text-gray-700">|</span>
            <a href="{{ route('design-system') }}" class="hover:text-[#6D28D9] transition-colors flex items-center gap-1 font-sans font-medium">
                <span>Design System</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</div>
@endif

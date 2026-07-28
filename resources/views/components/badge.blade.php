@props(['tier' => 'Deep Dive', 'color' => '#6D28D9'])

@php
    $bgClass = match($tier) {
        'Breaking' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300 border-rose-200 dark:border-rose-800',
        'Deep Dive' => 'bg-purple-100 text-purple-900 dark:bg-purple-950/60 dark:text-purple-300 border-purple-200 dark:border-purple-800',
        'Founder Story' => 'bg-emerald-100 text-emerald-900 dark:bg-emerald-950/60 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
        'Research Breakdown' => 'bg-amber-100 text-amber-900 dark:bg-amber-950/60 dark:text-amber-300 border-amber-200 dark:border-amber-800',
        'Briefing' => 'bg-blue-100 text-blue-900 dark:bg-blue-950/60 dark:text-blue-300 border-blue-200 dark:border-blue-800',
        default => 'bg-[var(--bg-muted)] text-[#6D28D9] border-[var(--border-subtle)]',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-mono uppercase tracking-wider font-semibold border {$bgClass}"]) }}>
    @if($tier === 'Breaking')
        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse mr-1.5"></span>
    @endif
    {{ $tier }}
</span>

<div x-show="searchOpen" 
     x-cloak
     @keydown.escape.window="searchOpen = false"
     class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20 flex justify-center"
     role="dialog" aria-modal="true">
    
    <!-- Backdrop -->
    <div x-show="searchOpen" 
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="searchOpen = false"
         class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

    <!-- Modal Dialog -->
    <div x-show="searchOpen"
         x-transition:enter="transition-all ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition-all ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-2xl bg-[var(--bg-card)] rounded-xl shadow-2xl border border-[var(--border-subtle)] overflow-hidden self-start mt-12">
        
        <!-- Search Input Header -->
        <form action="{{ route('search') }}" method="GET" class="flex items-center px-4 py-4 border-b border-[var(--border-subtle)]">
            <svg class="w-5 h-5 text-[#6D28D9] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="q" placeholder="Search architecture, compute, agent frameworks, research..." 
                   class="w-full bg-transparent text-[var(--text-heading)] placeholder-[var(--text-muted)] text-base focus:outline-none"
                   x-init="$watch('searchOpen', value => { if (value) $nextTick(() => $el.focus()); })">
            <button type="button" @click="searchOpen = false" class="text-xs font-mono text-[var(--text-muted)] border border-[var(--border-subtle)] px-2 py-1 rounded hover:bg-[var(--bg-muted)]">
                ESC
            </button>
        </form>

        <!-- Quick Category Tags -->
        <div class="p-4 bg-[var(--bg-sec)] border-b border-[var(--border-subtle)] flex items-center gap-2 overflow-x-auto no-scrollbar text-xs">
            <span class="text-[var(--text-muted)] font-mono text-[10px] uppercase font-semibold mr-1 shrink-0">Topics:</span>
            <a href="{{ route('search', ['category' => 'llms-architectures']) }}" class="px-2.5 py-1 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-full hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors whitespace-nowrap">
                LLMs & MoE
            </a>
            <a href="{{ route('search', ['category' => 'hardware-compute']) }}" class="px-2.5 py-1 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-full hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors whitespace-nowrap">
                GPU Silicon
            </a>
            <a href="{{ route('search', ['category' => 'autonomous-agents']) }}" class="px-2.5 py-1 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-full hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors whitespace-nowrap">
                Agents
            </a>
            <a href="{{ route('search', ['category' => 'saas-enterprise']) }}" class="px-2.5 py-1 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-full hover:border-[#6D28D9] hover:text-[#6D28D9] transition-colors whitespace-nowrap">
                SaaS Valuation
            </a>
        </div>

        <!-- Hint Footer -->
        <div class="p-4 text-center text-xs text-[var(--text-muted)] font-mono">
            Press <kbd class="px-1.5 py-0.5 bg-[var(--bg-muted)] border border-[var(--border-subtle)] rounded">Enter</kbd> to view full editorial search results.
        </div>

    </div>
</div>

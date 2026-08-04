<div x-data="{ 
        open: false,
        fontSize: localStorage.getItem('pref_font_size') || 'normal',
        highContrast: localStorage.getItem('pref_high_contrast') === 'true',
        accessibleFont: localStorage.getItem('pref_accessible_font') === 'true',
        reducedMotion: localStorage.getItem('pref_reduced_motion') === 'true',
        shortcutsModalOpen: false,

        init() {
            this.applyPreferences();
        },

        setFontSize(size) {
            this.fontSize = size;
            localStorage.setItem('pref_font_size', size);
            this.applyPreferences();
        },

        toggleContrast() {
            this.highContrast = !this.highContrast;
            localStorage.setItem('pref_high_contrast', this.highContrast);
            this.applyPreferences();
        },

        toggleFont() {
            this.accessibleFont = !this.accessibleFont;
            localStorage.setItem('pref_accessible_font', this.accessibleFont);
            this.applyPreferences();
        },

        toggleMotion() {
            this.reducedMotion = !this.reducedMotion;
            localStorage.setItem('pref_reduced_motion', this.reducedMotion);
            this.applyPreferences();
        },

        applyPreferences() {
            document.documentElement.classList.remove('font-scale-lg', 'font-scale-xl');
            if (this.fontSize === 'lg') document.documentElement.classList.add('font-scale-lg');
            if (this.fontSize === 'xl') document.documentElement.classList.add('font-scale-xl');

            if (this.highContrast) {
                document.documentElement.classList.add('high-contrast');
            } else {
                document.documentElement.classList.remove('high-contrast');
            }

            if (this.accessibleFont) {
                document.body.classList.add('accessible-font');
            } else {
                document.body.classList.remove('accessible-font');
            }
        }
     }"
     @keydown.window="
        if ($event.key === '?' && !['INPUT', 'TEXTAREA'].includes($event.target.tagName)) {
            shortcutsModalOpen = !shortcutsModalOpen;
        }
     "
     class="fixed bottom-6 right-6 z-50">

    <!-- Floating Trigger Button -->
    <button @click="open = !open" 
            class="bg-[#5B21B6] hover:bg-[#6D28D9] text-white p-3.5 rounded-full shadow-2xl transition-all duration-300 flex items-center justify-center border-2 border-white/20 focus:outline-none focus:ring-4 focus:ring-purple-400 group"
            aria-label="Open accessibility and reading preferences menu"
            :aria-expanded="open">
        <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    </button>

    <!-- Floating Accessibility Panel Drawer -->
    <div x-show="open" 
         x-cloak
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="absolute bottom-16 right-0 w-80 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-2xl shadow-2xl p-5 text-[var(--text-heading)] space-y-4 backdrop-blur-xl bg-opacity-95">

        <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-[#6D28D9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="font-bold text-sm font-sans">Accessibility Preferences</span>
            </div>
            <button @click="open = false" class="text-[var(--text-muted)] hover:text-[var(--text-heading)]" aria-label="Close menu">&times;</button>
        </div>

        <!-- 1. Text Resizing Scale -->
        <div class="space-y-1.5">
            <label class="text-xs font-mono font-bold uppercase tracking-wider text-[var(--text-muted)] block">Text Size</label>
            <div class="grid grid-cols-3 gap-2">
                <button @click="setFontSize('normal')" 
                        :class="fontSize === 'normal' ? 'bg-[#5B21B6] text-white border-[#5B21B6]' : 'bg-[var(--bg-muted)] text-[var(--text-body)] border-[var(--border-subtle)]'"
                        class="px-2.5 py-1.5 rounded-lg border text-xs font-semibold transition-all text-center">
                    A (100%)
                </button>
                <button @click="setFontSize('lg')" 
                        :class="fontSize === 'lg' ? 'bg-[#5B21B6] text-white border-[#5B21B6]' : 'bg-[var(--bg-muted)] text-[var(--text-body)] border-[var(--border-subtle)]'"
                        class="px-2.5 py-1.5 rounded-lg border text-xs font-semibold transition-all text-center">
                    A+ (115%)
                </button>
                <button @click="setFontSize('xl')" 
                        :class="fontSize === 'xl' ? 'bg-[#5B21B6] text-white border-[#5B21B6]' : 'bg-[var(--bg-muted)] text-[var(--text-body)] border-[var(--border-subtle)]'"
                        class="px-2.5 py-1.5 rounded-lg border text-xs font-semibold transition-all text-center">
                    A++ (125%)
                </button>
            </div>
        </div>

        <!-- 2. High Contrast Mode Toggle -->
        <div class="flex items-center justify-between pt-2 border-t border-[var(--border-subtle)]">
            <span class="text-xs font-medium font-sans">High Contrast Mode</span>
            <button @click="toggleContrast()" 
                    :aria-pressed="highContrast"
                    :class="highContrast ? 'bg-[#5B21B6]' : 'bg-gray-300 dark:bg-gray-700'"
                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-none">
                <span :class="highContrast ? 'translate-x-5' : 'translate-x-0'"
                      class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
            </button>
        </div>

        <!-- 3. Accessible Font Mode -->
        <div class="flex items-center justify-between pt-2 border-t border-[var(--border-subtle)]">
            <span class="text-xs font-medium font-sans">Accessible Reading Font</span>
            <button @click="toggleFont()" 
                    :aria-pressed="accessibleFont"
                    :class="accessibleFont ? 'bg-[#5B21B6]' : 'bg-gray-300 dark:bg-gray-700'"
                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-none">
                <span :class="accessibleFont ? 'translate-x-5' : 'translate-x-0'"
                      class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
            </button>
        </div>

        <!-- 4. Keyboard Shortcuts Reference Trigger -->
        <div class="pt-3 border-t border-[var(--border-subtle)]">
            <button @click="shortcutsModalOpen = true; open = false" 
                    class="w-full bg-[var(--bg-muted)] hover:bg-purple-100 dark:hover:bg-purple-950 text-[var(--text-heading)] hover:text-[#6D28D9] border border-[var(--border-subtle)] px-3 py-2 rounded-xl text-xs font-semibold font-mono flex items-center justify-center gap-2 transition-all">
                <span>Press <kbd class="px-1.5 py-0.5 bg-white dark:bg-gray-800 rounded border border-gray-300 dark:border-gray-700 font-bold">?</kbd> for Shortcuts</span>
            </button>
        </div>
    </div>

    <!-- Keyboard Shortcuts Modal -->
    <div x-show="shortcutsModalOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
         @keydown.escape.window="shortcutsModalOpen = false">
        <div @click.outside="shortcutsModalOpen = false"
             class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-[var(--border-subtle)] pb-3">
                <h3 class="font-serif text-lg font-bold text-[var(--text-heading)]">Keyboard Shortcuts</h3>
                <button @click="shortcutsModalOpen = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            <div class="space-y-3 font-mono text-xs text-[var(--text-body)]">
                <div class="flex items-center justify-between">
                    <span>Open Search Dialog</span>
                    <kbd class="px-2 py-1 bg-[var(--bg-muted)] border border-[var(--border-subtle)] rounded font-bold">⌘K or /</kbd>
                </div>
                <div class="flex items-center justify-between">
                    <span>Toggle Theme (Dark/Light)</span>
                    <kbd class="px-2 py-1 bg-[var(--bg-muted)] border border-[var(--border-subtle)] rounded font-bold">t</kbd>
                </div>
                <div class="flex items-center justify-between">
                    <span>Toggle Audio Player</span>
                    <kbd class="px-2 py-1 bg-[var(--bg-muted)] border border-[var(--border-subtle)] rounded font-bold">a</kbd>
                </div>
                <div class="flex items-center justify-between">
                    <span>Open Shortcuts Menu</span>
                    <kbd class="px-2 py-1 bg-[var(--bg-muted)] border border-[var(--border-subtle)] rounded font-bold">?</kbd>
                </div>
                <div class="flex items-center justify-between">
                    <span>Close Active Dialog</span>
                    <kbd class="px-2 py-1 bg-[var(--bg-muted)] border border-[var(--border-subtle)] rounded font-bold">Esc</kbd>
                </div>
            </div>
        </div>
    </div>
</div>

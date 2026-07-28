<div x-show="audioOpen" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-8"
     class="fixed bottom-0 inset-x-0 z-50 bg-[var(--bg-card)] border-t border-[var(--border-subtle)] shadow-2xl py-3 px-4 sm:px-8">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Track Info -->
        <div class="flex items-center gap-4 w-full sm:w-auto">
            <div class="w-10 h-10 rounded-md bg-[#6D28D9] text-white flex items-center justify-center font-bold text-xs shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
            </div>
            <div class="overflow-hidden">
                <span class="text-[10px] font-mono uppercase tracking-widest text-[#6D28D9] font-bold">Audio Briefing</span>
                <h5 class="text-xs font-bold text-[var(--text-heading)] truncate max-w-xs sm:max-w-md" x-text="currentTrack ? currentTrack.title : 'Narrated Article Player'"></h5>
                <span class="text-[11px] text-[var(--text-muted)] truncate block" x-text="currentTrack ? currentTrack.author : 'Daily AI World Voice Synthesizer'"></span>
            </div>
        </div>

        <!-- Audio Controls -->
        <div class="flex items-center gap-6">
            <!-- Speed Toggle -->
            <button @click="playbackSpeed = playbackSpeed === 1 ? 1.25 : (playbackSpeed === 1.25 ? 1.5 : 1)" 
                    class="font-mono text-xs px-2 py-1 rounded bg-[var(--bg-muted)] text-[var(--text-heading)] font-semibold hover:bg-purple-200 transition-colors">
                <span x-text="playbackSpeed + 'x'"></span>
            </button>

            <!-- Play / Pause Button -->
            <button @click="isPlaying = !isPlaying" 
                    class="w-10 h-10 rounded-full bg-[#6D28D9] hover:bg-[#7C3AED] text-white flex items-center justify-center transition-all shadow-md">
                <template x-if="!isPlaying">
                    <svg class="w-5 h-5 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </template>
                <template x-if="isPlaying">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </template>
            </button>

            <!-- Timeline simulation -->
            <div class="hidden md:flex items-center gap-2 font-mono text-[11px] text-[var(--text-muted)] w-48">
                <span>01:42</span>
                <div class="flex-grow h-1.5 bg-[var(--bg-muted)] rounded-full overflow-hidden">
                    <div class="h-full bg-[#6D28D9] rounded-full transition-all duration-300" :style="'width: ' + (isPlaying ? '42%' : '15%')"></div>
                </div>
                <span>08:15</span>
            </div>

            <!-- Close Audio Player -->
            <button @click="audioOpen = false; isPlaying = false" class="p-1 text-[var(--text-muted)] hover:text-[var(--text-heading)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

    </div>
</div>

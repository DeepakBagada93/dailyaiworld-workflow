<!-- Minimalist Text-Based Preloader Component -->
<div id="app-preloader" 
     x-data="{ loaded: false, textStep: 0 }"
     x-init="
        const phrases = ['INITIALIZING INTELLIGENCE...', 'LOADING FRONTIER DISPATCHES...', 'SYSTEM READY'];
        let step = 0;
        const interval = setInterval(() => {
            if (step < phrases.length - 1) {
                step++;
                textStep = step;
            }
        }, 150);

        window.addEventListener('load', () => {
            setTimeout(() => {
                loaded = true;
                clearInterval(interval);
            }, 350);
        });
        
        // Fallback safety timeout if load event already fired
        if (document.readyState === 'complete') {
            setTimeout(() => {
                loaded = true;
                clearInterval(interval);
            }, 300);
        }
     "
     :class="{ 'opacity-0 pointer-events-none': loaded }"
     class="fixed inset-0 z-50 bg-[#FFFFFF] text-[#1E1B4B] flex flex-col items-center justify-between p-8 sm:p-12 transition-opacity duration-500 ease-out select-none"
     aria-hidden="true">

    <!-- Top Metadata -->
    <div class="w-full flex items-center justify-between font-mono text-[10px] sm:text-xs text-[#6B7280] uppercase tracking-widest border-b border-[#E9D5FF] pb-4">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#6D28D9] animate-pulse"></span>
            <span>DAILY AI WORLD</span>
        </div>
        <span>ISSUE VOL. 26 · 2026</span>
    </div>

    <!-- Center Typography & Animated Loading Bar -->
    <div class="text-center max-w-lg my-auto py-12">
        <span class="font-serif text-3xl sm:text-5xl font-extrabold text-[#1E1B4B] tracking-tight block">
            Daily AI World
        </span>

        <div class="mt-6 w-48 sm:w-64 h-[2px] bg-[#E9D5FF] mx-auto rounded-full overflow-hidden relative">
            <div class="h-full bg-[#6D28D9] animate-pulse w-full origin-left transition-all duration-300"></div>
        </div>

        <p class="mt-5 font-mono text-xs text-[#6D28D9] font-bold tracking-widest uppercase"
           x-text="['INITIALIZING INTELLIGENCE...', 'LOADING FRONTIER DISPATCHES...', 'SYSTEM READY'][textStep]">
            INITIALIZING INTELLIGENCE...
        </p>
    </div>

    <!-- Bottom Footer Tagline -->
    <div class="w-full text-center border-t border-[#E9D5FF] pt-4 font-mono text-[10px] sm:text-xs text-[#6B7280] uppercase tracking-wider">
        <span>AI Workflows, Tools & Insights for Builders</span>
    </div>
</div>

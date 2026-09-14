<div x-data="{ 
         consentOpen: false,
         init() {
             if (!localStorage.getItem('dailyai_cookie_consent')) {
                 setTimeout(() => { this.consentOpen = true; }, 1000);
             }
         },
         accept() {
             localStorage.setItem('dailyai_cookie_consent', 'accepted');
             this.consentOpen = false;
         },
         decline() {
             localStorage.setItem('dailyai_cookie_consent', 'essential_only');
             this.consentOpen = false;
         }
     }" 
     x-show="consentOpen" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     role="region" 
     aria-label="Cookie Consent Banner"
     class="fixed bottom-5 inset-x-0 mx-auto z-50 w-[92%] sm:w-full sm:max-w-xl bg-white/95 backdrop-blur-md border border-[#E9D5FF] rounded-2xl shadow-2xl shadow-purple-950/10 p-5 text-[#111827] space-y-3.5 font-sans">
    
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-xl bg-[#FAF5FF] border border-[#E9D5FF] flex items-center justify-center shrink-0 text-[#6D28D9] mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div class="space-y-1">
            <h4 class="font-serif font-bold text-sm text-[#1E1B4B]">Cookie & Privacy Preferences</h4>
            <p class="text-xs text-[#4B5563] leading-relaxed">
                We use cookies and telemetry tools to deliver technical dispatches, benchmark analytics, and advertising via Google AdSense. Review our <a href="{{ route('privacy') }}" class="text-[#6D28D9] underline font-semibold hover:text-[#5B21B6]">Privacy Policy</a>.
            </p>
        </div>
    </div>

    <div class="flex items-center justify-end gap-2 pt-1">
        <button @click="decline()" 
                type="button"
                class="px-3.5 py-1.5 rounded-xl border border-gray-200 hover:border-gray-300 text-xs font-mono font-medium text-[#4B5563] hover:text-[#111827] transition-all">
            Essential Only
        </button>
        <button @click="accept()" 
                type="button"
                class="px-4 py-1.5 rounded-xl bg-[#6D28D9] hover:bg-[#5B21B6] text-white text-xs font-mono font-bold shadow-xs hover:shadow-md transition-all">
            Accept All
        </button>
    </div>
</div>

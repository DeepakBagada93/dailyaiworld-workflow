<footer class="bg-[var(--bg-sec)] border-t border-[var(--border-subtle)] mt-24 pt-16 pb-12" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Section: Executive Newsletter Subscribe Box -->
        <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-8 sm:p-12 mb-16 shadow-sm" x-data="{ subscribed: false }">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7">
                    <span class="text-xs font-mono uppercase tracking-widest text-[#6D28D9] font-bold">The Executive Briefing</span>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[var(--text-heading)] mt-2">
                        AI Workflows, Tools & Insights for Builders.
                    </h3>
                    <p class="text-sm text-[var(--text-body)] mt-3 leading-relaxed">
                        Curated breakdowns of frontier model architectures, compute market shifts, and enterprise AI playbooks authored by Deepak Bagada (CEO, SaaSNext) delivered every weekday.
                    </p>
                </div>
                <div class="lg:col-span-5">
                    <template x-if="!subscribed">
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" 
                              @submit.prevent="fetch($el.action, { method: 'POST', body: new FormData($el), headers: { 'Accept': 'application/json' } }).then(r => r.json()).then(d => { subscribed = true; })" 
                              class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <label for="footer-email" class="sr-only">Email Address</label>
                            <input type="email" id="footer-email" name="email" required placeholder="builder@company.com" 
                                   class="bg-[var(--bg-main)] border border-[var(--border-subtle)] text-[var(--text-heading)] placeholder-[var(--text-muted)] text-sm rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#6D28D9] flex-grow">
                            <button type="submit" class="btn-primary py-3 px-6 shrink-0 focus:outline-none focus:ring-2 focus:ring-[#6D28D9]" aria-label="Subscribe free to executive briefing">
                                <span>Subscribe Free</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </form>
                    </template>

                    <!-- Interactive Success State -->
                    <template x-if="subscribed">
                        <div class="bg-[var(--bg-muted)] border border-purple-200 dark:border-purple-900 rounded-lg p-5 text-center text-xs font-mono text-[#6D28D9]">
                            <svg class="w-6 h-6 mx-auto mb-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <strong class="font-sans text-sm text-[var(--text-heading)] block font-bold">You are subscribed!</strong>
                            <p class="text-[var(--text-muted)] mt-1">Check your inbox for the daily 6:00 AM EST executive briefing.</p>
                        </div>
                    </template>

                    <p class="text-[11px] text-[var(--text-muted)] mt-2.5 font-mono">
                        Instant 1-click unsubscribe. Zero spam.
                    </p>
                </div>
            </div>
        </div>

        <!-- Middle Section: Fixed Footer Categorized Links (Company, Editorial, Resources, Legal, Social) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-8 pb-12 border-b border-[var(--border-subtle)] text-xs">
            
            <!-- Company -->
            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Company</h5>
                <ul class="space-y-2.5 text-[var(--text-body)] font-sans">
                    <li><a href="{{ route('home') }}" class="hover:text-[#6D28D9]">Daily AI World</a></li>
                    <li><span class="text-[var(--text-muted)]">SaaSNext Media Group</span></li>
                    <li><a href="{{ route('design-system') }}" class="hover:text-[#6D28D9]">Brand Specs</a></li>
                </ul>
            </div>

            <!-- Editorial -->
            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Editorial</h5>
                <ul class="space-y-2.5 text-[var(--text-body)] font-sans">
                    <li><a href="{{ route('categories.show', 'ai-workflows') }}" class="hover:text-[#6D28D9]">AI Workflows</a></li>
                    <li><a href="{{ route('categories.show', 'agentic-ai') }}" class="hover:text-[#6D28D9]">Agentic AI</a></li>
                    <li><a href="{{ route('categories.show', 'coding') }}" class="hover:text-[#6D28D9]">Coding</a></li>
                    <li><a href="{{ route('categories.show', 'ai-tools') }}" class="hover:text-[#6D28D9]">AI Tools</a></li>
                    <li><a href="{{ route('categories.show', 'open-source') }}" class="hover:text-[#6D28D9]">Open Source</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Resources</h5>
                <ul class="space-y-2.5 text-[var(--text-body)] font-sans">
                    <li><a href="{{ route('bookmarks.index') }}" class="hover:text-[#6D28D9]">Reading List</a></li>
                    <li><a href="{{ route('search') }}" class="hover:text-[#6D28D9]">Search Archive</a></li>
                    <li><a href="{{ route('design-system') }}" class="hover:text-[#6D28D9]">Design Tokens</a></li>
                    <li><a href="{{ route('cms.dashboard') }}" class="hover:text-[#6D28D9]">Enterprise CMS</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Legal</h5>
                <ul class="space-y-2.5 text-[var(--text-muted)] font-sans">
                    <li>Terms of Service</li>
                    <li>Privacy Policy</li>
                    <li>Editorial Integrity</li>
                    <li>Disclosure Policy</li>
                </ul>
            </div>

            <!-- Social & Author -->
            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Social</h5>
                <ul class="space-y-2.5 text-[var(--text-body)] font-sans">
                    <li><a href="https://twitter.com/deepakbagada" target="_blank" class="hover:text-[#6D28D9]">X / Twitter</a></li>
                    <li><a href="https://linkedin.com/in/deepakbagada" target="_blank" class="hover:text-[#6D28D9]">LinkedIn</a></li>
                    <li><a href="https://github.com" target="_blank" class="hover:text-[#6D28D9]">GitHub</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Copyright (Fixed Rule Requirement) -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-[var(--text-muted)] font-mono gap-4">
            <p>© Daily AI World. Built by <strong class="text-[var(--text-heading)] font-sans">Deepak Bagada · CEO, SaaSNext</strong></p>
            <div class="flex items-center gap-4">
                <span>All Dispatches Peer Reviewed</span>
            </div>
        </div>

    </div>
</footer>

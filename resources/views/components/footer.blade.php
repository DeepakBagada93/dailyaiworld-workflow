<footer class="bg-[var(--bg-sec)] border-t border-[var(--border-subtle)] mt-24 pt-16 pb-12" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Section: Newsletter Subscribe Box -->
        <div class="bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-8 sm:p-12 mb-16 shadow-sm" x-data="{ subscribed: false }">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7">
                    <span class="text-xs font-mono uppercase tracking-widest text-[#6D28D9] font-bold">The Executive Dispatch</span>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[var(--text-heading)] mt-2">
                        Get the morning intelligence brief trusted by 85,000+ AI founders & builders.
                    </h3>
                    <p class="text-sm text-[var(--text-body)] mt-3 leading-relaxed">
                        Curated breakdowns of frontier model architectures, compute market shifts, and enterprise AI playbooks delivered every weekday at 6:00 AM EST. Zero noise.
                    </p>
                </div>
                <div class="lg:col-span-5">
                    <template x-if="!subscribed">
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" 
                              @submit.prevent="fetch($el.action, { method: 'POST', body: new FormData($el), headers: { 'Accept': 'application/json' } }).then(r => r.json()).then(d => { subscribed = true; })" 
                              class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <label for="footer-email" class="sr-only">Email Address</label>
                            <input type="email" id="footer-email" name="email" required placeholder="founder@company.com" 
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
                        Instant 1-click unsubscribe. We respect your inbox privacy.
                    </p>
                </div>
            </div>
        </div>

        <!-- Middle Section: Nav Columns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8 pb-12 border-b border-[var(--border-subtle)] text-xs">
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" class="inline-block focus:outline-none focus:ring-2 focus:ring-[#6D28D9] rounded">
                    <h4 class="font-serif text-2xl font-bold text-[var(--text-heading)]">Daily AI World</h4>
                </a>
                <p class="text-xs text-[var(--text-body)] mt-3 leading-relaxed max-w-sm font-sans">
                    An independent, editorial-first journal dedicated to deep technical analysis, compute infrastructure, and economic dynamics of artificial intelligence.
                </p>
                <div class="mt-4 flex items-center gap-4 text-xs font-mono text-[var(--text-muted)]">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Independent Journalism
                    </span>
                    <span>•</span>
                    <span>No Sponsored Bias</span>
                </div>
            </div>

            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Coverage Desks</h5>
                <ul class="space-y-2.5 text-[var(--text-body)]">
                    <li><a href="{{ route('categories.show', 'coding-architectures') }}" class="hover:text-[#6D28D9] transition-colors">Coding & LLMs</a></li>
                    <li><a href="{{ route('categories.show', 'ai-tools') }}" class="hover:text-[#6D28D9] transition-colors">AI Tools & Agents</a></li>
                    <li><a href="{{ route('categories.show', 'business-saas') }}" class="hover:text-[#6D28D9] transition-colors">Business & SaaS</a></li>
                    <li><a href="{{ route('categories.show', 'research-papers') }}" class="hover:text-[#6D28D9] transition-colors">Frontier Research</a></li>
                    <li><a href="{{ route('categories.show', 'open-source') }}" class="hover:text-[#6D28D9] transition-colors">Open Source</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Journal</h5>
                <ul class="space-y-2.5 text-[var(--text-body)]">
                    <li><a href="{{ route('design-system') }}" class="hover:text-[#6D28D9] transition-colors">Design System</a></li>
                    <li><a href="{{ route('bookmarks.index') }}" class="hover:text-[#6D28D9] transition-colors">Reading List</a></li>
                    <li><a href="{{ route('search') }}" class="hover:text-[#6D28D9] transition-colors">Search Archive</a></li>
                    <li><a href="{{ route('cms.dashboard') }}" class="hover:text-[#6D28D9] transition-colors">Enterprise Portal</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-mono text-xs uppercase font-semibold text-[var(--text-heading)] tracking-wider mb-4">Authority</h5>
                <ul class="space-y-2.5 text-[var(--text-muted)]">
                    <li>Editorial Independence</li>
                    <li>Peer-Review Process</li>
                    <li>Disclosure Policy</li>
                    <li>RSS & Open API</li>
                </ul>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-[var(--text-muted)] font-mono gap-4">
            <p>© {{ date('Y') }} Daily AI World Inc. All rights reserved. Built with Laravel 13.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-[#6D28D9]">Terms of Service</a>
                <a href="#" class="hover:text-[#6D28D9]">Privacy Policy</a>
                <a href="#" class="hover:text-[#6D28D9]">Security</a>
            </div>
        </div>

    </div>
</footer>

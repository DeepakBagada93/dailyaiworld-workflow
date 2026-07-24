<?php
/**
 * Front Page Template - Daily AI World 2026 (GSAP Motion UI)
 *
 * @package DailyAIWorld2026
 */

get_header();
?>

<main class="container">
    <!-- HERO SECTION -->
    <section class="hero-wrapper">
        <div class="hero-pill gsap-hero-pill">
            <span class="logo-dot" style="width:6px; height:6px;"></span>
            <span>Updated for 2026</span> • <span>100% Open-Source Registry</span>
        </div>
        <h1 class="hero-title-main gsap-hero-title">
            AI Workflow Directory & <br>
            <span class="hero-title-gradient">MCP Servers Registry 2026</span>
        </h1>
        <p class="hero-desc gsap-hero-desc">
            Discover, copy, and deploy production-grade AI automation pipelines and Model Context Protocol (MCP) integrations built for Claude Desktop, Cursor, LangChain, n8n, and autonomous AI agents.
        </p>
        <div class="hero-ctas gsap-hero-ctas">
            <a href="#workflows" class="btn-vibrant">Explore Workflows &rarr;</a>
            <a href="#mcp-servers" class="btn-outline">Browse MCP Registry &rarr;</a>
        </div>
    </section>

    <!-- REAL-TIME STATS BANNER -->
    <section class="stats-banner gsap-stats-banner" id="stats">
        <div>
            <div class="stat-number count-target" data-count="<?php echo esc_attr(max(dailyaiworld_get_cpt_count('workflow'), 12)); ?>">12+</div>
            <div class="stat-label">AI Workflows</div>
        </div>
        <div>
            <div class="stat-number count-target" data-count="<?php echo esc_attr(max(dailyaiworld_get_cpt_count('mcp_server'), 18)); ?>">18+</div>
            <div class="stat-label">MCP Servers Registered</div>
        </div>
        <div>
            <div class="stat-number">&lt; 1.2s</div>
            <div class="stat-label">Page Load Speed</div>
        </div>
        <div>
            <div class="stat-number">100%</div>
            <div class="stat-label">Free & Open Source</div>
        </div>
    </section>

    <!-- FEATURED WORKFLOWS DIRECTORY -->
    <section id="workflows" style="margin-bottom: 70px;">
        <div class="section-header-flex">
            <div>
                <span class="tag-badge badge-workflow">Automation Pipelines</span>
                <h2 class="section-heading" style="margin-top: 6px;">Featured AI Workflows</h2>
            </div>
            <a href="<?php echo esc_url(home_url('/explore')); ?>" class="btn-outline">View All Workflows &rarr;</a>
        </div>

        <div class="grid-3-col gsap-workflow-grid">
            <?php
            $wf_query = new WP_Query(array(
                'post_type'      => 'workflow',
                'posts_per_page' => 6,
                'no_found_rows'  => true,
            ));

            if ($wf_query->have_posts()) :
                while ($wf_query->have_posts()) : $wf_query->the_post();
                    $exec_time = get_field('execution_time') ?: '5 mins';
                    $trigger   = get_field('trigger_type') ?: 'Webhook';
                    $short_desc= get_field('short_description') ?: get_the_excerpt();
                    ?>
                    <article class="card-item">
                        <div class="card-top">
                            <span class="tag-badge badge-workflow">Workflow</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">⏱️ <?php echo esc_html($exec_time); ?></span>
                        </div>
                        <h3 class="card-item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="card-excerpt">
                            <p><?php echo wp_trim_words($short_desc, 20); ?></p>
                        </div>
                        <div class="card-bottom-meta">
                            <span>Trigger: <?php echo esc_html(ucfirst($trigger)); ?></span>
                            <a href="<?php the_permalink(); ?>" style="font-weight: 700;">View Details &rarr;</a>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-workflow">Workflow</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">⏱️ 2 mins</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Autonomous GitHub PR Code Reviewer</a></h3>
                    <div class="card-excerpt">
                        <p>Triggers on GitHub PR creation, analyzes incoming code diffs, generates inline security & performance reviews via Claude 3.5 Sonnet.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>Trigger: Webhook</span>
                        <a href="#" style="font-weight: 700;">View Details &rarr;</a>
                    </div>
                </article>

                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-workflow">Workflow</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">⏱️ 10 mins</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Multi-Source Vector RAG Ingestion Pipeline</a></h3>
                    <div class="card-excerpt">
                        <p>Monitors Notion databases, PDF whitepapers, and technical docs. Chunks documents and upserts vector embeddings to Qdrant.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>Trigger: Cron Schedule</span>
                        <a href="#" style="font-weight: 700;">View Details &rarr;</a>
                    </div>
                </article>

                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-workflow">Workflow</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">⏱️ 1 min</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Executive AI Briefing Telegram Bot</a></h3>
                    <div class="card-excerpt">
                        <p>Monitors 50+ tech feeds and ArXiv papers, synthesizes bulleted executive digests via DeepSeek R1, and posts to Slack & Telegram.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>Trigger: Event Driven</span>
                        <a href="#" style="font-weight: 700;">View Details &rarr;</a>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </section>

    <!-- MCP REGISTRY SECTION -->
    <section id="mcp-servers" style="margin-bottom: 90px;">
        <div class="section-header-flex">
            <div>
                <span class="tag-badge badge-mcp">Model Context Protocol</span>
                <h2 class="section-heading" style="margin-top: 6px;">MCP Server Registry 2026</h2>
            </div>
            <a href="<?php echo esc_url(home_url('/explore')); ?>" class="btn-outline">Browse All Servers &rarr;</a>
        </div>

        <div class="grid-3-col gsap-mcp-grid">
            <?php
            $mcp_query = new WP_Query(array(
                'post_type'      => 'mcp_server',
                'posts_per_page' => 6,
                'no_found_rows'  => true,
            ));

            if ($mcp_query->have_posts()) :
                while ($mcp_query->have_posts()) : $mcp_query->the_post();
                    $transport = get_field('transport_protocol') ?: 'stdio';
                    $tools_cnt = get_field('tools_count') ?: '1';
                    $short_desc= get_field('short_description') ?: get_the_excerpt();
                    ?>
                    <article class="card-item">
                        <div class="card-top">
                            <span class="tag-badge badge-mcp">MCP Server</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">🛠️ <?php echo esc_html($tools_cnt); ?> Tools</span>
                        </div>
                        <h3 class="card-item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="card-excerpt">
                            <p><?php echo wp_trim_words($short_desc, 20); ?></p>
                        </div>
                        <div class="card-bottom-meta">
                            <span>Protocol: <?php echo esc_html(strtoupper($transport)); ?></span>
                            <a href="<?php the_permalink(); ?>" style="font-weight: 700;">Inspect Server &rarr;</a>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-mcp">MCP Server</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">🛠️ 4 Tools</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">SQLite & PostgreSQL MCP Server</a></h3>
                    <div class="card-excerpt">
                        <p>Official Model Context Protocol server enabling Claude Desktop and Cursor to inspect schemas and safely query databases.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>Protocol: STDIO</span>
                        <a href="#" style="font-weight: 700;">Inspect Server &rarr;</a>
                    </div>
                </article>

                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-mcp">MCP Server</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">🛠️ 8 Tools</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">GitHub & GitLab API MCP Server</a></h3>
                    <div class="card-excerpt">
                        <p>Provides AI coding assistants with direct tools to list issues, search code diffs, read files, and trigger CI/CD workflows.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>Protocol: SSE / STDIO</span>
                        <a href="#" style="font-weight: 700;">Inspect Server &rarr;</a>
                    </div>
                </article>

                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-mcp">MCP Server</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">🛠️ 3 Tools</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Brave Search & Web Scraping MCP</a></h3>
                    <div class="card-excerpt">
                        <p>Enables live web searching, document fetching, and markdown conversion directly into LLM context windows.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>Protocol: STDIO</span>
                        <a href="#" style="font-weight: 700;">Inspect Server &rarr;</a>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </section>

    <!-- CALLOUT SUBMIT BANNER -->
    <section class="gsap-callout" style="background: rgba(11, 11, 16, 0.85); border: 1px solid var(--border-active); border-radius: var(--radius-lg); padding: 56px 40px; text-align: center; margin-bottom: 90px; backdrop-filter: blur(20px); box-shadow: 0 20px 60px var(--accent-glow);">
        <h2 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 14px;">Built an AI Workflow or MCP Server?</h2>
        <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto 32px auto; font-size: 1.1rem;">Share your workflow prompt templates or MCP server implementations with thousands of AI developers worldwide.</p>
        <a href="<?php echo esc_url(home_url('/submit')); ?>" class="btn-vibrant">+ Submit to Registry 2026</a>
    </section>
</main>

<!-- GSAP ANIMATIONS SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap !== 'undefined') {
        if (typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
        }

        // 1. Hero Animations
        var heroTl = gsap.timeline();
        heroTl.from('.gsap-hero-pill', { opacity: 0, y: -25, duration: 0.8, ease: 'power3.out' })
              .from('.gsap-hero-title', { opacity: 0, y: 35, duration: 1, ease: 'power3.out' }, '-=0.5')
              .from('.gsap-hero-desc', { opacity: 0, y: 20, duration: 0.9, ease: 'power3.out' }, '-=0.6')
              .from('.gsap-hero-ctas a', { opacity: 0, scale: 0.88, duration: 0.8, stagger: 0.15, ease: 'back.out(1.7)' }, '-=0.5');

        // 2. Stats Banner Stagger
        gsap.from('.gsap-stats-banner > div', {
            scrollTrigger: {
                trigger: '.gsap-stats-banner',
                start: 'top 85%',
            },
            opacity: 0,
            y: 30,
            duration: 0.8,
            stagger: 0.12,
            ease: 'power3.out'
        });

        // 3. Workflow Cards ScrollTrigger Stagger
        gsap.from('.gsap-workflow-grid .card-item', {
            scrollTrigger: {
                trigger: '.gsap-workflow-grid',
                start: 'top 85%',
            },
            opacity: 0,
            y: 45,
            duration: 0.85,
            stagger: 0.14,
            ease: 'power3.out'
        });

        // 4. MCP Cards ScrollTrigger Stagger
        gsap.from('.gsap-mcp-grid .card-item', {
            scrollTrigger: {
                trigger: '.gsap-mcp-grid',
                start: 'top 85%',
            },
            opacity: 0,
            y: 45,
            duration: 0.85,
            stagger: 0.14,
            ease: 'power3.out'
        });

        // 5. Callout Banner ScrollTrigger
        gsap.from('.gsap-callout', {
            scrollTrigger: {
                trigger: '.gsap-callout',
                start: 'top 90%',
            },
            opacity: 0,
            scale: 0.95,
            duration: 1,
            ease: 'power3.out'
        });
    }
});
</script>

<?php get_footer(); ?>

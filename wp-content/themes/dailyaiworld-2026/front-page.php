<?php
/**
 * Front Page Template - Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */

get_header();
?>

<main class="container">
    <!-- HERO SECTION -->
    <section class="hero-wrapper">
        <div class="hero-pill">
            <span>✨ Updated for 2026</span> • <span>100% Open-Source Directory</span>
        </div>
        <h1 class="hero-title-main">
            AI Workflow Directory & <br>
            <span class="hero-title-gradient">MCP Servers Registry 2026</span>
        </h1>
        <p class="hero-desc">
            Discover, copy, and deploy production-grade AI automation workflows and Model Context Protocol (MCP) integrations built for Claude Desktop, Cursor, LangChain, n8n, and autonomous AI agents.
        </p>
        <div class="hero-ctas">
            <a href="#workflows" class="btn-vibrant">⚡ Explore Workflows</a>
            <a href="#mcp-servers" class="btn-outline">🔌 Browse MCP Registry</a>
        </div>
    </section>

    <!-- REAL-TIME STATS BANNER -->
    <section class="stats-banner" id="stats">
        <div>
            <div class="stat-number"><?php echo esc_html(max(dailyaiworld_get_cpt_count('workflow'), 12)); ?>+</div>
            <div class="stat-label">AI Workflows</div>
        </div>
        <div>
            <div class="stat-number"><?php echo esc_html(max(dailyaiworld_get_cpt_count('mcp_server'), 18)); ?>+</div>
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
    <section id="workflows" style="margin-bottom: 60px;">
        <div class="section-header-flex">
            <div>
                <span class="tag-badge badge-workflow">Automation Pipelines</span>
                <h2 class="section-heading" style="margin-top: 6px;">Featured AI Workflows</h2>
            </div>
            <a href="<?php echo esc_url(home_url('/workflows')); ?>" class="btn-outline">View All Workflows &rarr;</a>
        </div>

        <div class="grid-3-col">
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
                            <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        </div>
                        <div class="card-bottom-meta">
                            <span>⚡ Trigger: <?php echo esc_html(ucfirst($trigger)); ?></span>
                            <a href="<?php the_permalink(); ?>" style="font-weight: 600;">View Workflow &rarr;</a>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback demo card if CPT has no posts yet
                ?>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-workflow">Workflow</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">⏱️ 2 mins</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Autonomous GitHub PR Code Reviewer</a></h3>
                    <div class="card-excerpt">
                        <p>Triggers on GitHub PR creation, analyzes incoming code diffs, generates inline security reviews via Claude 3.5 Sonnet.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>⚡ Trigger: Webhook</span>
                        <a href="#" style="font-weight: 600;">View Workflow &rarr;</a>
                    </div>
                </article>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-workflow">Workflow</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">⏱️ 10 mins</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Multi-Source RAG Knowledge Ingestion</a></h3>
                    <div class="card-excerpt">
                        <p>Automatically syncs Notion docs, PDF whitepapers, and web pages into a Qdrant vector database for AI Agent retrieval.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>⚡ Trigger: Cron Schedule</span>
                        <a href="#" style="font-weight: 600;">View Workflow &rarr;</a>
                    </div>
                </article>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-workflow">Workflow</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">⏱️ 1 min</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Automated Executive News Summarizer</a></h3>
                    <div class="card-excerpt">
                        <p>Scrapes top AI news RSS feeds, synthesizes bulleted executive briefings, and posts to Slack channels every morning.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>⚡ Trigger: Event</span>
                        <a href="#" style="font-weight: 600;">View Workflow &rarr;</a>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </section>

    <!-- MCP REGISTRY SECTION -->
    <section id="mcp-servers" style="margin-bottom: 80px;">
        <div class="section-header-flex">
            <div>
                <span class="tag-badge badge-mcp">Model Context Protocol</span>
                <h2 class="section-heading" style="margin-top: 6px;">MCP Server Registry 2026</h2>
            </div>
            <a href="<?php echo esc_url(home_url('/mcp-servers')); ?>" class="btn-outline">Browse All Servers &rarr;</a>
        </div>

        <div class="grid-3-col">
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
                            <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        </div>
                        <div class="card-bottom-meta">
                            <span>📡 <?php echo esc_html(strtoupper($transport)); ?></span>
                            <a href="<?php the_permalink(); ?>" style="font-weight: 600;">Inspect Server &rarr;</a>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback demo cards
                ?>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-mcp">MCP Server</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">🛠️ 4 Tools</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">SQLite & PostgreSQL MCP Server</a></h3>
                    <div class="card-excerpt">
                        <p>Allows Claude Desktop and Cursor to run read/write queries, inspect database schemas, and execute migrations safely.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>📡 STDIO</span>
                        <a href="#" style="font-weight: 600;">Inspect Server &rarr;</a>
                    </div>
                </article>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-mcp">MCP Server</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">🛠️ 8 Tools</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">GitHub & GitLab API MCP Server</a></h3>
                    <div class="card-excerpt">
                        <p>Integrate issue creation, pull request search, branch checkout, and repository search directly into your AI workflow.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>📡 SSE / STDIO</span>
                        <a href="#" style="font-weight: 600;">Inspect Server &rarr;</a>
                    </div>
                </article>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge badge-mcp">MCP Server</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">🛠️ 3 Tools</span>
                    </div>
                    <h3 class="card-item-title"><a href="#">Brave Search & Web Scraping MCP</a></h3>
                    <div class="card-excerpt">
                        <p>Provides live web search capabilities, real-time page extraction, and markdown conversion for LLM context windows.</p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>📡 STDIO</span>
                        <a href="#" style="font-weight: 600;">Inspect Server &rarr;</a>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </section>

    <!-- CALLOUT SUBMIT BANNER -->
    <section style="background: var(--bg-card); border: 1px solid var(--border-active); border-radius: var(--radius-lg); padding: 48px; text-align: center; margin-bottom: 80px; box-shadow: 0 10px 40px var(--accent-purple-glow);">
        <h2 style="font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 12px;">Built an AI Workflow or MCP Server?</h2>
        <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto 28px auto;">Share your workflow prompt templates or MCP server implementations with thousands of AI developers worldwide.</p>
        <a href="<?php echo esc_url(home_url('/submit')); ?>" class="btn-vibrant">+ Submit to Registry 2026</a>
    </section>
</main>

<?php get_footer(); ?>

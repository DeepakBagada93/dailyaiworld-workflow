<?php
/**
 * Main Index Template - Homepage
 */
get_header();
?>

<main class="container">
    <section class="hero-section">
        <h1 class="hero-title">Discover High-Speed AI Workflows & MCP Servers</h1>
        <p class="hero-subtitle">An open-source, community-driven registry of production-ready AI automation workflows and Model Context Protocol (MCP) integrations.</p>
    </section>

    <!-- WORKFLOWS SECTION -->
    <section>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 class="section-title">⚡ Featured Workflows</h2>
            <a href="<?php echo esc_url(home_url('/workflows')); ?>">View All Workflows &rarr;</a>
        </div>
        <div class="card-grid">
            <?php
            $wf_query = new WP_Query(array(
                'post_type'      => 'workflow',
                'posts_per_page' => 6,
                'no_found_rows'  => true, // Performance optimization
            ));
            if ($wf_query->have_posts()) :
                while ($wf_query->have_posts()) : $wf_query->the_post();
                    $exec_time = get_field('execution_time') ?: '5 mins';
                    $trigger   = get_field('trigger_type') ?: 'Webhook';
                    ?>
                    <article class="card">
                        <div class="card-header">
                            <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <span class="badge">Workflow</span>
                        </div>
                        <div class="card-body">
                            <p><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                        </div>
                        <div class="card-meta">
                            <span>⏱️ <?php echo esc_html($exec_time); ?></span>
                            <span>⚡ <?php echo esc_html(ucfirst($trigger)); ?></span>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="color:var(--text-dim);">No workflows added yet.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- MCP REGISTRY SECTION -->
    <section style="margin-top: 48px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 class="section-title">🔌 MCP Server Registry</h2>
            <a href="<?php echo esc_url(home_url('/mcp-servers')); ?>">Browse All Servers &rarr;</a>
        </div>
        <div class="card-grid">
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
                    <article class="card">
                        <div class="card-header">
                            <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <span class="badge badge-mcp">MCP</span>
                        </div>
                        <div class="card-body">
                            <p><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                        </div>
                        <div class="card-meta">
                            <span>📡 <?php echo esc_html(strtoupper($transport)); ?></span>
                            <span>🛠️ <?php echo esc_html($tools_cnt); ?> Tools</span>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="color:var(--text-dim);">No MCP servers registered yet.</p>';
            endif;
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>

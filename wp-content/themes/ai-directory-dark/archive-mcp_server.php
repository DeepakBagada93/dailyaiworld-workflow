<?php
/**
 * MCP Server Archive Directory Template
 */
get_header();
?>

<main class="container">
    <section class="hero-section" style="padding: 40px 0 20px 0;">
        <h1 class="hero-title">Model Context Protocol (MCP) Registry</h1>
        <p class="hero-subtitle">Connect Claude Desktop, Cursor, and AI agents to external systems, APIs, and databases via MCP.</p>
    </section>

    <div class="card-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post();
            $transport = get_field('transport_protocol') ?: 'stdio';
            $tools_cnt = get_field('tools_count') ?: '1';
        ?>
            <article class="card">
                <div class="card-header">
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <span class="badge badge-mcp">MCP</span>
                </div>
                <div class="card-body">
                    <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <div class="card-meta">
                    <span>📡 <?php echo esc_html(strtoupper($transport)); ?></span>
                    <span>🛠️ <?php echo esc_html($tools_cnt); ?> Tools</span>
                </div>
            </article>
        <?php endwhile;
        the_posts_pagination();
        else : ?>
            <p>No MCP servers registered yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

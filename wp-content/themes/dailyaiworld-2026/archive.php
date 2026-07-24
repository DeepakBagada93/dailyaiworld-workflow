<?php
/**
 * Generic Archive Template - Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */

get_header();
?>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <section class="hero-wrapper" style="padding: 30px 0 20px 0;">
        <span class="hero-pill">📁 Archive Directory</span>
        <h1 class="hero-title-main" style="font-size: clamp(2rem, 4vw, 3.2rem);">
            <?php the_archive_title(); ?>
        </h1>
        <?php the_archive_description('<p class="hero-desc">', '</p>'); ?>
    </section>

    <div class="grid-3-col" style="margin-top: 40px;">
        <?php if (have_posts()) : while (have_posts()) : the_post();
            $post_type = get_post_type();
            $badge_cls = ($post_type === 'mcp_server') ? 'badge-mcp' : 'badge-workflow';
            $badge_lbl = ($post_type === 'mcp_server') ? 'MCP Server' : (($post_type === 'workflow') ? 'Workflow' : 'Post');
        ?>
            <article class="card-item">
                <div class="card-top">
                    <span class="tag-badge <?php echo esc_attr($badge_cls); ?>"><?php echo esc_html($badge_lbl); ?></span>
                    <span style="font-size: 0.8rem; color: var(--text-muted);"><?php echo get_the_date('M j'); ?></span>
                </div>
                <h3 class="card-item-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="card-excerpt">
                    <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <div class="card-bottom-meta">
                    <span>View Entry</span>
                    <a href="<?php the_permalink(); ?>" style="font-weight: 600;">Details &rarr;</a>
                </div>
            </article>
        <?php endwhile;
        the_posts_pagination();
        else : ?>
            <p style="color: var(--text-muted);">No entries found in this archive.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

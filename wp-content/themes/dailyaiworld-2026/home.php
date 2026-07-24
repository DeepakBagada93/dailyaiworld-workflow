<?php
/**
 * Main Blog Index Template - Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */

get_header();
?>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <section class="hero-wrapper" style="padding: 30px 0 20px 0;">
        <span class="hero-pill">📰 AI Engineering Articles</span>
        <h1 class="hero-title-main" style="font-size: clamp(2rem, 4vw, 3.2rem);">
            Daily AI World <span class="hero-title-gradient">Blog & Insights</span>
        </h1>
        <p class="hero-desc" style="max-width: 640px;">
            Tutorials, benchmark breakdowns, MCP server guides, and AI agent architecture patterns.
        </p>
    </section>

    <div class="grid-3-col" style="margin-top: 40px;">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="card-item">
                <div class="card-top">
                    <span class="tag-badge" style="background:rgba(255,255,255,0.06); color:var(--text-secondary);">Article</span>
                    <span style="font-size: 0.8rem; color: var(--text-muted);"><?php echo get_the_date('M j, Y'); ?></span>
                </div>
                <h3 class="card-item-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="card-excerpt">
                    <p><?php echo wp_trim_words(get_the_excerpt(), 22); ?></p>
                </div>
                <div class="card-bottom-meta">
                    <span>By <?php the_author(); ?></span>
                    <a href="<?php the_permalink(); ?>" style="font-weight: 600;">Read Article &rarr;</a>
                </div>
            </article>
        <?php endwhile;
        the_posts_pagination();
        else : ?>
            <p style="color: var(--text-muted);">No blog posts published yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

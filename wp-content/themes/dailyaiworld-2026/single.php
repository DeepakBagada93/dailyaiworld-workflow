<?php
/**
 * Single Blog Post Template - Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */

get_header();

while (have_posts()) : the_post();
?>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <div style="max-width: 840px; margin: 0 auto;">
        <!-- Post Header -->
        <div style="margin-bottom: 24px; text-align: center;">
            <span class="tag-badge" style="background: var(--accent-purple-light); color: var(--accent-purple);">
                📅 Published <?php echo get_the_date('F j, Y'); ?>
            </span>
            <h1 style="font-size: clamp(2.2rem, 4.5vw, 3.4rem); font-weight: 900; color: #fff; margin: 16px 0; line-height: 1.2;">
                <?php the_title(); ?>
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">
                Written by <strong style="color:#fff;"><?php the_author(); ?></strong>
            </p>
        </div>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div style="margin-bottom: 36px; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-muted);">
                <?php the_post_thumbnail('full', array('style' => 'width:100%; height:auto; display:block;')); ?>
            </div>
        <?php endif; ?>

        <!-- Post Content -->
        <article class="card-item" style="padding: 40px;">
            <div style="color: var(--text-primary); font-size: 1.1rem; line-height: 1.8;" class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>

        <!-- Post Navigation -->
        <div style="display:flex; justify-content:space-between; margin-top:32px;">
            <div><?php previous_post_link('%link', '← %title'); ?></div>
            <div><?php next_post_link('%link', '%title →'); ?></div>
        </div>
    </div>
</main>

<?php 
endwhile;
get_footer();
?>

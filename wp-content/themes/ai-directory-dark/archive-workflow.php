<?php
/**
 * Workflow Archive Directory Template
 */
get_header();
?>

<main class="container">
    <section class="hero-section" style="padding: 40px 0 20px 0;">
        <h1 class="hero-title">AI Automation Workflows</h1>
        <p class="hero-subtitle">Explore community and enterprise AI workflows for n8n, LangChain, CrewAI, and Python.</p>
    </section>

    <div class="card-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post();
            $exec_time = get_field('execution_time') ?: '5 mins';
            $trigger   = get_field('trigger_type') ?: 'Webhook';
        ?>
            <article class="card">
                <div class="card-header">
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <span class="badge">Workflow</span>
                </div>
                <div class="card-body">
                    <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
                <div class="card-meta">
                    <span>⏱️ <?php echo esc_html($exec_time); ?></span>
                    <span>⚡ <?php echo esc_html(ucfirst($trigger)); ?></span>
                </div>
            </article>
        <?php endwhile;
        the_posts_pagination();
        else : ?>
            <p>No workflows found.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

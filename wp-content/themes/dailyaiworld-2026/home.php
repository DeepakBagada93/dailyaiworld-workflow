<?php
/**
 * Blog Index / Archive Template - Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */

get_header();
?>

<main class="container" style="padding-top: 50px; padding-bottom: 90px;">
    <div style="text-align: center; margin-bottom: 60px;">
        <span class="tag-badge" style="background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.35); margin-bottom: 16px;">AI Engineering Blog</span>
        <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; color: #fff;">AI Technical Articles & Guides 2026</h1>
        <p style="color: var(--text-secondary); max-width: 650px; margin: 12px auto 0 auto; font-size: 1.1rem;">Deep dives into LLM orchestration, Model Context Protocol servers, RAG ingestion pipelines, and agent benchmarks.</p>
    </div>

    <div class="grid-3-col">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="card-item">
                    <div class="card-top">
                        <span class="tag-badge" style="background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.35);">Article</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);"><?php echo get_the_date('M j, Y'); ?></span>
                    </div>
                    <h3 class="card-item-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="card-excerpt">
                        <p><?php echo wp_trim_words(get_the_excerpt(), 22); ?></p>
                    </div>
                    <div class="card-bottom-meta">
                        <span>Author: <?php the_author(); ?></span>
                        <a href="<?php the_permalink(); ?>" style="font-weight: 700;">Read Guide &rarr;</a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <article class="card-item">
                <div class="card-top">
                    <span class="tag-badge" style="background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.35);">Article</span>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">Jun 20, 2026</span>
                </div>
                <h3 class="card-item-title"><a href="#">Google Cloud Data Agents: Building the Agentic Data Cloud in 2026</a></h3>
                <div class="card-excerpt"><p>Google Cloud launched 6 new data agents as part of the Agentic Data Cloud. Complete deployment and architecture guide.</p></div>
                <div class="card-bottom-meta"><span>Author: Deepak Bagada</span><a href="#" style="font-weight: 700;">Read Guide &rarr;</a></div>
            </article>
            <article class="card-item">
                <div class="card-top">
                    <span class="tag-badge" style="background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.35);">Article</span>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">May 17, 2026</span>
                </div>
                <h3 class="card-item-title"><a href="#">Automating Meeting Tasks with Whisper & Claude AI</a></h3>
                <div class="card-excerpt"><p>Learn how to wire OpenAI Whisper and Claude 3.5 to automatically convert raw meeting recordings into assigned Jira tickets.</p></div>
                <div class="card-bottom-meta"><span>Author: Deepak Bagada</span><a href="#" style="font-weight: 700;">Read Guide &rarr;</a></div>
            </article>
            <article class="card-item">
                <div class="card-top">
                    <span class="tag-badge" style="background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.35);">Article</span>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">Jul 21, 2026</span>
                </div>
                <h3 class="card-item-title"><a href="#">Autonomous Synthetic User Testing Agent: AI UX Audits</a></h3>
                <div class="card-excerpt"><p>Simulate hundreds of target user personas with Browser Use and Claude 3.7 Vision to discover UI friction points automatically.</p></div>
                <div class="card-bottom-meta"><span>Author: Deepak Bagada</span><a href="#" style="font-weight: 700;">Read Guide &rarr;</a></div>
            </article>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

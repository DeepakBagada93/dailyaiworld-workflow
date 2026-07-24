<?php
/**
 * Single Workflow Template
 */
get_header();

while (have_posts()) : the_post();
    $github_url    = get_field('github_url');
    $exec_time     = get_field('execution_time') ?: 'N/A';
    $trigger_type  = get_field('trigger_type') ?: 'Manual';
    $prompt_snippet= get_field('prompt_snippet');
    $complexity    = get_field('complexity') ?: 'Intermediate';
    $categories    = get_the_terms(get_the_ID(), 'workflow_category');
    $models        = get_the_terms(get_the_ID(), 'ai_model');
?>

<main class="container">
    <div style="margin-top: 32px;">
        <span class="badge">Workflow</span>
        <h1 style="font-size: 2.25rem; font-weight: 800; margin-top: 8px; color: #fff;"><?php the_title(); ?></h1>
    </div>

    <div class="single-container">
        <div class="main-content">
            <h2 class="widget-title">Workflow Overview</h2>
            <div style="margin-bottom: 24px;">
                <?php the_content(); ?>
            </div>

            <?php if ($prompt_snippet) : ?>
                <h3 class="widget-title" style="margin-top: 32px;">System Prompt / Pipeline Config</h3>
                <div class="code-box">
                    <button class="copy-btn" data-target="prompt-code">Copy Prompt</button>
                    <pre id="prompt-code"><code><?php echo esc_html($prompt_snippet); ?></code></pre>
                </div>
            <?php endif; ?>
        </div>

        <aside class="sidebar">
            <div class="widget">
                <h3 class="widget-title">Workflow Specs</h3>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:12px; font-size:0.9rem;">
                    <li><strong>⏱️ Execution Time:</strong> <?php echo esc_html($exec_time); ?></li>
                    <li><strong>⚡ Trigger:</strong> <?php echo esc_html(ucfirst($trigger_type)); ?></li>
                    <li><strong>📊 Complexity:</strong> <?php echo esc_html($complexity); ?></li>
                    <?php if ($categories && !is_wp_error($categories)) : ?>
                        <li><strong>📁 Category:</strong> <?php echo esc_html($categories[0]->name); ?></li>
                    <?php endif; ?>
                    <?php if ($models && !is_wp_error($models)) : ?>
                        <li><strong>🤖 Compatible Models:</strong> 
                            <?php foreach ($models as $m) { echo '<span class="badge" style="margin-right:4px;">' . esc_html($m->name) . '</span>'; } ?>
                        </li>
                    <?php endif; ?>
                </ul>

                <?php if ($github_url) : ?>
                    <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener noreferrer" class="btn-primary" style="display:block; margin-top:20px; text-align:center;">
                        View Source on GitHub &rarr;
                    </a>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</main>

<?php 
endwhile;
get_footer();
?>

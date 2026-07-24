<?php
/**
 * Single Workflow Post Template - Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */

get_header();

while (have_posts()) : the_post();
    $short_desc     = get_post_meta(get_the_ID(), 'short_description', true) ?: get_the_excerpt();
    $github_link    = get_post_meta(get_the_ID(), 'github_link', true);
    $demo_url       = get_post_meta(get_the_ID(), 'demo_url', true);
    $tech_stack_txt = get_post_meta(get_the_ID(), 'tech_stack_text', true);
    $difficulty     = get_post_meta(get_the_ID(), 'difficulty', true) ?: 'Intermediate';
    $status         = get_post_meta(get_the_ID(), 'status', true) ?: 'Active';
    
    $types          = get_the_terms(get_the_ID(), 'workflow-type');
    $tech_terms     = get_the_terms(get_the_ID(), 'tech-stack');
    $years          = get_the_terms(get_the_ID(), 'year');
?>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <!-- Breadcrumb & Top Badges -->
    <div style="display:flex; gap:10px; align-items:center; margin-bottom: 12px; flex-wrap:wrap;">
        <span class="tag-badge badge-workflow">Workflow</span>
        <span class="tag-badge" style="background: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3);">
            ● <?php echo esc_html($status); ?>
        </span>
        <?php if ($years && !is_wp_error($years)) : ?>
            <span class="tag-badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border: 1px solid var(--border-muted);">
                📅 <?php echo esc_html($years[0]->name); ?>
            </span>
        <?php endif; ?>
    </div>

    <!-- Title & Short Description -->
    <h1 style="font-size: clamp(2rem, 4vw, 3.2rem); font-weight: 900; color: #ffffff; line-height: 1.2; margin-bottom: 16px;">
        <?php the_title(); ?>
    </h1>
    <p style="font-size: 1.2rem; color: var(--text-secondary); max-width: 820px; margin-bottom: 36px;">
        <?php echo esc_html($short_desc); ?>
    </p>

    <!-- Main Grid Layout -->
    <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 36px;" class="single-layout-grid">
        <!-- Content Area -->
        <div style="display:flex; flex-direction:column; gap:28px;">
            <!-- Article Body -->
            <div class="card-item" style="padding: 36px;">
                <h2 style="font-size: 1.4rem; font-weight: 700; color: #ffffff; margin-bottom: 20px; border-bottom: 1px solid var(--border-muted); padding-bottom: 12px;">
                    ⚡ Workflow Overview & Implementation
                </h2>
                <div style="color: var(--text-primary); font-size: 1.05rem; line-height: 1.7;" class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Prompt / Configuration Snippet -->
            <div class="card-item" style="padding: 32px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: #ffffff;">📋 Prompt / System Config</h3>
                    <button class="btn-vibrant copy-btn-trigger" data-target="code-snippet-box" style="padding: 6px 14px; font-size: 0.85rem;">
                        Copy Prompt
                    </button>
                </div>
                <div style="background: #000000; border: 1px solid var(--border-muted); border-radius: var(--radius-sm); padding: 20px; overflow-x: auto;">
                    <pre id="code-snippet-box" style="font-family: var(--font-mono); color: #a7f3d0; font-size: 0.92rem; white-space: pre-wrap;"><code>System: You are an expert AI software engineer. Evaluate incoming Git pull requests, detect potential race conditions, memory leaks, and performance bottlenecks, then produce formatted Markdown inline review comments.</code></pre>
                </div>
            </div>
        </div>

        <!-- Sidebar Specs -->
        <aside style="display:flex; flex-direction:column; gap:24px;">
            <div class="card-item" style="padding: 28px;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 20px; border-bottom: 1px solid var(--border-muted); padding-bottom: 10px;">
                    📊 Metadata & Specs
                </h3>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:16px; font-size: 0.95rem;">
                    <li style="display:flex; justify-content:space-between;">
                        <span style="color: var(--text-muted);">Difficulty:</span>
                        <strong style="color: var(--accent-purple);"><?php echo esc_html($difficulty); ?></strong>
                    </li>
                    <li style="display:flex; justify-content:space-between;">
                        <span style="color: var(--text-muted);">Status:</span>
                        <strong style="color: #4ade80;"><?php echo esc_html($status); ?></strong>
                    </li>
                    <?php if ($types && !is_wp_error($types)) : ?>
                        <li style="display:flex; justify-content:space-between;">
                            <span style="color: var(--text-muted);">Category:</span>
                            <strong><?php echo esc_html($types[0]->name); ?></strong>
                        </li>
                    <?php endif; ?>
                    <?php if ($tech_stack_txt) : ?>
                        <li style="display:flex; flex-direction:column; gap:6px;">
                            <span style="color: var(--text-muted);">Tech Stack:</span>
                            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                                <?php 
                                $stacks = explode(',', $tech_stack_txt);
                                foreach ($stacks as $s) {
                                    echo '<span class="tag-badge" style="background:rgba(255,255,255,0.06); color:var(--text-primary); border:1px solid var(--border-muted);">' . esc_html(trim($s)) . '</span>';
                                }
                                ?>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>

                <div style="display:flex; flex-direction:column; gap:12px; margin-top:28px;">
                    <?php if ($github_link) : ?>
                        <a href="<?php echo esc_url($github_link); ?>" target="_blank" rel="noopener noreferrer" class="btn-vibrant" style="justify-content:center;">
                            View Source on GitHub ↗
                        </a>
                    <?php endif; ?>
                    <?php if ($demo_url) : ?>
                        <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="btn-outline" style="justify-content:center;">
                            Watch Demo Video ↗
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</main>

<style>
@media (max-width: 868px) {
    .single-layout-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var copyBtn = document.querySelector('.copy-btn-trigger');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var targetEl = document.getElementById(targetId);
            if (targetEl) {
                navigator.clipboard.writeText(targetEl.innerText).then(function() {
                    copyBtn.innerText = '✓ Copied!';
                    setTimeout(function() { copyBtn.innerText = 'Copy Prompt'; }, 2000);
                });
            }
        });
    }
});
</script>

<?php 
endwhile;
get_footer();
?>

<?php
/**
 * Template Name: Submit Item
 *
 * @package DailyAIWorld2026
 */

get_header();
?>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <section class="hero-wrapper" style="padding: 30px 0 20px 0;">
        <span class="hero-pill">🚀 Open Community Registry</span>
        <h1 class="hero-title-main" style="font-size: clamp(2rem, 4vw, 3.2rem);">
            Submit to <span class="hero-title-gradient">Daily AI World 2026</span>
        </h1>
        <p class="hero-desc" style="max-width: 640px;">
            Submit your AI Workflow pipeline or Model Context Protocol (MCP) Server to be featured in the global open-source directory.
        </p>
    </section>

    <div style="max-width: 760px; margin: 0 auto;">
        <div class="card-item" style="padding: 40px;">
            <?php
            while (have_posts()) : the_post();
                the_content();
            endwhile;

            // Fallback submission form if Contact Form 7 shortcode is not placed in page content
            if (empty(get_the_content())) :
            ?>
                <form action="#" method="post" style="display:flex; flex-direction:column; gap:20px;" onsubmit="alert('Thank you for your submission! Our team will review your item shortly.'); return false;">
                    <div>
                        <label style="display:block; color:#fff; font-weight:600; margin-bottom:8px;">Submission Type</label>
                        <select style="width:100%; background:#000; border:1px solid var(--border-muted); color:#fff; padding:12px; border-radius:var(--radius-sm);">
                            <option value="workflow">⚡ AI Workflow Pipeline</option>
                            <option value="mcp_server">🔌 MCP Server Integration</option>
                        </select>
                    </div>

                    <div>
                        <label style="display:block; color:#fff; font-weight:600; margin-bottom:8px;">Workflow / Server Title *</label>
                        <input type="text" required placeholder="e.g. Autonomous GitHub PR Code Reviewer" 
                               style="width:100%; background:#000; border:1px solid var(--border-muted); color:#fff; padding:12px; border-radius:var(--radius-sm);" />
                    </div>

                    <div>
                        <label style="display:block; color:#fff; font-weight:600; margin-bottom:8px;">GitHub Repository or Source URL *</label>
                        <input type="url" required placeholder="https://github.com/username/repository" 
                               style="width:100%; background:#000; border:1px solid var(--border-muted); color:#fff; padding:12px; border-radius:var(--radius-sm);" />
                    </div>

                    <div>
                        <label style="display:block; color:#fff; font-weight:600; margin-bottom:8px;">Short Description *</label>
                        <textarea required rows="3" placeholder="Briefly describe what this workflow or MCP server does..." 
                                  style="width:100%; background:#000; border:1px solid var(--border-muted); color:#fff; padding:12px; border-radius:var(--radius-sm);"></textarea>
                    </div>

                    <div>
                        <label style="display:block; color:#fff; font-weight:600; margin-bottom:8px;">Tech Stack / Tools Used</label>
                        <input type="text" placeholder="e.g. n8n, Claude 3.5 Sonnet, SQLite, Python" 
                               style="width:100%; background:#000; border:1px solid var(--border-muted); color:#fff; padding:12px; border-radius:var(--radius-sm);" />
                    </div>

                    <div>
                        <label style="display:block; color:#fff; font-weight:600; margin-bottom:8px;">Prompt Snippet or Install Command</label>
                        <textarea rows="4" placeholder="Paste system prompt, JSON config, or npx install command..." 
                                  style="width:100%; background:#000; border:1px solid var(--border-muted); color:#fff; padding:12px; border-radius:var(--radius-sm); font-family:var(--font-mono);"></textarea>
                    </div>

                    <button type="submit" class="btn-vibrant" style="justify-content:center; padding:14px;">
                        🚀 Submit for Review
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

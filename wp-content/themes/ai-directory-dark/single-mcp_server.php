<?php
/**
 * Single MCP Server Template
 */
get_header();

while (have_posts()) : the_post();
    $repo_url          = get_field('repo_url');
    $transport         = get_field('transport_protocol') ?: 'stdio';
    $install_command   = get_field('install_command');
    $json_config       = get_field('json_config');
    $tools_count       = get_field('tools_count') ?: '1';
    $vendor_name       = get_field('vendor_name') ?: 'Community';
    $mcp_categories    = get_the_terms(get_the_ID(), 'mcp_category');
?>

<main class="container">
    <div style="margin-top: 32px;">
        <span class="badge badge-mcp">MCP Server</span>
        <h1 style="font-size: 2.25rem; font-weight: 800; margin-top: 8px; color: #fff;"><?php the_title(); ?></h1>
    </div>

    <div class="single-container">
        <div class="main-content">
            <h2 class="widget-title">Description & Functionality</h2>
            <div style="margin-bottom: 24px;">
                <?php the_content(); ?>
            </div>

            <?php if ($install_command) : ?>
                <h3 class="widget-title" style="margin-top: 32px;">Quick Install Command</h3>
                <div class="code-box">
                    <button class="copy-btn" data-target="install-code">Copy Command</button>
                    <pre id="install-code"><code><?php echo esc_html($install_command); ?></code></pre>
                </div>
            <?php endif; ?>

            <?php if ($json_config) : ?>
                <h3 class="widget-title" style="margin-top: 24px;">Claude Desktop Configuration JSON</h3>
                <div class="code-box">
                    <button class="copy-btn" data-target="json-code">Copy JSON</button>
                    <pre id="json-code"><code><?php echo esc_html($json_config); ?></code></pre>
                </div>
            <?php endif; ?>
        </div>

        <aside class="sidebar">
            <div class="widget">
                <h3 class="widget-title">MCP Metadata</h3>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:12px; font-size:0.9rem;">
                    <li><strong>📡 Transport:</strong> <?php echo esc_html(strtoupper($transport)); ?></li>
                    <li><strong>🛠️ Provided Tools:</strong> <?php echo esc_html($tools_count); ?></li>
                    <li><strong>👤 Maintainer:</strong> <?php echo esc_html($vendor_name); ?></li>
                    <?php if ($mcp_categories && !is_wp_error($mcp_categories)) : ?>
                        <li><strong>📁 Category:</strong> <?php echo esc_html($mcp_categories[0]->name); ?></li>
                    <?php endif; ?>
                </ul>

                <?php if ($repo_url) : ?>
                    <a href="<?php echo esc_url($repo_url); ?>" target="_blank" rel="noopener noreferrer" class="btn-primary" style="display:block; margin-top:20px; text-align:center;">
                        View Source Repository &rarr;
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

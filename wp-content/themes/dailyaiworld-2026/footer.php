<?php
/**
 * Footer template for Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */
?>
<footer class="site-footer">
    <div class="container footer-inner">
        <div>
            <p>&copy; <?php echo date('Y'); ?> <strong>Daily AI World 2026</strong> — Open Source AI Workflow Directory & MCP Registry.</p>
            <p style="font-size: 0.8rem; margin-top: 4px; color: var(--text-muted);">Hosted on Hostinger | Powered by WordPress, LiteSpeed & Redis Object Cache.</p>
        </div>
        <div style="display:flex; gap:16px; align-items:center;">
            <a href="<?php echo esc_url(home_url('/workflows')); ?>" style="color:var(--text-secondary);">Workflows</a>
            <a href="<?php echo esc_url(home_url('/mcp-servers')); ?>" style="color:var(--text-secondary);">MCP Registry</a>
            <a href="#top" style="color:var(--accent-purple);">Back to Top ↑</a>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

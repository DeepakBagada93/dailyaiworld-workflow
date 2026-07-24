<?php
/**
 * Header template for Daily AI World 2026
 *
 * @package DailyAIWorld2026
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#050507">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container header-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo">
            ⚡ <span>Daily AI World</span> <span class="brand-year">2026</span>
        </a>

        <button class="mobile-toggle" id="menuToggle" aria-label="Toggle navigation">
            ☰
        </button>

        <nav class="nav-links" id="mainNav">
            <a href="<?php echo esc_url(home_url('/workflows')); ?>">Workflows</a>
            <a href="<?php echo esc_url(home_url('/mcp-servers')); ?>">MCP Registry</a>
            <a href="<?php echo esc_url(home_url('/#stats')); ?>">Stats</a>
            <a href="<?php echo esc_url(home_url('/submit')); ?>" class="btn-vibrant">+ Submit Item</a>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menuToggle');
    var mainNav = document.getElementById('mainNav');
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
        });
    }
});
</script>

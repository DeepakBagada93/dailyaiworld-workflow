<?php
/**
 * Header template
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#050507">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container header-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
            ⚡ <span>AI Workflow</span> & MCP Directory
        </a>
        <nav class="main-nav">
            <a href="<?php echo esc_url(home_url('/workflows')); ?>">Workflows</a>
            <a href="<?php echo esc_url(home_url('/mcp-servers')); ?>">MCP Registry</a>
            <a href="<?php echo esc_url(home_url('/submit')); ?>" class="btn-primary" style="padding: 6px 14px;">+ Submit</a>
        </nav>
    </div>
</header>

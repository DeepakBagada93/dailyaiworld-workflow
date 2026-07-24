<?php
/**
 * Plugin Name: AI Directory & MCP Registry Core
 * Description: Registers CPTs (Workflows & MCP Servers), Taxonomies, ACF Fields, Rank Math Directory Schema, and Core Performance Tweaks.
 * Version: 1.1.0
 * Author: Daily AI World Engineering
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * --------------------------------------------------------------------------
 * 1. CUSTOM POST TYPES REGISTRATION
 * --------------------------------------------------------------------------
 */
function ai_directory_register_cpts() {
    
    // Workflows CPT
    register_post_type('workflow', array(
        'labels'             => array('name' => 'Workflows', 'singular_name' => 'Workflow'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'workflows', 'with_front' => false),
        'capability_type'    => 'post',
        'has_archive'        => 'workflows',
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-networking',
        'show_in_rest'       => true,
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'author')
    ));

    // MCP Servers CPT
    register_post_type('mcp_server', array(
        'labels'             => array('name' => 'MCP Servers', 'singular_name' => 'MCP Server'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'mcp-servers', 'with_front' => false),
        'capability_type'    => 'post',
        'has_archive'        => 'mcp-servers',
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-server',
        'show_in_rest'       => true,
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'author')
    ));
}
add_action('init', 'ai_directory_register_cpts', 0);

/**
 * --------------------------------------------------------------------------
 * 2. RANK MATH JSON-LD SCHEMA INTEGRATION (Directory Structured Data)
 * --------------------------------------------------------------------------
 */
function ai_directory_rank_math_schema($data, $jsonld) {
    if (is_singular(array('workflow', 'mcp_server'))) {
        $post_id    = get_the_ID();
        $title      = get_the_title();
        $desc       = get_post_meta($post_id, 'short_description', true) ?: get_the_excerpt();
        $github_url = get_post_meta($post_id, 'github_link', true);
        $post_type  = get_post_type();

        $schema = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'SoftwareApplication',
            'name'            => $title,
            'description'     => $desc,
            'applicationCategory' => ($post_type === 'mcp_server') ? 'DeveloperApplication' : 'BusinessApplication',
            'operatingSystem' => 'Cross-platform (Node.js, Python, Docker)',
            'offers'          => array(
                '@type'         => 'Offer',
                'price'         => '0.00',
                'priceCurrency' => 'USD'
            )
        );

        if ($github_url) {
            $schema['downloadUrl'] = $github_url;
            $schema['codeRepository'] = $github_url;
        }

        $data['SoftwareApplication'] = $schema;
    }
    return $data;
}
add_filter('rank_math/json_ld', 'ai_directory_rank_math_schema', 99, 2);

/**
 * --------------------------------------------------------------------------
 * 3. PERFORMANCE TUNING & LIGHTHOUSE OPTIMIZATIONS
 * --------------------------------------------------------------------------
 */

// Disable WP Emojis
function ai_directory_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'ai_directory_disable_emojis');

// Remove unnecessary WP Header clutter & WP version
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Remove WP version parameter from CSS/JS scripts
function ai_directory_remove_wp_version($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'ai_directory_remove_wp_version', 9999);
add_filter('script_loader_src', 'ai_directory_remove_wp_version', 9999);

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Restrict Heartbeat API
function ai_directory_stop_heartbeat($settings) {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    } else {
        $settings['interval'] = 60;
    }
    return $settings;
}
add_filter('heartbeat_settings', 'ai_directory_stop_heartbeat');

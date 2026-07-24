<?php
/**
 * Daily AI World 2026 Theme Functions
 *
 * @package DailyAIWorld2026
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Include CPT Architecture, Taxonomies, ACF Fields & REST API Registration
 */
require_once get_template_directory() . '/inc/cpt-architecture.php';

/**
 * Theme Setup
 */
function dailyaiworld_2026_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 40,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Register Navigation Menus
    register_nav_menus(array(
        'primary_menu' => __('Primary Navigation 2026', 'dailyaiworld-2026'),
        'footer_menu'  => __('Footer Navigation 2026', 'dailyaiworld-2026'),
    ));
}
add_action('after_setup_theme', 'dailyaiworld_2026_setup');

/**
 * Enqueue Styles and Scripts
 */
function dailyaiworld_2026_scripts() {
    // Google Fonts (Inter)
    wp_enqueue_style('dailyaiworld-font', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap', array(), null);

    // Optional: Enqueue Tailwind CSS Play CDN for utility classes (Free Open Source)
    wp_enqueue_script('tailwind-cdn', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4', array(), null, false);

    // Theme main stylesheet
    wp_enqueue_style('dailyaiworld-2026-style', get_stylesheet_uri(), array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'dailyaiworld_2026_scripts');

/**
 * Defer non-critical scripts for ultra-fast load time
 */
function dailyaiworld_2026_defer_scripts($tag, $handle, $src) {
    if (is_admin()) {
        return $tag;
    }
    if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
        return str_replace(' src', ' defer="defer" src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'dailyaiworld_2026_defer_scripts', 10, 3);

/**
 * Helper to get count of Published Custom Post Types for Hero Stats
 */
function dailyaiworld_get_cpt_count($post_type = 'workflow') {
    $count = wp_count_posts($post_type);
    return isset($count->publish) ? intval($count->publish) : 0;
}

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
 * Fallback helper for get_field() if ACF plugin is not yet active
 */
if (!function_exists('get_field')) {
    function get_field($selector, $post_id = false, $format_value = true) {
        $post_id = $post_id ? $post_id : get_the_ID();
        return get_post_meta($post_id, $selector, true);
    }
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

    register_nav_menus(array(
        'primary_menu' => __('Primary Navigation 2026', 'dailyaiworld-2026'),
        'footer_menu'  => __('Footer Navigation 2026', 'dailyaiworld-2026'),
    ));
}
add_action('after_setup_theme', 'dailyaiworld_2026_setup');

/**
 * Enqueue Styles and GSAP Scripts
 */
function dailyaiworld_2026_scripts() {
    // Google Fonts (Plus Jakarta Sans & Fira Code)
    wp_enqueue_style('dailyaiworld-font', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;600&display=swap', array(), null);

    // Enqueue GSAP 3.12+ Core & ScrollTrigger for High-End Motion UI
    wp_enqueue_script('gsap-core', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap-core'), '3.12.5', true);

    // Theme main stylesheet
    wp_enqueue_style('dailyaiworld-2026-style', get_stylesheet_uri(), array(), '2.0.0');
}
add_action('wp_enqueue_scripts', 'dailyaiworld_2026_scripts');

/**
 * Helper to get count of Published Custom Post Types for Hero Stats
 */
function dailyaiworld_get_cpt_count($post_type = 'workflow') {
    $count = wp_count_posts($post_type);
    return isset($count->publish) ? intval($count->publish) : 0;
}

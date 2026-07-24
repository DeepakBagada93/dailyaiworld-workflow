<?php
/**
 * Plugin Name: AI Directory & MCP Registry Core
 * Description: Single source of truth for Custom Post Types, Taxonomies, ACF Fields, REST API, and Core Optimizations.
 * Version: 2.0.0
 * Author: Daily AI World Engineering
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * --------------------------------------------------------------------------
 * 1. REGISTER CUSTOM POST TYPES
 * --------------------------------------------------------------------------
 */
function ai_directory_register_cpts() {
    if (!post_type_exists('workflow')) {
        register_post_type('workflow', array(
            'label'                 => __('Workflow', 'dailyaiworld-2026'),
            'labels'                => array(
                'name'          => 'Workflows',
                'singular_name' => 'Workflow',
                'add_new_item'  => 'Add New Workflow',
                'edit_item'     => 'Edit Workflow',
            ),
            'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'author'),
            'taxonomies'            => array('workflow-type', 'tech-stack', 'year', 'workflow_category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-networking',
            'has_archive'           => 'workflows',
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'workflows',
        ));
    }

    if (!post_type_exists('mcp_server')) {
        register_post_type('mcp_server', array(
            'label'                 => __('MCP Server', 'dailyaiworld-2026'),
            'labels'                => array(
                'name'          => 'MCP Servers',
                'singular_name' => 'MCP Server',
                'add_new_item'  => 'Add New MCP Server',
                'edit_item'     => 'Edit MCP Server',
            ),
            'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'author'),
            'taxonomies'            => array('tech-stack', 'year', 'mcp_category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 6,
            'menu_icon'             => 'dashicons-server',
            'has_archive'           => 'mcp-servers',
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'mcp-servers',
        ));
    }
}
add_action('init', 'ai_directory_register_cpts', 0);

/**
 * --------------------------------------------------------------------------
 * 2. REGISTER CUSTOM TAXONOMIES
 * --------------------------------------------------------------------------
 */
function ai_directory_register_taxonomies() {
    if (!taxonomy_exists('workflow-type')) {
        register_taxonomy('workflow-type', array('workflow'), array(
            'hierarchical' => true,
            'labels'       => array('name' => 'Workflow Types'),
            'show_in_rest' => true,
            'rewrite'      => array('slug' => 'workflow-type'),
        ));
    }

    if (!taxonomy_exists('tech-stack')) {
        register_taxonomy('tech-stack', array('workflow', 'mcp_server'), array(
            'hierarchical' => false,
            'labels'       => array('name' => 'Tech Stacks'),
            'show_in_rest' => true,
            'rewrite'      => array('slug' => 'tech-stack'),
        ));
    }

    if (!taxonomy_exists('year')) {
        register_taxonomy('year', array('workflow', 'mcp_server'), array(
            'hierarchical' => true,
            'labels'       => array('name' => 'Years'),
            'show_in_rest' => true,
            'rewrite'      => array('slug' => 'year'),
        ));
    }
}
add_action('init', 'ai_directory_register_taxonomies', 0);

/**
 * --------------------------------------------------------------------------
 * 3. ADVANCED CUSTOM FIELDS (PROGRAMMATIC ACF FIELDS)
 * --------------------------------------------------------------------------
 */
function ai_directory_register_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_ai_workflow_meta_2026',
            'title' => 'AI Workflow Metadata 2026',
            'fields' => array(
                array('key' => 'field_short_description', 'label' => 'Short Description', 'name' => 'short_description', 'type' => 'textarea', 'rows' => 3),
                array('key' => 'field_github_link', 'label' => 'GitHub Repository URL', 'name' => 'github_link', 'type' => 'url'),
                array('key' => 'field_demo_url', 'label' => 'Live Demo / Video URL', 'name' => 'demo_url', 'type' => 'url'),
                array('key' => 'field_tech_stack_text', 'label' => 'Tech Stack List', 'name' => 'tech_stack_text', 'type' => 'text'),
                array('key' => 'field_difficulty', 'label' => 'Difficulty Level', 'name' => 'difficulty', 'type' => 'select', 'choices' => array('Beginner' => 'Beginner', 'Intermediate' => 'Intermediate', 'Advanced' => 'Advanced')),
                array('key' => 'field_status', 'label' => 'Project Status', 'name' => 'status', 'type' => 'select', 'choices' => array('Active' => 'Active', 'Beta' => 'Beta', 'Deprecated' => 'Deprecated')),
            ),
            'location' => array(
                array(array('param' => 'post_type', 'operator' => '==', 'value' => 'workflow')),
                array(array('param' => 'post_type', 'operator' => '==', 'value' => 'mcp_server')),
            ),
        ));
    }
}
add_action('acf/init', 'ai_directory_register_acf_fields');

/**
 * --------------------------------------------------------------------------
 * 4. REST API EXPOSURE & SEARCH INTEGRATION
 * --------------------------------------------------------------------------
 */
function ai_directory_register_rest_fields() {
    $fields = array('short_description', 'github_link', 'demo_url', 'tech_stack_text', 'difficulty', 'status');

    foreach ($fields as $field) {
        register_rest_field(array('workflow', 'mcp_server'), $field, array(
            'get_callback' => function($post_arr) use ($field) {
                $id = 0;
                if (is_array($post_arr) && isset($post_arr['id'])) {
                    $id = $post_arr['id'];
                } elseif (is_object($post_arr) && isset($post_arr->ID)) {
                    $id = $post_arr->ID;
                }
                return $id ? get_post_meta($id, $field, true) : '';
            },
            'update_callback' => function($value, $post_obj) use ($field) {
                $id = is_object($post_obj) ? $post_obj->ID : (is_array($post_obj) && isset($post_obj['id']) ? $post_obj['id'] : 0);
                return $id ? update_post_meta($id, $field, sanitize_text_field($value)) : false;
            },
        ));
    }
}
add_action('rest_api_init', 'ai_directory_register_rest_fields');

// Include CPTs in standard search
function ai_directory_include_cpts_in_search($query) {
    if (!is_admin() && is_object($query) && method_exists($query, 'is_main_query') && $query->is_main_query() && $query->is_search()) {
        $query->set('post_type', array('post', 'workflow', 'mcp_server'));
    }
}
add_action('pre_get_posts', 'ai_directory_include_cpts_in_search');

/**
 * --------------------------------------------------------------------------
 * 5. CORE SPEED & CLEANUP TUNING
 * --------------------------------------------------------------------------
 */
function ai_directory_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'ai_directory_disable_emojis');

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
add_filter('xmlrpc_enabled', '__return_false');

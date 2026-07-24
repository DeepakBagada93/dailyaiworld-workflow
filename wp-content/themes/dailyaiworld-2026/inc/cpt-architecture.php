<?php
/**
 * Custom Post Types, Taxonomies, ACF Field Definitions & REST API Extensions
 *
 * @package DailyAIWorld2026
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * --------------------------------------------------------------------------
 * 1. REGISTER CUSTOM POST TYPES (CPT UI Code Export Compatible)
 * --------------------------------------------------------------------------
 */
function dailyaiworld_register_cpts() {

    // 1A. Workflow Post Type
    $labels_workflow = array(
        'name'                  => _x('Workflows', 'Post Type General Name', 'dailyaiworld-2026'),
        'singular_name'         => _x('Workflow', 'Post Type Singular Name', 'dailyaiworld-2026'),
        'menu_name'             => __('Workflows', 'dailyaiworld-2026'),
        'name_admin_bar'        => __('Workflow', 'dailyaiworld-2026'),
        'archives'              => __('Workflow Archives', 'dailyaiworld-2026'),
        'attributes'            => __('Workflow Attributes', 'dailyaiworld-2026'),
        'parent_item_colon'     => __('Parent Workflow:', 'dailyaiworld-2026'),
        'all_items'             => __('All Workflows', 'dailyaiworld-2026'),
        'add_new_item'          => __('Add New Workflow', 'dailyaiworld-2026'),
        'add_new'               => __('Add New', 'dailyaiworld-2026'),
        'new_item'              => __('New Workflow', 'dailyaiworld-2026'),
        'edit_item'             => __('Edit Workflow', 'dailyaiworld-2026'),
        'update_item'           => __('Update Workflow', 'dailyaiworld-2026'),
        'view_item'             => __('View Workflow', 'dailyaiworld-2026'),
        'view_items'            => __('View Workflows', 'dailyaiworld-2026'),
        'search_items'          => __('Search Workflow', 'dailyaiworld-2026'),
        'not_found'             => __('Not found', 'dailyaiworld-2026'),
        'not_found_in_trash'    => __('Not found in Trash', 'dailyaiworld-2026'),
    );

    $args_workflow = array(
        'label'                 => __('Workflow', 'dailyaiworld-2026'),
        'labels'                => $labels_workflow,
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'author'),
        'taxonomies'            => array('workflow-type', 'tech-stack', 'year'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-networking',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'workflows',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Exposes CPT to Gutenberg & REST API
        'rest_base'             => 'workflows',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
    register_post_type('workflow', $args_workflow);

    // 1B. MCP Server Post Type
    $labels_mcp = array(
        'name'                  => _x('MCP Servers', 'Post Type General Name', 'dailyaiworld-2026'),
        'singular_name'         => _x('MCP Server', 'Post Type Singular Name', 'dailyaiworld-2026'),
        'menu_name'             => __('MCP Registry', 'dailyaiworld-2026'),
        'name_admin_bar'        => __('MCP Server', 'dailyaiworld-2026'),
        'all_items'             => __('All MCP Servers', 'dailyaiworld-2026'),
        'add_new_item'          => __('Add New MCP Server', 'dailyaiworld-2026'),
        'add_new'               => __('Add New', 'dailyaiworld-2026'),
        'edit_item'             => __('Edit MCP Server', 'dailyaiworld-2026'),
        'view_item'             => __('View MCP Server', 'dailyaiworld-2026'),
        'search_items'          => __('Search MCP Servers', 'dailyaiworld-2026'),
    );

    $args_mcp = array(
        'label'                 => __('MCP Server', 'dailyaiworld-2026'),
        'labels'                => $labels_mcp,
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'author'),
        'taxonomies'            => array('tech-stack', 'year'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-server',
        'has_archive'           => 'mcp-servers',
        'show_in_rest'          => true,
        'rest_base'             => 'mcp-servers',
    );
    register_post_type('mcp_server', $args_mcp);
}
add_action('init', 'dailyaiworld_register_cpts', 0);

/**
 * --------------------------------------------------------------------------
 * 2. REGISTER CUSTOM TAXONOMIES
 * --------------------------------------------------------------------------
 */
function dailyaiworld_register_taxonomies() {

    // 2A. Taxonomy: workflow-type
    register_taxonomy('workflow-type', array('workflow'), array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'              => _x('Workflow Types', 'taxonomy general name', 'dailyaiworld-2026'),
            'singular_name'     => _x('Workflow Type', 'taxonomy singular name', 'dailyaiworld-2026'),
            'search_items'      => __('Search Workflow Types', 'dailyaiworld-2026'),
            'all_items'         => __('All Workflow Types', 'dailyaiworld-2026'),
            'edit_item'         => __('Edit Workflow Type', 'dailyaiworld-2026'),
            'add_new_item'      => __('Add New Workflow Type', 'dailyaiworld-2026'),
            'menu_name'         => __('Workflow Types', 'dailyaiworld-2026'),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'workflow-type'),
        'show_in_rest'      => true,
    ));

    // 2B. Taxonomy: tech-stack
    register_taxonomy('tech-stack', array('workflow', 'mcp_server'), array(
        'hierarchical'      => false,
        'labels'            => array(
            'name'              => _x('Tech Stacks', 'taxonomy general name', 'dailyaiworld-2026'),
            'singular_name'     => _x('Tech Stack', 'taxonomy singular name', 'dailyaiworld-2026'),
            'search_items'      => __('Search Tech Stacks', 'dailyaiworld-2026'),
            'all_items'         => __('All Tech Stacks', 'dailyaiworld-2026'),
            'edit_item'         => __('Edit Tech Stack', 'dailyaiworld-2026'),
            'add_new_item'      => __('Add New Tech Stack', 'dailyaiworld-2026'),
            'menu_name'         => __('Tech Stacks', 'dailyaiworld-2026'),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tech-stack'),
        'show_in_rest'      => true,
    ));

    // 2C. Taxonomy: year
    register_taxonomy('year', array('workflow', 'mcp_server'), array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'              => _x('Years', 'taxonomy general name', 'dailyaiworld-2026'),
            'singular_name'     => _x('Year', 'taxonomy singular name', 'dailyaiworld-2026'),
            'search_items'      => __('Search Years', 'dailyaiworld-2026'),
            'all_items'         => __('All Years', 'dailyaiworld-2026'),
            'edit_item'         => __('Edit Year', 'dailyaiworld-2026'),
            'add_new_item'      => __('Add New Year', 'dailyaiworld-2026'),
            'menu_name'         => __('Years', 'dailyaiworld-2026'),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'year'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'dailyaiworld_register_taxonomies', 0);

/**
 * --------------------------------------------------------------------------
 * 3. ADVANCED CUSTOM FIELDS (ACF FREE CODE DEFINITIONS)
 * --------------------------------------------------------------------------
 */
function dailyaiworld_register_acf_field_groups() {
    if (function_exists('acf_add_local_field_group')) {

        acf_add_local_field_group(array(
            'key' => 'group_ai_workflow_meta_2026',
            'title' => 'AI Workflow Metadata 2026',
            'fields' => array(
                array(
                    'key' => 'field_short_description',
                    'label' => 'Short Description',
                    'name' => 'short_description',
                    'type' => 'textarea',
                    'rows' => 3,
                    'required' => 1,
                ),
                array(
                    'key' => 'field_github_link',
                    'label' => 'GitHub Repository URL',
                    'name' => 'github_link',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_demo_url',
                    'label' => 'Live Demo / Video URL',
                    'name' => 'demo_url',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_tech_stack_text',
                    'label' => 'Tech Stack List (Comma Separated)',
                    'name' => 'tech_stack_text',
                    'type' => 'text',
                    'placeholder' => 'n8n, Claude 3.5, Python, LangChain',
                ),
                array(
                    'key' => 'field_difficulty',
                    'label' => 'Difficulty Level',
                    'name' => 'difficulty',
                    'type' => 'select',
                    'choices' => array(
                        'Beginner' => 'Beginner',
                        'Intermediate' => 'Intermediate',
                        'Advanced' => 'Advanced',
                        'Expert' => 'Expert',
                    ),
                    'default_value' => 'Intermediate',
                ),
                array(
                    'key' => 'field_status',
                    'label' => 'Project Status',
                    'name' => 'status',
                    'type' => 'select',
                    'choices' => array(
                        'Active' => 'Active',
                        'Beta' => 'Beta',
                        'Deprecated' => 'Deprecated',
                    ),
                    'default_value' => 'Active',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'workflow',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'mcp_server',
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'dailyaiworld_register_acf_field_groups');

/**
 * --------------------------------------------------------------------------
 * 4. EXPOSE ACF METADATA TO REST API (/wp-json/wp/v2/workflows)
 * --------------------------------------------------------------------------
 */
function dailyaiworld_register_rest_fields() {
    $fields = array('short_description', 'github_link', 'demo_url', 'tech_stack_text', 'difficulty', 'status');

    foreach ($fields as $field) {
        register_rest_field(array('workflow', 'mcp_server'), $field, array(
            'get_callback' => function($post_arr) use ($field) {
                return get_post_meta($post_arr['id'], $field, true);
            },
            'update_callback' => function($value, $post_obj) use ($field) {
                return update_post_meta($post_obj->ID, $field, sanitize_text_field($value));
            },
            'schema' => array(
                'type' => 'string',
                'description' => 'Custom meta field ' . $field,
                'context' => array('view', 'edit'),
            ),
        ));
    }
}
add_action('rest_api_init', 'dailyaiworld_register_rest_fields');

/**
 * --------------------------------------------------------------------------
 * 5. NATIVE SEARCH & RANK MATH INTEGRATION
 * --------------------------------------------------------------------------
 */
function dailyaiworld_include_cpts_in_search($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('post_type', array('post', 'workflow', 'mcp_server'));
    }
}
add_action('pre_get_posts', 'dailyaiworld_include_cpts_in_search');

<?php
/**
 * AI Directory Dark Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

function ai_directory_dark_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ai-directory-dark'),
    ));
}
add_action('after_setup_theme', 'ai_directory_dark_setup');

/**
 * Enqueue scripts and styles
 */
function ai_directory_dark_scripts() {
    wp_enqueue_style('ai-directory-style', get_stylesheet_uri(), array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'ai_directory_dark_scripts');

/**
 * Defer non-critical JavaScript execution for max performance & score
 */
function ai_directory_defer_scripts($tag, $handle, $src) {
    // Avoid deferring admin scripts or essential inline scripts
    if (is_admin()) {
        return $tag;
    }
    return str_replace(' src', ' defer="defer" src', $tag);
}
add_filter('script_loader_tag', 'ai_directory_defer_scripts', 10, 3);

/**
 * Copy to Clipboard Inline JS Helper
 */
function ai_directory_copy_script() {
    if (is_singular(array('workflow', 'mcp_server'))) :
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.copy-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetId = this.getAttribute('data-target');
                var targetEl = document.getElementById(targetId);
                if (targetEl) {
                    var textToCopy = targetEl.innerText || targetEl.textContent;
                    navigator.clipboard.writeText(textToCopy).then(function() {
                        var orig = btn.innerText;
                        btn.innerText = 'Copied!';
                        setTimeout(function() { btn.innerText = orig; }, 2000);
                    });
                }
            });
        });
    });
    </script>
    <?php
    endif;
}
add_action('wp_footer', 'ai_directory_copy_script');

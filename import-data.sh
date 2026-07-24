#!/usr/bin/env bash
# ==============================================================================
# SAMPLE DATA IMPORT SCRIPT FOR DAILY AI WORLD 2026 (WP-CLI + JSON)
# ==============================================================================

set -e

echo "🚀 Starting Sample Data Import into WordPress via WP-CLI..."

# Check WP-CLI
if ! command -v wp &> /dev/null; then
    echo "❌ Error: WP-CLI is required to run this import script."
    exit 1
fi

JSON_FILE="sample-data.json"

if [ ! -f "$JSON_FILE" ]; then
    echo "❌ Error: $JSON_FILE not found in current directory."
    exit 1
fi

echo "📦 Parsing $JSON_FILE and inserting Custom Post Types..."

# Use WP-CLI eval-file or php runner to process JSON cleanly
wp eval '
$json_path = "sample-data.json";
if (!file_exists($json_path)) {
    WP_CLI::error("JSON file missing!");
}
$items = json_decode(file_get_contents($json_path), true);

foreach ($items as $item) {
    // Check if post exists
    $existing = get_page_by_title($item["post_title"], OBJECT, $item["post_type"]);
    
    if ($existing) {
        $post_id = $existing->ID;
        WP_CLI::log("Updating existing post: {$item["post_title"]} (ID: $post_id)");
    } else {
        $post_id = wp_insert_post(array(
            "post_title"   => $item["post_title"],
            "post_content" => $item["post_content"],
            "post_excerpt" => $item["short_description"],
            "post_type"    => $item["post_type"],
            "post_status"  => "publish",
        ));
        WP_CLI::success("Created post: {$item["post_title"]} (ID: $post_id)");
    }

    if ($post_id && !is_wp_error($post_id)) {
        // Update Custom Meta Fields (ACF Compatible)
        update_post_meta($post_id, "short_description", $item["short_description"]);
        update_post_meta($post_id, "github_link", $item["github_link"]);
        update_post_meta($post_id, "demo_url", $item["demo_url"]);
        update_post_meta($post_id, "tech_stack_text", $item["tech_stack_text"]);
        update_post_meta($post_id, "difficulty", $item["difficulty"]);
        update_post_meta($post_id, "status", $item["status"]);

        // Set Taxonomies
        if (!empty($item["workflow_type"])) {
            wp_set_object_terms($post_id, $item["workflow_type"], "workflow-type", false);
        }
        if (!empty($item["tech_stack"])) {
            wp_set_object_terms($post_id, $item["tech_stack"], "tech-stack", false);
        }
        if (!empty($item["year"])) {
            wp_set_object_terms($post_id, $item["year"], "year", false);
        }
    }
}
wp_cache_flush();
WP_CLI::success("All sample data imported successfully!");
'

echo "✅ Import process finished!"

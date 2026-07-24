#!/usr/bin/env bash
# ==============================================================================
# WP-CLI AUTOMATED SETUP SCRIPT FOR DAILY AI WORLD 2026 ON HOSTINGER
# ==============================================================================

set -e

echo "🚀 Starting Automated Setup for Daily AI World 2026 (AI Workflow & MCP Registry)..."

# Check if WP-CLI is installed
if ! command -v wp &> /dev/null; then
    echo "❌ Error: WP-CLI is not installed or not in PATH."
    echo "👉 On Hostinger SSH, WP-CLI is available via 'wp'."
    exit 1
fi

echo "📦 Installing Essential 100% Free Plugins from WordPress.org..."

PLUGINS=(
    "litespeed-cache"
    "query-monitor"
    "autoptimize"
    "wp-smushit"
    "seo-by-rank-math"
    "custom-post-type-ui"
    "advanced-custom-fields"
    "redis-cache"
    "classic-editor"
)

for plugin in "${PLUGINS[@]}"; do
    echo "  -> Installing & Activating: $plugin"
    wp plugin install "$plugin" --activate || echo "⚠️ Warning: Failed to install/activate $plugin"
done

echo "🎨 Activating dailyaiworld-2026 Theme..."
wp theme activate dailyaiworld-2026 || echo "⚠️ Theme activate warning"

echo "🔗 Setting Permalinks to /%postname%/..."
wp rewrite structure '/%postname%/' --hard
wp rewrite flush --hard

echo "📄 Creating Core User-Facing Pages & Templates..."

# Create Explore Page
EXPLORE_ID=$(wp post create --post_type=page --post_title="Explore" --post_name="explore" --post_status=publish --porcelain)
if [ -n "$EXPLORE_ID" ]; then
    wp post meta update "$EXPLORE_ID" "_wp_page_template" "page-explore.php"
    echo "  -> Created Explore Page (ID: $EXPLORE_ID)"
fi

# Create Submit Page
SUBMIT_ID=$(wp post create --post_type=page --post_title="Submit Item" --post_name="submit" --post_status=publish --porcelain)
if [ -n "$SUBMIT_ID" ]; then
    wp post meta update "$SUBMIT_ID" "_wp_page_template" "page-submit.php"
    echo "  -> Created Submit Page (ID: $SUBMIT_ID)"
fi

# Create Blog Page
BLOG_ID=$(wp post create --post_type=page --post_title="Blog" --post_name="blog" --post_status=publish --porcelain)

# Set Homepage to Static Front Page
HOME_ID=$(wp post create --post_type=page --post_title="Home" --post_name="home-front" --post_status=publish --porcelain)
wp option update show_on_front "page"
wp option update page_on_front "$HOME_ID"
wp option update page_for_posts "$BLOG_ID"

echo "⚡ Configuring LiteSpeed Cache Presets..."
wp option update litespeed-cache-option-cache_priv true || true
wp option update litespeed-cache-option-cache_comment true || true
wp option update litespeed-cache-option-cache_rest true || true
wp option update litespeed-cache-option-media_webp true || true
wp option update litespeed-cache-option-optm_css_min true || true
wp option update litespeed-cache-option-optm_js_min true || true
wp option update litespeed-cache-option-optm_js_defer true || true

echo "🔴 Enabling Redis Object Cache..."
wp redis enable || echo "ℹ️ Redis object cache notice (Ensure Redis is enabled in hPanel)"

echo "🏷️ Creating Demo Categories & Terms..."
wp term create workflow_category "Automation & Agents" --slug="automation-agents" || true
wp term create mcp_category "Database Connectors" --slug="database-connectors" || true
wp term create ai_model "Claude 3.5 Sonnet" --slug="claude-3-5-sonnet" || true

echo "🧹 Clearing All LiteSpeed & Object Caches..."
wp cache flush || true

echo "✅ Setup Complete! All user-facing pages, templates, and optimizations are active!"

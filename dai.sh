#!/usr/bin/env bash
# ==============================================================================
# DAI CLI - DAILY AI WORLD 2026 WORDPRESS MANAGEMENT TOOL
# Designed for Developers, Hostinger SSH, and AI Coding Agents (Agy, OpenCode, Cursor)
# ==============================================================================

set -e

# Configuration & Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

HOSTINGER_USER="${HOSTINGER_USER:-u123456789}"
HOSTINGER_HOST="${HOSTINGER_HOST:-your-domain.com}"
HOSTINGER_PORT="${HOSTINGER_PORT:-65002}"
HOSTINGER_PATH="${HOSTINGER_PATH:-~/public_html}"

# Print Header Banner
print_banner() {
    echo -e "${PURPLE}"
    echo "  ____    _    ___    ____ _     ___ "
    echo " |  _ \  / \  |_ _|  / ___| |   |_ _|"
    echo " | | | |/ _ \  | |  | |   | |    | | "
    echo " | |_| / ___ \ | |  | |___| |___ | | "
    echo " |____/_/   \_\___|  \____|_____|___|"
    echo -e "${CYAN} Daily AI World 2026 Management CLI v1.0${NC}\n"
}

# Usage / Help Documentation
show_help() {
    print_banner
    echo -e "${YELLOW}Usage:${NC} ./dai.sh [command] [options]\n"
    echo -e "${CYAN}Available Commands:${NC}"
    echo -e "  ${GREEN}setup${NC}                     Run full automated installation (Plugins, Theme, Permalinks, Pages, LiteSpeed, Redis)"
    echo -e "  ${GREEN}new-workflow \"Title\"${NC}      Create a new AI Workflow post with meta & taxonomy flags"
    echo -e "  ${GREEN}new-mcp \"Title\"${NC}           Create a new MCP Server post with install command & config JSON"
    echo -e "  ${GREEN}optimize${NC}                  Optimize database tables, purge LiteSpeed/Redis caches, flush rewrite rules"
    echo -e "  ${GREEN}import-samples${NC}            Import sample JSON dataset (sample-data.json) into WordPress CPTs"
    echo -e "  ${GREEN}backup${NC}                    Export database (.sql) and compress wp-content/ into ./backups/"
    echo -e "  ${GREEN}deploy${NC}                    Deploy code to Hostinger server via rsync over SSH"
    echo -e "  ${GREEN}help${NC}                      Show this help menu\n"
    echo -e "${YELLOW}Examples:${NC}"
    echo "  ./dai.sh setup"
    echo "  ./dai.sh new-workflow \"Autonomous GitHub PR Reviewer\" --desc=\"AI code reviewer\" --tech=\"n8n,Claude 3.5\""
    echo "  ./dai.sh optimize"
    echo "  ./dai.sh deploy"
}

# Check WP-CLI Availability
check_wp_cli() {
    if ! command -v wp &> /dev/null; then
        echo -e "${RED}❌ Error: WP-CLI ('wp') is not installed or not in your PATH.${NC}"
        echo "Please install WP-CLI: https://wp-cli.org/#installing"
        exit 1
    fi
}

# 1. SETUP COMMAND
cmd_setup() {
    check_wp_cli
    print_banner
    echo -e "${GREEN}🚀 Running Full Automated WordPress Setup...${NC}\n"

    # Install & Activate Plugins
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
        echo -e "  -> Installing & Activating Plugin: ${CYAN}$plugin${NC}"
        wp plugin install "$plugin" --activate || echo -e "${YELLOW}⚠️ Notice: Plugin $plugin install skipped/active${NC}"
    done

    # Activate Theme
    echo -e "\n🎨 Activating ${PURPLE}dailyaiworld-2026${NC} Theme..."
    wp theme activate dailyaiworld-2026 || echo -e "${YELLOW}⚠️ Theme activate warning${NC}"

    # Setup Permalinks
    echo -e "\n🔗 Configuring Permalinks to /%postname%/..."
    wp rewrite structure '/%postname%/' --hard
    wp rewrite flush --hard

    # Create Core Pages
    echo -e "\n📄 Creating Core Pages (Explore, Submit, Blog)..."
    EXPLORE_ID=$(wp post create --post_type=page --post_title="Explore" --post_name="explore" --post_status=publish --porcelain)
    if [ -n "$EXPLORE_ID" ]; then
        wp post meta update "$EXPLORE_ID" "_wp_page_template" "page-explore.php"
    fi

    SUBMIT_ID=$(wp post create --post_type=page --post_title="Submit Item" --post_name="submit" --post_status=publish --porcelain)
    if [ -n "$SUBMIT_ID" ]; then
        wp post meta update "$SUBMIT_ID" "_wp_page_template" "page-submit.php"
    fi

    BLOG_ID=$(wp post create --post_type=page --post_title="Blog" --post_name="blog" --post_status=publish --porcelain)
    HOME_ID=$(wp post create --post_type=page --post_title="Home" --post_name="home-front" --post_status=publish --porcelain)

    wp option update show_on_front "page"
    wp option update page_on_front "$HOME_ID"
    wp option update page_for_posts "$BLOG_ID"

    # Configure LiteSpeed & Redis Caches
    echo -e "\n⚡ Tuning LiteSpeed Cache Settings..."
    wp option update litespeed-cache-option-cache_priv true || true
    wp option update litespeed-cache-option-cache_rest true || true
    wp option update litespeed-cache-option-media_webp true || true
    wp option update litespeed-cache-option-optm_css_min true || true
    wp option update litespeed-cache-option-optm_js_min true || true
    wp option update litespeed-cache-option-optm_js_defer true || true

    echo -e "\n🔴 Enabling Redis Object Cache..."
    wp redis enable || true

    # Flush Caches
    wp cache flush || true

    echo -e "\n${GREEN}✅ Setup Complete! Your high-speed WordPress site is fully operational.${NC}"
}

# 2. NEW WORKFLOW COMMAND
cmd_new_workflow() {
    check_wp_cli
    TITLE="$1"
    if [ -z "$TITLE" ]; then
        echo -e "${RED}❌ Error: Title is required.${NC}"
        echo "Usage: ./dai.sh new-workflow \"Workflow Title\" [options]"
        exit 1
    fi

    DESC=""
    GITHUB=""
    DEMO=""
    TECH=""
    DIFFICULTY="Intermediate"
    STATUS="Active"

    shift 1
    while [[ $# -gt 0 ]]; do
        case $1 in
            --desc=*) DESC="${1#*=}" ;;
            --github=*) GITHUB="${1#*=}" ;;
            --demo=*) DEMO="${1#*=}" ;;
            --tech=*) TECH="${1#*=}" ;;
            --difficulty=*) DIFFICULTY="${1#*=}" ;;
            --status=*) STATUS="${1#*=}" ;;
        esac
        shift
    done

    echo -e "${GREEN}⚡ Creating New Workflow:${NC} $TITLE"

    POST_ID=$(wp post create --post_type=workflow --post_title="$TITLE" --post_status=publish --porcelain)

    if [ -n "$POST_ID" ]; then
        [ -n "$DESC" ] && wp post meta update "$POST_ID" "short_description" "$DESC"
        [ -n "$GITHUB" ] && wp post meta update "$POST_ID" "github_link" "$GITHUB"
        [ -n "$DEMO" ] && wp post meta update "$POST_ID" "demo_url" "$DEMO"
        [ -n "$TECH" ] && wp post meta update "$POST_ID" "tech_stack_text" "$TECH"
        wp post meta update "$POST_ID" "difficulty" "$DIFFICULTY"
        wp post meta update "$POST_ID" "status" "$STATUS"

        echo -e "${GREEN}✅ Workflow Created Successfully!${NC} Post ID: ${CYAN}$POST_ID${NC}"
        echo "Rest Endpoint: /wp-json/wp/v2/workflows/$POST_ID"
    else
        echo -e "${RED}❌ Failed to create post.${NC}"
    fi
}

# 3. NEW MCP SERVER COMMAND
cmd_new_mcp() {
    check_wp_cli
    TITLE="$1"
    if [ -z "$TITLE" ]; then
        echo -e "${RED}❌ Error: Title is required.${NC}"
        echo "Usage: ./dai.sh new-mcp \"MCP Server Title\" [options]"
        exit 1
    fi

    DESC=""
    GITHUB=""
    TECH=""
    DIFFICULTY="Beginner"

    shift 1
    while [[ $# -gt 0 ]]; do
        case $1 in
            --desc=*) DESC="${1#*=}" ;;
            --github=*) GITHUB="${1#*=}" ;;
            --tech=*) TECH="${1#*=}" ;;
            --difficulty=*) DIFFICULTY="${1#*=}" ;;
        esac
        shift
    done

    echo -e "${GREEN}🔌 Creating New MCP Server:${NC} $TITLE"

    POST_ID=$(wp post create --post_type=mcp_server --post_title="$TITLE" --post_status=publish --porcelain)

    if [ -n "$POST_ID" ]; then
        [ -n "$DESC" ] && wp post meta update "$POST_ID" "short_description" "$DESC"
        [ -n "$GITHUB" ] && wp post meta update "$POST_ID" "github_link" "$GITHUB"
        [ -n "$TECH" ] && wp post meta update "$POST_ID" "tech_stack_text" "$TECH"
        wp post meta update "$POST_ID" "difficulty" "$DIFFICULTY"
        wp post meta update "$POST_ID" "status" "Active"

        echo -e "${GREEN}✅ MCP Server Registered Successfully!${NC} Post ID: ${CYAN}$POST_ID${NC}"
    fi
}

# 4. OPTIMIZE COMMAND
cmd_optimize() {
    check_wp_cli
    print_banner
    echo -e "${GREEN}🧹 Running Performance Optimization & Maintenance...${NC}\n"

    echo -e "  -> Optimizing MySQL Database Tables..."
    wp db optimize || echo -e "${YELLOW}⚠️ DB optimize notice${NC}"

    echo -e "  -> Cleaning Transient Caches & Expired Data..."
    wp transient delete --all || true

    echo -e "  -> Purging LiteSpeed Page Cache & Object Cache..."
    wp cache flush || true

    echo -e "  -> Regenerating & Flushing Rewrite Rules..."
    wp rewrite flush --hard

    echo -e "\n${GREEN}✅ Site Optimization Complete! TTFB & database queries optimized.${NC}"
}

# 5. IMPORT SAMPLES COMMAND
cmd_import_samples() {
    check_wp_cli
    if [ ! -f "import-data.sh" ]; then
        echo -e "${RED}❌ Error: import-data.sh script missing.${NC}"
        exit 1
    fi
    echo -e "${GREEN}📦 Importing Sample Data...${NC}"
    ./import-data.sh
}

# 6. BACKUP COMMAND
cmd_backup() {
    check_wp_cli
    print_banner
    mkdir -p ./backups
    TIMESTAMP=$(date +%Y%m%d_%H%M%S)
    DB_FILE="./backups/db_backup_${TIMESTAMP}.sql"
    FILES_ARCHIVE="./backups/wp_content_${TIMESTAMP}.tar.gz"

    echo -e "${GREEN}💾 Starting Backup...${NC}"

    echo -e "  -> Exporting Database to ${CYAN}${DB_FILE}${NC}..."
    wp db export "$DB_FILE"

    echo -e "  -> Archiving wp-content/ to ${CYAN}${FILES_ARCHIVE}${NC}..."
    tar -czf "$FILES_ARCHIVE" wp-content/

    echo -e "\n${GREEN}✅ Backup Created Successfully!${NC}"
    echo "  SQL Dump: $DB_FILE"
    echo "  Content Archive: $FILES_ARCHIVE"
}

# 7. DEPLOY COMMAND
cmd_deploy() {
    print_banner
    echo -e "${GREEN}🚀 Deploying Local Code to Hostinger (${HOSTINGER_HOST})...${NC}\n"

    echo -e "Target Server: ${CYAN}${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PORT}${NC}"
    echo -e "Remote Path: ${CYAN}${HOSTINGER_PATH}${NC}"

    rsync -avz -e "ssh -p ${HOSTINGER_PORT}" \
        --exclude='.git*' \
        --exclude='node_modules/' \
        --exclude='backups/' \
        --exclude='*.sql' \
        ./ "${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/"

    echo -e "\n${GREEN}✅ Deployment Finished! Purging Remote Cache...${NC}"
    ssh -p "${HOSTINGER_PORT}" "${HOSTINGER_USER}@${HOSTINGER_HOST}" "cd ${HOSTINGER_PATH} && wp cache flush" || true
    echo -e "${GREEN}✅ All remote caches purged. Site is live!${NC}"
}

# Main Command Controller
case "$1" in
    setup)
        cmd_setup
        ;;
    new-workflow)
        shift
        cmd_new_workflow "$@"
        ;;
    new-mcp)
        shift
        cmd_new_mcp "$@"
        ;;
    optimize)
        cmd_optimize
        ;;
    import-samples)
        cmd_import_samples
        ;;
    backup)
        cmd_backup
        ;;
    deploy)
        cmd_deploy
        ;;
    help|--help|-h|"")
        show_help
        ;;
    *)
        echo -e "${RED}❌ Unknown Command:${NC} $1"
        show_help
        exit 1
        ;;
esac

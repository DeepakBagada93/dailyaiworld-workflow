<?php
/**
 * Template Name: Explore Directory (Filterable)
 *
 * @package DailyAIWorld2026
 */

get_header();
?>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <!-- Page Hero Header -->
    <section class="hero-wrapper" style="padding: 40px 0 30px 0;">
        <span class="hero-pill">🔎 Interactive Directory Search</span>
        <h1 class="hero-title-main" style="font-size: clamp(2rem, 4vw, 3.2rem);">
            Explore AI Workflows & <span class="hero-title-gradient">MCP Registry</span>
        </h1>
        <p class="hero-desc" style="max-width: 640px;">
            Filter production-grade AI pipelines and MCP integrations by category, framework, or difficulty.
        </p>

        <!-- Search Bar & Filters -->
        <div style="max-width: 680px; margin: 30px auto 0 auto; display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="text" id="directorySearchInput" placeholder="Search by keyword, tool, or tech stack (e.g. n8n, Claude, SQLite)..." 
                   style="flex: 1; min-width: 280px; background: var(--bg-card); border: 1px solid var(--border-muted); color: #fff; padding: 14px 20px; border-radius: var(--radius-sm); font-size: 1rem; outline: none; transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='var(--accent-purple)';" onblur="this.style.borderColor='var(--border-muted)';" />
        </div>

        <!-- Category Filter Buttons -->
        <div style="display:flex; justify-content:center; gap:10px; margin-top: 20px; flex-wrap:wrap;" id="filterTabs">
            <button class="filter-btn active" data-filter="all">All Items</button>
            <button class="filter-btn" data-filter="workflow">⚡ Workflows</button>
            <button class="filter-btn" data-filter="mcp_server">🔌 MCP Servers</button>
        </div>
    </section>

    <!-- Filterable Directory Grid -->
    <section style="margin-top: 40px;">
        <div class="grid-3-col" id="directoryGrid">
            <?php
            $explore_query = new WP_Query(array(
                'post_type'      => array('workflow', 'mcp_server'),
                'posts_per_page' => 12,
                'post_status'    => 'publish',
            ));

            if ($explore_query->have_posts()) :
                while ($explore_query->have_posts()) : $explore_query->the_post();
                    $post_type  = get_post_type();
                    $short_desc = get_post_meta(get_the_ID(), 'short_description', true) ?: get_the_excerpt();
                    $difficulty = get_post_meta(get_the_ID(), 'difficulty', true) ?: 'Intermediate';
                    $badge_cls  = ($post_type === 'mcp_server') ? 'badge-mcp' : 'badge-workflow';
                    $badge_lbl  = ($post_type === 'mcp_server') ? 'MCP Server' : 'Workflow';
                    ?>
                    <article class="card-item directory-item" data-type="<?php echo esc_attr($post_type); ?>" data-title="<?php echo esc_attr(strtolower(get_the_title() . ' ' . $short_desc)); ?>">
                        <div class="card-top">
                            <span class="tag-badge <?php echo esc_attr($badge_cls); ?>"><?php echo esc_html($badge_lbl); ?></span>
                            <span style="font-size: 0.8rem; color: var(--text-muted);"><?php echo esc_html($difficulty); ?></span>
                        </div>
                        <h3 class="card-item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="card-excerpt">
                            <p><?php echo wp_trim_words($short_desc, 20); ?></p>
                        </div>
                        <div class="card-bottom-meta">
                            <span>Status: Active</span>
                            <a href="<?php the_permalink(); ?>" style="font-weight: 600;">View Details &rarr;</a>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="color: var(--text-muted); text-align:center; grid-column: 1/-1;">No items found matching criteria.</p>';
            endif;
            ?>
        </div>
    </section>
</main>

<style>
.filter-btn {
    background: var(--bg-card);
    border: 1px solid var(--border-muted);
    color: var(--text-secondary);
    padding: 8px 18px;
    border-radius: 9999px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.filter-btn:hover, .filter-btn.active {
    background: var(--accent-purple-light);
    color: var(--accent-purple);
    border-color: var(--border-active);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('directorySearchInput');
    var filterTabs = document.querySelectorAll('#filterTabs .filter-btn');
    var items = document.querySelectorAll('.directory-item');
    var currentFilter = 'all';

    function filterDirectory() {
        var query = searchInput ? searchInput.value.toLowerCase().trim() : '';

        items.forEach(function(item) {
            var itemType = item.getAttribute('data-type');
            var itemText = item.getAttribute('data-title');

            var matchesType = (currentFilter === 'all' || itemType === currentFilter);
            var matchesQuery = (!query || itemText.indexOf(query) !== -1);

            if (matchesType && matchesQuery) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterDirectory);
    }

    filterTabs.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterTabs.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            filterDirectory();
        });
    });
});
</script>

<?php get_footer(); ?>

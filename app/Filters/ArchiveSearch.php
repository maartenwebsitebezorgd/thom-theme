<?php

namespace App\Filters;

class ArchiveSearch
{
    public function __construct()
    {
        // Register AJAX handlers for both logged-in and logged-out users
        add_action('wp_ajax_archive_filter_search', [$this, 'handleSearch']);
        add_action('wp_ajax_nopriv_archive_filter_search', [$this, 'handleSearch']);

        // Extend WordPress search to include taxonomy terms
        add_filter('posts_search', [$this, 'extendSearch'], 10, 2);
        add_filter('posts_join', [$this, 'searchJoin'], 10, 2);
        add_filter('posts_groupby', [$this, 'searchGroupBy'], 10, 2);
    }

    /**
     * Handle AJAX search request
     */
    public function handleSearch()
    {
        try {
            // Verify nonce
            check_ajax_referer('sage_filters_nonce', 'nonce');

            // Get search parameters
            $search = sanitize_text_field($_POST['search'] ?? '');
            $postType = sanitize_text_field($_POST['post_type'] ?? 'post');
            $paged = intval($_POST['paged'] ?? 1);
            $taxonomy = sanitize_text_field($_POST['taxonomy'] ?? '');
            $termId = intval($_POST['term_id'] ?? 0);

        // Build query args
        $args = [
            'post_type' => $postType,
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            's' => $search,
        ];

        // Add taxonomy filter if provided
        if ($taxonomy && $termId) {
            $args['tax_query'] = [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $termId,
                ],
            ];
        }

        // Perform the query
        $query = new \WP_Query($args);

        // Get the HTML output
        ob_start();

        if ($query->have_posts()) {
            // Get settings from theme options with ACF fallback
            $gridColumnsDesktop = function_exists('get_field') ? (get_field('grid_columns_desktop', 'option') ?? 'grid-cols-3') : 'grid-cols-3';
            $gridColumnsTablet = function_exists('get_field') ? (get_field('grid_columns_tablet', 'option') ?? 'grid-cols-2') : 'grid-cols-2';
            $gridColumnsMobile = function_exists('get_field') ? (get_field('grid_columns_mobile', 'option') ?? 'grid-cols-1') : 'grid-cols-1';
            $gapSize = function_exists('get_field') ? (get_field('gap_size', 'option') ?? 'gap-u-6') : 'gap-u-6';

            echo '<div class="grid ' . esc_attr($gridColumnsMobile) . ' md:' . esc_attr($gridColumnsTablet) . ' lg:' . esc_attr($gridColumnsDesktop) . ' ' . esc_attr($gapSize) . '">';

            while ($query->have_posts()) {
                $query->the_post();

                // Get the appropriate content template for the post type
                $currentPostType = get_post_type();
                $template = 'partials.content-' . $currentPostType;

                // Check if specific template exists, otherwise use default
                try {
                    echo \Roots\view($template)->render();
                } catch (\Exception $e) {
                    // Fallback to generic content template
                    error_log("Template not found: {$template}, using partials.content");
                    echo \Roots\view('partials.content')->render();
                }
            }

            echo '</div>';

            // Pagination
            if ($query->max_num_pages > 1) {
                echo '<div class="mt-section-main flex justify-between gap-u-4">';

                if (get_previous_posts_link('', $query->max_num_pages)) {
                    echo '<div>' . get_previous_posts_link(__('&larr; Newer Posts', 'sage')) . '</div>';
                }

                if (get_next_posts_link('', $query->max_num_pages)) {
                    echo '<div>' . get_next_posts_link(__('Older Posts &rarr;', 'sage'), $query->max_num_pages) . '</div>';
                }

                echo '</div>';
            }
        } else {
            echo '<div class="u-max-width-70ch mx-auto text-center">';
            echo '<p class="u-text-style-medium mb-u-6">';

            if (!empty($search)) {
                echo sprintf(__('No results found for "%s". Please try a different search.', 'sage'), esc_html($search));
            } else {
                echo __('No posts found.', 'sage');
            }

            echo '</p>';
            echo '</div>';
        }

            $html = ob_get_clean();

            // Reset post data
            wp_reset_postdata();

            // Send response
            wp_send_json_success([
                'html' => $html,
                'found_posts' => $query->found_posts,
                'max_pages' => $query->max_num_pages,
            ]);
        } catch (\Exception $e) {
            // Log the error
            error_log('Archive Search Error: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());

            // Send error response
            wp_send_json_error([
                'message' => 'Search failed: ' . $e->getMessage(),
                'trace' => WP_DEBUG ? $e->getTraceAsString() : null,
            ]);
        }
    }

    /**
     * Extend WordPress search to include taxonomy terms (categories/tags)
     */
    public function extendSearch($search, $query)
    {
        global $wpdb;

        // Only modify main query search
        if (empty($search) || !$query->is_search() || !$query->is_main_query()) {
            return $search;
        }

        // Get search term
        $searchTerm = $query->get('s');

        if (empty($searchTerm)) {
            return $search;
        }

        // Add taxonomy term search
        $search .= " OR (
            t.name LIKE '%" . esc_sql($wpdb->esc_like($searchTerm)) . "%'
            OR t.slug LIKE '%" . esc_sql($wpdb->esc_like($searchTerm)) . "%'
        )";

        return $search;
    }

    /**
     * Join taxonomy tables for search
     */
    public function searchJoin($join, $query)
    {
        global $wpdb;

        // Only modify main query search
        if (!$query->is_search() || !$query->is_main_query()) {
            return $join;
        }

        $searchTerm = $query->get('s');

        if (empty($searchTerm)) {
            return $join;
        }

        // Join term relationships and terms tables
        $join .= "
            LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id
            LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            LEFT JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
        ";

        return $join;
    }

    /**
     * Group results to avoid duplicates from taxonomy joins
     */
    public function searchGroupBy($groupby, $query)
    {
        global $wpdb;

        // Only modify main query search
        if (!$query->is_search() || !$query->is_main_query()) {
            return $groupby;
        }

        $searchTerm = $query->get('s');

        if (empty($searchTerm)) {
            return $groupby;
        }

        // Group by post ID to avoid duplicates
        $groupby = "{$wpdb->posts}.ID";

        return $groupby;
    }
}

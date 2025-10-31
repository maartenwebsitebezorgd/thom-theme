<?php

namespace App\Helpers;

/**
 * SEO Helper Class
 * Provides meta tags and SEO functionality
 */
class SEO
{
    /**
     * Get the page title for SEO
     */
    public static function getTitle(): string
    {
        if (is_front_page()) {
            return get_bloginfo('name') . ' - ' . get_bloginfo('description');
        }

        if (is_singular()) {
            return get_the_title() . ' - ' . get_bloginfo('name');
        }

        if (is_archive()) {
            return get_the_archive_title() . ' - ' . get_bloginfo('name');
        }

        if (is_search()) {
            return 'Search Results for: ' . get_search_query() . ' - ' . get_bloginfo('name');
        }

        if (is_404()) {
            return 'Page Not Found - ' . get_bloginfo('name');
        }

        return get_bloginfo('name');
    }

    /**
     * Get the meta description
     */
    public static function getDescription(): string
    {
        // Try to get custom description from ACF or Yoast
        if (function_exists('get_field')) {
            $description = get_field('meta_description');
            if ($description) {
                return wp_strip_all_tags($description);
            }
        }

        // For singular posts/pages
        if (is_singular()) {
            $post = get_post();
            if ($post->post_excerpt) {
                return wp_trim_words(wp_strip_all_tags($post->post_excerpt), 30);
            }
            if ($post->post_content) {
                return wp_trim_words(wp_strip_all_tags($post->post_content), 30);
            }
        }

        // For archives
        if (is_archive()) {
            $description = get_the_archive_description();
            if ($description) {
                return wp_trim_words(wp_strip_all_tags($description), 30);
            }
        }

        // Try default from theme options
        if (function_exists('get_field')) {
            $defaultDescription = get_field('default_meta_description', 'option');
            if ($defaultDescription) {
                return wp_strip_all_tags($defaultDescription);
            }
        }

        // Default site description
        return get_bloginfo('description');
    }

    /**
     * Get the canonical URL
     */
    public static function getCanonicalUrl(): string
    {
        if (is_singular()) {
            return get_permalink();
        }

        return home_url($_SERVER['REQUEST_URI'] ?? '/');
    }

    /**
     * Get the featured image URL for Open Graph
     */
    public static function getImageUrl(): ?string
    {
        if (is_singular() && has_post_thumbnail()) {
            return get_the_post_thumbnail_url(null, 'large');
        }

        // Try to get site logo
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            return $logo[0] ?? null;
        }

        // Try to get from ACF options
        if (function_exists('get_field')) {
            $defaultImage = get_field('default_share_image', 'option');
            if ($defaultImage && is_array($defaultImage)) {
                return $defaultImage['url'] ?? null;
            }
        }

        return null;
    }

    /**
     * Get Open Graph type
     */
    public static function getOgType(): string
    {
        if (is_singular('post')) {
            return 'article';
        }

        if (is_front_page() || is_home()) {
            return 'website';
        }

        return 'website';
    }

    /**
     * Get Twitter card type
     */
    public static function getTwitterCardType(): string
    {
        return has_post_thumbnail() ? 'summary_large_image' : 'summary';
    }

    /**
     * Output all SEO meta tags
     */
    public static function outputMetaTags(): void
    {
        $title = self::getTitle();
        $description = self::getDescription();
        $canonicalUrl = self::getCanonicalUrl();
        $imageUrl = self::getImageUrl();
        $ogType = self::getOgType();
        $twitterCard = self::getTwitterCardType();
        $siteName = get_bloginfo('name');

        // Don't output if SEO plugin is active
        if (self::hasSeoPlugin()) {
            return;
        }

        echo "<!-- SEO Meta Tags -->\n";
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url($canonicalUrl) . '">' . "\n";

        // Open Graph
        echo "\n<!-- Open Graph / Facebook -->\n";
        echo '<meta property="og:type" content="' . esc_attr($ogType) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($canonicalUrl) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($siteName) . '">' . "\n";

        if ($imageUrl) {
            echo '<meta property="og:image" content="' . esc_url($imageUrl) . '">' . "\n";
        }

        // Twitter Card
        echo "\n<!-- Twitter Card -->\n";
        echo '<meta name="twitter:card" content="' . esc_attr($twitterCard) . '">' . "\n";
        echo '<meta name="twitter:url" content="' . esc_url($canonicalUrl) . '">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";

        if ($imageUrl) {
            echo '<meta name="twitter:image" content="' . esc_url($imageUrl) . '">' . "\n";
        }

        // Get Twitter handle from options
        if (function_exists('get_field')) {
            $twitterHandle = get_field('twitter_handle', 'option');
            if ($twitterHandle) {
                // Ensure @ prefix
                $twitterHandle = ltrim($twitterHandle, '@');
                echo '<meta name="twitter:site" content="@' . esc_attr($twitterHandle) . '">' . "\n";
            }
        }

        // Article specific tags
        if (is_singular('post')) {
            echo "\n<!-- Article Meta -->\n";
            $publishedTime = get_the_date('c');
            $modifiedTime = get_the_modified_date('c');
            echo '<meta property="article:published_time" content="' . esc_attr($publishedTime) . '">' . "\n";
            echo '<meta property="article:modified_time" content="' . esc_attr($modifiedTime) . '">' . "\n";

            // Author
            $author = get_the_author();
            if ($author) {
                echo '<meta property="article:author" content="' . esc_attr($author) . '">' . "\n";
            }
        }

        echo "\n";
    }

    /**
     * Check if an SEO plugin is active
     */
    private static function hasSeoPlugin(): bool
    {
        // Check for Yoast SEO
        if (defined('WPSEO_VERSION')) {
            return true;
        }

        // Check for Rank Math
        if (defined('RANK_MATH_VERSION')) {
            return true;
        }

        // Check for All in One SEO
        if (defined('AIOSEO_VERSION')) {
            return true;
        }

        return false;
    }

    /**
     * Get robots meta content
     */
    public static function getRobotsContent(): string
    {
        // Check if page should be indexed
        $noindex = get_post_meta(get_the_ID(), '_yoast_wpseo_meta-robots-noindex', true);

        if ($noindex === '1' || is_404() || is_search()) {
            return 'noindex, nofollow';
        }

        return 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1';
    }
}

<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Allow SVG uploads in WordPress media library.
 *
 * @param array $mimes Allowed mime types
 * @return array
 */
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
});

/**
 * Fix SVG thumbnail display in media library.
 *
 * @param array $response Response data
 * @param WP_Post $attachment Attachment object
 * @return array
 */
add_filter('wp_prepare_attachment_for_js', function ($response, $attachment) {
    if ($response['mime'] === 'image/svg+xml' && empty($response['sizes'])) {
        $response['sizes'] = [
            'full' => [
                'url' => $response['url'],
                'width' => 'auto',
                'height' => 'auto',
                'orientation' => 'landscape',
            ],
        ];
    }
    return $response;
}, 10, 2);

/**
 * Enable SVG support in ACF image fields.
 */
add_filter('acf/format_value/type=image', function ($value) {
    if (!empty($value) && is_array($value) && isset($value['mime_type']) && $value['mime_type'] === 'image/svg+xml') {
        // Ensure SVG files have the correct data structure
        if (empty($value['sizes'])) {
            $value['sizes'] = [
                'thumbnail' => $value['url'],
                'medium' => $value['url'],
                'large' => $value['url'],
                'full' => $value['url'],
            ];
        }
    }
    return $value;
}, 10, 1);

/**
 * Customize blog category and tag base URLs.
 * Change 'blog' to 'artikel' (or any other slug) to update all blog URLs.
 *
 * Examples with current 'artikel' slug:
 * - Single posts: yoursite.com/artikel/post-name/
 * - Categories: yoursite.com/artikelen/web-development/
 * - Tags: yoursite.com/artikelen/tag/design/
 */
add_filter('category_rewrite_rules', function ($rules) {
    $blog_slug = 'artikelen';
    $new_rules = [];

    foreach ($rules as $key => $value) {
        // Replace the default category base with our custom slug
        $new_key = str_replace('category/', $blog_slug . '/', $key);
        $new_rules[$new_key] = $value;
    }

    return $new_rules;
});

add_filter('tag_rewrite_rules', function ($rules) {
    $blog_slug = 'artikelen';
    $new_rules = [];

    foreach ($rules as $key => $value) {
        // Replace the default tag base with our custom slug
        $new_key = str_replace('tag/', $blog_slug . '/tag/', $key);
        $new_rules[$new_key] = $value;
    }

    return $new_rules;
});

// Add custom rewrite rule for single posts with /artikel/ prefix
add_action('init', function () {
    global $wp_rewrite;

    $blog_slug = 'artikelen';
    $post_slug = 'artikel'; // Singular for single posts

    // Set category and tag base
    $wp_rewrite->category_base = $blog_slug;
    $wp_rewrite->tag_base = $blog_slug . '/tag';

    // Add rewrite rule for single posts with custom prefix
    add_rewrite_rule(
        '^' . $post_slug . '/([^/]+)/?$',
        'index.php?name=$matches[1]',
        'top'
    );
}, 5);

// Modify post permalinks to include /artikel/ prefix
add_filter('post_link', function ($permalink, $post) {
    if ($post->post_type === 'post' && $post->post_status === 'publish') {
        $post_slug = 'artikel';
        // Replace the site URL with site URL + /artikel/
        $permalink = home_url($post_slug . '/' . $post->post_name . '/');
    }
    return $permalink;
}, 10, 2);

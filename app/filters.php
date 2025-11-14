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

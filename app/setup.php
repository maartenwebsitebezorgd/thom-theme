<?php

/**
 * Theme setup.
 */

namespace App;

use App\Fields\PageBuilder;
use App\Fields\PostFields;
use App\Fields\ServicesOptions;
use App\Fields\TaxonomyFields;
use App\Filters\ArchiveSearch;
use App\PostTypes\Cases;
use App\PostTypes\Team;
use App\PostTypes\Videos;
use Illuminate\Support\Facades\Vite;

// Initialize ACF Fields
new PageBuilder();
new PostFields();
new ServicesOptions();
new TaxonomyFields();

// Initialize Post Types
new Cases();
new Team();
new Videos();

// Initialize Filters
new ArchiveSearch();

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Enable excerpt support for pages.
     *
     * @link https://developer.wordpress.org/reference/functions/add_post_type_support/
     */
    add_post_type_support('page', 'excerpt');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});

/**
 * Remove archive title prefix (e.g., "Category:", "Archive:", "Tag:")
 *
 * @return string
 */
add_filter('get_the_archive_title_prefix', function () {
    return '';
});

/**
 * Enqueue scripts and localize data for filters
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    // Only enqueue on archive pages
    if (!is_archive() && !is_home() && !is_post_type_archive()) {
        return;
    }

    // Enqueue the filters script
    $filtersAsset = Vite::asset('resources/js/filters.js');

    wp_enqueue_script(
        'sage/filters',
        $filtersAsset,
        [],
        null,
        true
    );

    // Localize script with AJAX URL and nonce
    wp_localize_script('sage/filters', 'sageData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sage_filters_nonce'),
        'homeUrl' => home_url('/'),
    ]);
});

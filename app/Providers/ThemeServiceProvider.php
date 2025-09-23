<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;
use App\Fields\PageBuilder;
use App\Fields\ThemeOptions;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();
        
        // Register field classes
        $this->app->singleton(PageBuilder::class);
        $this->app->singleton(ThemeOptions::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        
        // Boot field classes
        $this->app->make(PageBuilder::class);
        $this->app->make(ThemeOptions::class);
        
        // Add ACF theme settings
        $this->addAcfThemeSupport();
        
        // Disable ACF admin for production (optional)
        $this->disableAcfAdminForProduction();
    }

    /**
     * Add ACF theme support settings
     */
    private function addAcfThemeSupport(): void
    {
        // Save ACF fields to theme folder for version control
        add_filter('acf/settings/save_json', function ($path) {
            return get_stylesheet_directory() . '/acf-json';
        });

        // Load ACF fields from theme folder
        add_filter('acf/settings/load_json', function ($paths) {
            unset($paths[0]);
            $paths[] = get_stylesheet_directory() . '/acf-json';
            return $paths;
        });

        // Add theme support for ACF
        add_action('after_setup_theme', function () {
            add_theme_support('acf');
        });
    }

    /**
     * Disable ACF admin menu for non-developers in production
     * Uncomment this method if you want to hide ACF from clients
     */
    private function disableAcfAdminForProduction(): void
    {
        // Only show ACF admin for administrators in production
        if (defined('WP_ENV') && WP_ENV === 'production') {
            add_filter('acf/settings/show_admin', function ($show_admin) {
                return current_user_can('manage_options') ? $show_admin : false;
            });
        }
    }
}
<?php

namespace App\Fields;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ThemeOptions
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'addOptionsPage']);
        add_action('acf/init', [$this, 'addOptionsFields']);
    }

    public function addOptionsPage()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Theme Settings',
                'menu_title' => 'Theme Options',
                'menu_slug' => 'theme-settings',
                'capability' => 'edit_posts',
                'icon_url' => 'dashicons-admin-customizer',
                'position' => 30,
            ]);

            // Add sub-pages for organization
            acf_add_options_sub_page([
                'page_title' => 'Header Settings',
                'menu_title' => 'Header',
                'parent_slug' => 'theme-settings',
            ]);

            acf_add_options_sub_page([
                'page_title' => 'Footer Settings',
                'menu_title' => 'Footer',
                'parent_slug' => 'theme-settings',
            ]);

            acf_add_options_sub_page([
                'page_title' => 'Social Media',
                'menu_title' => 'Social',
                'parent_slug' => 'theme-settings',
            ]);
        }
    }

    public function addOptionsFields()
    {
        // Main Theme Settings
        $themeSettings = new FieldsBuilder('theme_settings');
        $themeSettings
            ->addTab('general', ['label' => 'General Settings'])
                ->addImage('site_logo', [
                    'label' => 'Site Logo',
                    'instructions' => 'Upload your site logo',
                    'return_format' => 'array'
                ])
                ->addImage('site_favicon', [
                    'label' => 'Site Favicon',
                    'instructions' => 'Upload a favicon (32x32px recommended)',
                    'return_format' => 'array'
                ])
                ->addColorPicker('primary_color', [
                    'label' => 'Primary Brand Color',
                    'default_value' => '#3b82f6'
                ])
                ->addColorPicker('secondary_color', [
                    'label' => 'Secondary Brand Color',
                    'default_value' => '#10b981'
                ])
            ->setLocation('options_page', '==', 'theme-settings');

        // Header Settings
        $headerSettings = new FieldsBuilder('header_settings');
        $headerSettings
            ->addTab('navigation', ['label' => 'Navigation'])
                ->addTrueFalse('show_search', [
                    'label' => 'Show Search in Header',
                    'default_value' => 0
                ])
                ->addTrueFalse('sticky_header', [
                    'label' => 'Sticky Header',
                    'default_value' => 1
                ])
                ->addSelect('header_style', [
                    'label' => 'Header Style',
                    'choices' => [
                        'simple' => 'Simple',
                        'centered' => 'Centered Logo',
                        'split' => 'Split Navigation'
                    ],
                    'default_value' => 'simple'
                ])
            ->addTab('contact', ['label' => 'Contact Info'])
                ->addText('phone', [
                    'label' => 'Phone Number'
                ])
                ->addEmail('email', [
                    'label' => 'Contact Email'
                ])
                ->addTextarea('address', [
                    'label' => 'Address',
                    'rows' => 3
                ])
            ->setLocation('options_page', '==', 'acf-options-header');

        // Footer Settings
        $footerSettings = new FieldsBuilder('footer_settings');
        $footerSettings
            ->addTab('content', ['label' => 'Footer Content'])
                ->addWysiwyg('footer_text', [
                    'label' => 'Footer Text',
                    'toolbar' => 'basic',
                    'media_upload' => 0
                ])
                ->addText('copyright_text', [
                    'label' => 'Copyright Text',
                    'default_value' => '© ' . date('Y') . ' All rights reserved.'
                ])
            ->addTab('columns', ['label' => 'Footer Columns'])
                ->addRepeater('footer_columns', [
                    'label' => 'Footer Columns',
                    'min' => 0,
                    'max' => 4,
                    'layout' => 'block',
                    'button_label' => 'Add Column'
                ])
                    ->addText('title', [
                        'label' => 'Column Title'
                    ])
                    ->addWysiwyg('content', [
                        'label' => 'Column Content',
                        'toolbar' => 'basic'
                    ])
                ->endRepeater()
            ->setLocation('options_page', '==', 'acf-options-footer');

        // Social Media Settings
        $socialSettings = new FieldsBuilder('social_settings');
        $socialSettings
            ->addTab('social_links', ['label' => 'Social Links'])
                ->addUrl('facebook_url', [
                    'label' => 'Facebook URL'
                ])
                ->addUrl('twitter_url', [
                    'label' => 'Twitter URL'
                ])
                ->addUrl('instagram_url', [
                    'label' => 'Instagram URL'
                ])
                ->addUrl('linkedin_url', [
                    'label' => 'LinkedIn URL'
                ])
                ->addUrl('youtube_url', [
                    'label' => 'YouTube URL'
                ])
                ->addRepeater('custom_social_links', [
                    'label' => 'Additional Social Links',
                    'min' => 0,
                    'max' => 10,
                    'layout' => 'table',
                    'button_label' => 'Add Social Link'
                ])
                    ->addText('platform', [
                        'label' => 'Platform Name'
                    ])
                    ->addUrl('url', [
                        'label' => 'URL'
                    ])
                    ->addText('icon_class', [
                        'label' => 'Icon Class',
                        'instructions' => 'FontAwesome or custom icon class'
                    ])
                ->endRepeater()
            ->addTab('display', ['label' => 'Display Options'])
                ->addTrueFalse('show_social_header', [
                    'label' => 'Show Social Links in Header',
                    'default_value' => 0
                ])
                ->addTrueFalse('show_social_footer', [
                    'label' => 'Show Social Links in Footer',
                    'default_value' => 1
                ])
            ->setLocation('options_page', '==', 'acf-options-social');

        // Register all field groups
        acf_add_local_field_group($themeSettings->build());
        acf_add_local_field_group($headerSettings->build());
        acf_add_local_field_group($footerSettings->build());
        acf_add_local_field_group($socialSettings->build());
    }
}
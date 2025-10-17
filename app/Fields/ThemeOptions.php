<?php

namespace App\Fields;

use App\Fields\Components\Visual;
use App\Fields\Helpers\Choices;
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

            acf_add_options_sub_page([
                'page_title' => 'Archive & Blog Settings',
                'menu_title' => 'Archive & Blog',
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

        // Archive & Blog Settings
        $archiveSettings = new FieldsBuilder('archive_settings');
        $archiveSettings
            ->addTab('page_header', ['label' => 'Page Header Settings'])
            ->addSelect('header_theme', [
                'label' => 'Header Theme',
                'instructions' => 'Default theme for page headers on archive pages',
                'choices' => Choices::theme(),
                'default_value' => 'grey',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('header_alignment', [
                'label' => 'Header Text Alignment',
                'choices' => [
                    'text-left' => 'Left',
                    'text-center' => 'Center',
                    'text-right' => 'Right',
                ],
                'default_value' => 'text-left',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('header_padding_top', [
                'label' => 'Header Padding Top',
                'choices' => Choices::paddingTop(),
                'default_value' => 'pt-section-main',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('header_padding_bottom', [
                'label' => 'Header Padding Bottom',
                'choices' => Choices::paddingBottom(),
                'default_value' => 'pb-section-main',
                'wrapper' => ['width' => '50'],
            ])
            ->addTrueFalse('enable_visual', [
                'label' => 'Enable Split Layout with Visual',
                'instructions' => 'When enabled, the page header will use a two-column layout with an image/visual',
                'default_value' => 0,
                'ui' => 1,
            ])
            ->addImage('visual_image', [
                'label' => 'Header Image',
                'instructions' => 'Upload image for the header',
                'return_format' => 'array',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('content_layout', [
                'label' => 'Content Layout',
                'instructions' => 'Choose whether visual appears on left or right',
                'choices' => [
                    'visual-right' => 'Visual Right / Content Left',
                    'visual-left' => 'Visual Left / Content Right',
                ],
                'default_value' => 'visual-right',
                'wrapper' => ['width' => '100'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('visual_aspect_ratio', [
                'label' => 'Image Aspect Ratio',
                'choices' => array_merge(
                    Choices::aspectRatio(),
                    [
                        'aspect-[2/1]' => '2:1 (Banner)',
                        'aspect-auto' => 'Auto (Original)',
                    ]
                ),
                'default_value' => 'aspect-[16/9]',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('vertical_alignment', [
                'label' => 'Vertical Alignment',
                'choices' => [
                    'items-start' => 'Top',
                    'items-center' => 'Center',
                    'items-end' => 'Bottom',
                ],
                'default_value' => 'items-center',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('header_gap_size', [
                'label' => 'Gap Between Columns',
                'choices' => Choices::spacing(),
                'default_value' => 'gap-u-8',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addTrueFalse('stretch_to_content', [
                'label' => 'Stretch to Content',
                'instructions' => 'Maintain aspect ratio as minimum, but stretch taller if content is longer',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addTrueFalse('priority_loading', [
                'label' => 'Priority Loading',
                'instructions' => 'Load this image immediately (recommended for above-the-fold images)',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('clip_path', [
                'label' => 'Clip Path',
                'choices' => [
                    '' => 'None',
                    'diagonal-left' => 'Diagonal Left',
                    'diagonal-right' => 'Diagonal Right',
                ],
                'default_value' => 'diagonal-left',
                'wrapper' => ['width' => '33'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_visual',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addTab('filter_settings', ['label' => 'Filter Settings'])
            ->addTrueFalse('enable_filters', [
                'label' => 'Enable Filters',
                'instructions' => 'Show filter options above the posts grid',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addCheckbox('active_filters', [
                'label' => 'Active Filter Types',
                'instructions' => 'Select which filter types to display',
                'choices' => [
                    'category-badges' => 'Category Badges',
                    'search-field' => 'Search Field',
                    'dropdown-filter' => 'Dropdown Filter',
                ],
                'default_value' => ['category-badges'],
                'layout' => 'vertical',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_filters',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('filter_theme', [
                'label' => 'Filter Section Theme',
                'instructions' => 'Background theme for the filter section',
                'choices' => Choices::theme(),
                'default_value' => 'light',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_filters',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addTab('section_settings', ['label' => 'Section Settings'])
            ->addSelect('section_theme', [
                'label' => 'Section Theme',
                'instructions' => 'Background theme for the posts grid section',
                'choices' => Choices::theme(),
                'default_value' => 'light',
            ])
            ->addSelect('grid_columns_desktop', [
                'label' => 'Grid Columns (Desktop)',
                'choices' => Choices::gridColumnsDesktop(),
                'default_value' => 'grid-cols-3',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('grid_columns_tablet', [
                'label' => 'Grid Columns (Tablet)',
                'choices' => Choices::gridColumnsTablet(),
                'default_value' => 'grid-cols-2',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('grid_columns_mobile', [
                'label' => 'Grid Columns (Mobile)',
                'choices' => Choices::gridColumnsMobile(),
                'default_value' => 'grid-cols-1',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Between Cards',
                'instructions' => 'Space between grid items',
                'choices' => Choices::gapSize(),
                'default_value' => 'gap-u-6',
            ])
            ->addTab('card_settings', ['label' => 'Card Settings'])
            ->addSelect('card_theme', [
                'label' => 'Card Theme',
                'instructions' => 'Theme for individual post cards',
                'choices' => Choices::cardTheme(),
                'default_value' => 'auto',
            ])
            ->addSelect('image_aspect_ratio', [
                'label' => 'Image Aspect Ratio',
                'instructions' => 'Aspect ratio for featured images on cards',
                'choices' => Choices::aspectRatio(),
                'default_value' => 'aspect-[3/2]',
            ])
            ->addTrueFalse('show_excerpt', [
                'label' => 'Show Excerpt',
                'instructions' => 'Display post excerpt on cards',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33'],
            ])
            ->addTrueFalse('show_category', [
                'label' => 'Show Category',
                'instructions' => 'Display category badge on cards',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33'],
            ])
            ->addTrueFalse('make_card_clickable', [
                'label' => 'Make Whole Card Clickable',
                'instructions' => 'When enabled, clicking anywhere on the card will navigate to the post',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33'],
            ])
            ->setLocation('options_page', '==', 'acf-options-archive-blog');

        // Register all field groups
        acf_add_local_field_group($themeSettings->build());
        acf_add_local_field_group($headerSettings->build());
        acf_add_local_field_group($footerSettings->build());
        acf_add_local_field_group($socialSettings->build());
        acf_add_local_field_group($archiveSettings->build());
    }
}

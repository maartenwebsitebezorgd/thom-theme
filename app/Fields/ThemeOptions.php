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
        add_action('admin_notices', [$this, 'renderOverviewPage']);
    }

    public function addOptionsPage()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Theme Options',
                'menu_title' => 'Theme Options',
                'menu_slug' => 'theme-settings',
                'capability' => 'edit_posts',
                'icon_url' => 'dashicons-admin-customizer',
                'position' => 30,
                'redirect' => false, // Show overview page
            ]);

            // Add sub-pages for organization
            acf_add_options_sub_page([
                'page_title' => 'General Settings',
                'menu_title' => 'General',
                'parent_slug' => 'theme-settings',
            ]);

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
        // General Settings (First sub-page)
        $generalSettings = new FieldsBuilder('general_settings');
        $generalSettings
            ->addTab('brand', ['label' => 'Brand'])
            ->addImage('logo_light', [
                'label' => 'Logo for Light Background',
                'instructions' => 'Upload logo for use on light/white backgrounds (typically dark colored logo)',
                'return_format' => 'array'
            ])
            ->addImage('logo_dark', [
                'label' => 'Logo for Dark Background',
                'instructions' => 'Upload logo for use on dark backgrounds (typically white/light colored logo)',
                'return_format' => 'array'
            ])
            ->addNumber('excerpt_word_count', [
                'label' => 'Excerpt Word Count',
                'instructions' => 'Number of words to show in post/case excerpts before trimming',
                'default_value' => 20,
                'min' => 5,
                'max' => 100,
                'step' => 1,
            ])
            ->addText('excerpt_more_text', [
                'label' => 'Excerpt "More" Text',
                'instructions' => 'Text to show after trimmed excerpts (use "..." for ellipsis). Leave empty for no suffix.',
                'default_value' => '...',
                'placeholder' => '...',
            ])
            ->addImage('site_favicon', [
                'label' => 'Site Favicon (Deprecated)',
                'instructions' => 'This field is deprecated. Use the new Favicons & SEO tab below.',
                'return_format' => 'array',
                'wrapper' => ['class' => 'acf-hidden']
            ])
            ->addTab('favicons_seo', ['label' => 'Favicons & SEO'])
            ->addMessage('favicon_intro', '<h3>Favicon Settings</h3><p>Upload your favicon files here. <strong>Tip:</strong> Use <a href="https://realfavicongenerator.net/" target="_blank">RealFaviconGenerator</a> to generate all sizes at once.</p>')
            ->addImage('favicon_ico', [
                'label' => 'Favicon ICO',
                'instructions' => 'Standard favicon (32x32 or 16x16). Usually favicon.ico',
                'return_format' => 'array',
                'mime_types' => 'ico,png',
                'wrapper' => ['width' => '50']
            ])
            ->addImage('favicon_16', [
                'label' => 'Favicon 16x16',
                'instructions' => '16x16 PNG favicon',
                'return_format' => 'array',
                'mime_types' => 'png',
                'wrapper' => ['width' => '50']
            ])
            ->addImage('favicon_32', [
                'label' => 'Favicon 32x32',
                'instructions' => '32x32 PNG favicon',
                'return_format' => 'array',
                'mime_types' => 'png',
                'wrapper' => ['width' => '50']
            ])
            ->addImage('apple_touch_icon', [
                'label' => 'Apple Touch Icon',
                'instructions' => '180x180 PNG - Used when adding to iOS home screen',
                'return_format' => 'array',
                'mime_types' => 'png',
                'wrapper' => ['width' => '50']
            ])
            ->addImage('android_chrome_192', [
                'label' => 'Android Chrome Icon 192x192',
                'instructions' => '192x192 PNG - Used for Android',
                'return_format' => 'array',
                'mime_types' => 'png',
                'wrapper' => ['width' => '50']
            ])
            ->addImage('android_chrome_512', [
                'label' => 'Android Chrome Icon 512x512',
                'instructions' => '512x512 PNG - Used for Android and PWA',
                'return_format' => 'array',
                'mime_types' => 'png',
                'wrapper' => ['width' => '50']
            ])
            ->addColorPicker('theme_color', [
                'label' => 'Theme Color',
                'instructions' => 'Browser theme color (shown in mobile browser UI)',
                'default_value' => '#ffffff',
                'wrapper' => ['width' => '50']
            ])
            ->addMessage('seo_intro', '<h3>SEO Settings</h3><p>Optional: Only needed if you are NOT using an SEO plugin like Yoast, Rank Math, or All in One SEO.</p>')
            ->addImage('default_share_image', [
                'label' => 'Default Social Share Image',
                'instructions' => 'Default image for social media sharing (1200x630px recommended). Used when no featured image is set.',
                'return_format' => 'array',
                'mime_types' => 'png,jpg,jpeg',
            ])
            ->addText('twitter_handle', [
                'label' => 'Twitter Handle',
                'instructions' => 'Your Twitter/X username (without @). Example: yourusername',
                'placeholder' => 'yourusername',
                'wrapper' => ['width' => '50']
            ])
            ->addTextarea('default_meta_description', [
                'label' => 'Default Meta Description',
                'instructions' => 'Default description for pages without custom meta descriptions (155 characters max)',
                'maxlength' => 160,
                'rows' => 3,
                'wrapper' => ['width' => '50']
            ])
            ->addTab('contact', ['label' => 'Contact Info'])
            ->addText('phone', [
                'label' => 'Phone Number',
                'instructions' => 'Main contact phone number'
            ])
            ->addEmail('email', [
                'label' => 'Contact Email',
                'instructions' => 'Main contact email address'
            ])
            ->addTextarea('address', [
                'label' => 'Address',
                'instructions' => 'Physical address or mailing address',
                'rows' => 3
            ])
            ->addUrl('maps_url', [
                'label' => 'Google Maps URL',
                'instructions' => 'Link to your location on Google Maps (optional)'
            ])
            ->addTab('brand_colors', ['label' => 'Brand Colors'])
            ->addColorPicker('primary_color', [
                'label' => 'Primary Brand Color',
                'instructions' => 'Main brand color used throughout the site',
                'default_value' => '#3b82f6'
            ])
            ->addColorPicker('secondary_color', [
                'label' => 'Secondary Brand Color',
                'instructions' => 'Secondary accent color',
                'default_value' => '#10b981'
            ])
            ->setLocation('options_page', '==', 'acf-options-general');

        // Header Settings
        $headerSettings = new FieldsBuilder('header_settings');
        $headerSettings
            ->addTab('navigation', ['label' => 'Navigation'])
            ->addSelect('header_theme', [
                'label' => 'Header Theme',
                'instructions' => 'Visual style for the header/navigation',
                'choices' => [
                    'solid-dark' => 'Solid Dark (Default)',
                    'solid-light' => 'Solid Light',
                    'solid-accent' => 'Solid Accent',
                    'blur-dark' => 'Blurred Dark (Translucent)',
                    'blur-light' => 'Blurred Light (Translucent)',
                ],
                'default_value' => 'solid-dark',
            ])
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
            ->addTab('action_buttons', ['label' => 'Action Buttons'])
            ->addTrueFalse('show_desktop_cta', [
                'label' => 'Show Desktop CTA Button',
                'instructions' => 'Display call-to-action button on desktop in header right',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addText('desktop_cta_text', [
                'label' => 'Desktop CTA Text',
                'default_value' => 'Get Started',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_desktop_cta',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addUrl('desktop_cta_url', [
                'label' => 'Desktop CTA URL',
                'default_value' => '/contact',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_desktop_cta',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('desktop_cta_style', [
                'label' => 'Desktop CTA Style',
                'choices' => [
                    'primary' => 'Primary Button (Filled)',
                    'secondary' => 'Secondary Button (Outline)',
                    'link' => 'Link with Arrow',
                ],
                'default_value' => 'primary',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_desktop_cta',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addTrueFalse('desktop_cta_new_tab', [
                'label' => 'Open in New Tab',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_desktop_cta',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addTrueFalse('show_mobile_cta', [
                'label' => 'Show Mobile CTA Button',
                'instructions' => 'Display call-to-action button in mobile menu',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addText('mobile_cta_text', [
                'label' => 'Mobile CTA Text',
                'default_value' => 'Get Started',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_mobile_cta',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addUrl('mobile_cta_url', [
                'label' => 'Mobile CTA URL',
                'default_value' => '/contact',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_mobile_cta',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addTrueFalse('mobile_cta_new_tab', [
                'label' => 'Open in New Tab',
                'default_value' => 0,
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_mobile_cta',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
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
                'instructions' => 'Use {{year}} as a placeholder for the current year. Example: © {{year}} Your Company. All rights reserved.',
                'default_value' => '© {{year}} All rights reserved.'
            ])
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
            ->addSelect('archive_header_theme', [
                'label' => 'Page Header Background Theme',
                'instructions' => 'Default background theme for page headers on archive pages',
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
                'default_value' => 'gap-u-4',
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
            ->addTab('single_post_settings', ['label' => 'Single Post Settings'])
            ->addSelect('single_header_theme', [
                'label' => 'Header Theme',
                'instructions' => 'Background theme for single post header',
                'choices' => Choices::theme(),
                'default_value' => 'grey',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('single_header_alignment', [
                'label' => 'Header Content Alignment',
                'choices' => [
                    'text-left' => 'Left',
                    'text-center' => 'Center',
                ],
                'default_value' => 'text-center',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('single_header_layout', [
                'label' => 'Header Layout',
                'instructions' => 'Choose header layout style',
                'choices' => [
                    'full-width' => 'Full Width (Image Below Content)',
                    'split' => 'Split Layout (Content Left, Image Right)',
                    'split-reverse' => 'Split Layout (Image Left, Content Right)',
                ],
                'default_value' => 'full-width',
            ])
            ->addSelect('single_header_max_width', [
                'label' => 'Header Content Max Width',
                'instructions' => 'Maximum width for header content text',
                'choices' => [
                    'max-w-[50ch]' => 'Narrow (50ch)',
                    'max-w-[60ch]' => 'Medium Narrow (60ch)',
                    'max-w-[70ch]' => 'Medium (70ch)',
                    'max-w-[80ch]' => 'Medium Wide (80ch)',
                    'max-w-none' => 'Full Width',
                ],
                'default_value' => 'max-w-[70ch]',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('single_image_aspect_ratio', [
                'label' => 'Header Image Aspect Ratio',
                'choices' => array_merge(
                    Choices::aspectRatio(),
                    [
                        'aspect-[2/1]' => '2:1 (Banner)',
                        'aspect-auto' => 'Auto (Original)',
                    ]
                ),
                'default_value' => 'aspect-[16/9]',
                'wrapper' => ['width' => '50'],
            ])
            ->addTrueFalse('single_stretch_to_content', [
                'label' => 'Stretch Image to Content',
                'instructions' => 'Maintain aspect ratio as minimum, but stretch taller if content is longer (split layout only)',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('single_content_theme', [
                'label' => 'Content Section Theme',
                'instructions' => 'Background theme for main content area',
                'choices' => Choices::theme(),
                'default_value' => 'light',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('single_content_max_width', [
                'label' => 'Content Max Width',
                'instructions' => 'Maximum width for post content',
                'choices' => [
                    'max-w-[60ch]' => 'Narrow (60ch)',
                    'max-w-[70ch]' => 'Medium (70ch)',
                    'max-w-[80ch]' => 'Wide (80ch)',
                    'max-w-4xl' => 'Extra Wide',
                    'max-w-none' => 'Full Width',
                ],
                'default_value' => 'max-w-[70ch]',
                'wrapper' => ['width' => '50'],
            ])
            ->addMessage('visibility_settings_label', '<h3>Show/Hide Elements</h3>')
            ->addTrueFalse('show_breadcrumbs', [
                'label' => 'Show Breadcrumbs',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_categories', [
                'label' => 'Show Categories',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_author', [
                'label' => 'Show Author',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_date', [
                'label' => 'Show Date',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_read_time', [
                'label' => 'Show Read Time',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_featured_image', [
                'label' => 'Show Featured Image in Header',
                'instructions' => 'Display featured image in the header (if no custom main image is set)',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_related_posts', [
                'label' => 'Show Related Posts',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_post_navigation', [
                'label' => 'Show Post Navigation (Prev/Next)',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addSelect('related_posts_theme', [
                'label' => 'Related Posts Section Theme',
                'choices' => Choices::theme(),
                'default_value' => 'grey',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_related_posts',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addNumber('related_posts_count', [
                'label' => 'Number of Related Posts',
                'instructions' => 'How many related posts to display',
                'min' => 2,
                'max' => 6,
                'default_value' => 3,
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_related_posts',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('related_posts_columns', [
                'label' => 'Related Posts Grid Columns',
                'choices' => [
                    'grid-cols-1 md:grid-cols-2' => '2 Columns',
                    'grid-cols-1 md:grid-cols-2 lg:grid-cols-3' => '3 Columns',
                    'grid-cols-1 md:grid-cols-2 lg:grid-cols-4' => '4 Columns',
                ],
                'default_value' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
                'wrapper' => ['width' => '50'],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_related_posts',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->setLocation('options_page', '==', 'acf-options-archive-blog');

        // Register all field groups
        acf_add_local_field_group($generalSettings->build());
        acf_add_local_field_group($headerSettings->build());
        acf_add_local_field_group($footerSettings->build());
        acf_add_local_field_group($socialSettings->build());
        acf_add_local_field_group($archiveSettings->build());
    }

    public function renderOverviewPage()
    {
        $screen = get_current_screen();

        // Only show on the main theme options page
        if ($screen && $screen->id === 'toplevel_page_theme-settings') {
            ?>
            <style>
                .theme-options-overview {
                    max-width: 1200px;
                    margin: 2rem 0;
                }
                .theme-options-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                    gap: 1.5rem;
                    margin-top: 2rem;
                }
                .theme-option-card {
                    background: #fff;
                    border: 1px solid #dcdcde;
                    border-radius: 8px;
                    padding: 1.5rem;
                    text-decoration: none;
                    transition: all 0.2s ease;
                    display: flex;
                    flex-direction: column;
                    gap: 0.75rem;
                }
                .theme-option-card:hover {
                    border-color: #2271b1;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    transform: translateY(-2px);
                }
                .theme-option-card-icon {
                    font-size: 2rem;
                    line-height: 1;
                }
                .theme-option-card-title {
                    font-size: 1.125rem;
                    font-weight: 600;
                    color: #1d2327;
                    margin: 0;
                }
                .theme-option-card-description {
                    font-size: 0.875rem;
                    color: #646970;
                    margin: 0;
                    line-height: 1.5;
                }
            </style>

            <div class="theme-options-overview">
                <h1>Theme Options</h1>
                <p style="font-size: 1rem; color: #646970; margin-bottom: 0.5rem;">Configure your theme settings using the options below.</p>

                <div class="theme-options-grid">
                    <a href="<?php echo admin_url('admin.php?page=acf-options-general'); ?>" class="theme-option-card">
                        <div class="theme-option-card-icon">🎨</div>
                        <h2 class="theme-option-card-title">General</h2>
                        <p class="theme-option-card-description">Manage your brand logos, contact information, and brand colors.</p>
                    </a>

                    <a href="<?php echo admin_url('admin.php?page=acf-options-header'); ?>" class="theme-option-card">
                        <div class="theme-option-card-icon">🧭</div>
                        <h2 class="theme-option-card-title">Header</h2>
                        <p class="theme-option-card-description">Configure navigation menus, header styles, and call-to-action buttons.</p>
                    </a>

                    <a href="<?php echo admin_url('admin.php?page=acf-options-footer'); ?>" class="theme-option-card">
                        <div class="theme-option-card-icon">📄</div>
                        <h2 class="theme-option-card-title">Footer</h2>
                        <p class="theme-option-card-description">Customize footer content, columns, and copyright information.</p>
                    </a>

                    <a href="<?php echo admin_url('admin.php?page=acf-options-social'); ?>" class="theme-option-card">
                        <div class="theme-option-card-icon">🔗</div>
                        <h2 class="theme-option-card-title">Social</h2>
                        <p class="theme-option-card-description">Add and manage social media links and display options.</p>
                    </a>

                    <a href="<?php echo admin_url('admin.php?page=acf-options-archive-blog'); ?>" class="theme-option-card">
                        <div class="theme-option-card-icon">📰</div>
                        <h2 class="theme-option-card-title">Archive & Blog</h2>
                        <p class="theme-option-card-description">Configure archive layouts, blog settings, and single post templates.</p>
                    </a>
                </div>
            </div>
            <?php
        }
    }
}

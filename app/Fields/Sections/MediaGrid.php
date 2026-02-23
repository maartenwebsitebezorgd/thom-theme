<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class MediaGrid
{
    /**
     * Creates a 'media_grid' layout for flexible content.
     * Each item can be either an image or a video (YouTube, Vimeo or direct file).
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'media_grid')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Media Grid',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', [
                'heading_tag' => 'h2',
                'heading_text_style' => 'u-text-style-h3',
                'paragraph_text_style' => 'u-text-style-main',
                'margin_bottom' => 'mb-u-6',
            ]))
            ->addRepeater('items', [
                'label' => 'Media Items',
                'min' => 1,
                'layout' => 'block',
                'button_label' => 'Add Media Item',
            ])
                ->addSelect('media_type', [
                    'label' => 'Media Type',
                    'choices' => [
                        'image'       => 'Image',
                        'video_url'   => 'Video (URL)',
                        'video_file'  => 'Video (Media Library)',
                    ],
                    'default_value' => 'image',
                    'wrapper' => ['width' => '25'],
                ])
                ->addImage('image', [
                    'label' => 'Image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'wrapper' => ['width' => '75'],
                    'conditional_logic' => [[
                        ['field' => 'media_type', 'operator' => '==', 'value' => 'image']
                    ]],
                ])
                ->addUrl('video_url', [
                    'label' => 'Video URL',
                    'instructions' => 'YouTube, Vimeo, or a direct video file URL',
                    'wrapper' => ['width' => '75'],
                    'conditional_logic' => [[
                        ['field' => 'media_type', 'operator' => '==', 'value' => 'video_url']
                    ]],
                ])
                ->addFile('video_file', [
                    'label' => 'Video File',
                    'instructions' => 'Select a video from the media library (mp4, webm)',
                    'return_format' => 'array',
                    'library' => 'all',
                    'mime_types' => 'mp4,webm,ogg',
                    'wrapper' => ['width' => '75'],
                    'conditional_logic' => [[
                        ['field' => 'media_type', 'operator' => '==', 'value' => 'video_file']
                    ]],
                ])
                ->addImage('poster_image', [
                    'label' => 'Poster Image',
                    'instructions' => 'Thumbnail shown before the video plays',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'wrapper' => ['width' => '50'],
                    'conditional_logic' => [[
                        ['field' => 'media_type', 'operator' => '==', 'value' => 'video_url'],
                    ], [
                        ['field' => 'media_type', 'operator' => '==', 'value' => 'video_file'],
                    ]],
                ])
            ->endRepeater()
            ->addSelect('aspect_ratio', [
                'label' => 'Aspect Ratio',
                'choices' => Choices::aspectRatio(),
                'default_value' => 'aspect-[16/9]',
                'wrapper' => ['width' => '25'],
            ])
            ->addSelect('grid_columns_desktop', [
                'label' => 'Columns (Desktop)',
                'choices' => Choices::gridColumnsDesktop(),
                'default_value' => 'grid-cols-3',
                'wrapper' => ['width' => '25'],
            ])
            ->addSelect('grid_columns_tablet', [
                'label' => 'Columns (Tablet)',
                'choices' => Choices::gridColumnsTablet(),
                'default_value' => 'grid-cols-2',
                'wrapper' => ['width' => '25'],
            ])
            ->addSelect('grid_columns_mobile', [
                'label' => 'Columns (Mobile)',
                'choices' => Choices::gridColumnsMobile(),
                'default_value' => 'grid-cols-1',
                'wrapper' => ['width' => '25'],
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Size',
                'choices' => Choices::gapSize(),
                'default_value' => 'gap-u-4',
                'wrapper' => ['width' => '50'],
            ])
            ->addFields(StyleSettings::create('style_settings'));
    }
}

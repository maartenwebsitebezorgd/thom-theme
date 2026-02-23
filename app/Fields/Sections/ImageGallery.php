<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ImageGallery
{
    /**
     * Creates a 'image_gallery' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'image_gallery')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Image Gallery',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', [
                'heading_tag' => 'h2',
                'heading_text_style' => 'u-text-style-h3',
                'paragraph_text_style' => 'u-text-style-main',
                'margin_bottom' => 'mb-u-6',
            ]))
            ->addGallery('images', [
                'label' => 'Gallery Images',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min' => 1,
            ])
            ->addSelect('aspect_ratio', [
                'label' => 'Image Aspect Ratio',
                'choices' => Choices::aspectRatio(),
                'default_value' => 'aspect-square',
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
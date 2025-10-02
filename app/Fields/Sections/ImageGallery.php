<?php

namespace App\Fields\Sections;

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
                ->addText('heading', [
                    'label' => 'Gallery Heading'
                ])
                ->addGallery('images', [
                    'label' => 'Gallery Images',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all'
                ])
                ->addSelect('columns', [
                    'label' => 'Columns',
                    'choices' => [
                        '2' => '2 Columns',
                        '3' => '3 Columns',
                        '4' => '4 Columns'
                    ],
                    'default_value' => '3'
                ])
                ->addSelect('aspect_ratio', [
                    'label' => 'Image Aspect Ratio',
                    'choices' => [
                        'aspect-square' => 'Square',
                        'aspect-[4/3]' => '4:3',
                        'aspect-[16/9]' => '16:9'
                    ],
                    'default_value' => 'aspect-square'
                ]);
    }
}
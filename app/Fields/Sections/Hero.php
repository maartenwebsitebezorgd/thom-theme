<?php

namespace App\Fields\Sections;

use App\Fields\Components\Background;
use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\Visual;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Hero
{
    /**
     * Creates a 'hero' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'hero')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Hero Section',
                'display' => 'block'
            ])
            ->addFields(Background::create('background_block'))
            ->addFields(Visual::create('visual_block'))
            ->addFields(ContentWrapper::create('content_block', [
                'heading_tag' => 'h1',
                'heading_text_style' => 'u-text-style-h1',
                'paragraph_text_style' => 'u-text-style-medium',
                'margin_bottom' => 'mb-0',
            ]))
            ->addFields(StyleSettings::create('style_settings'))
            ->addSelect('content_position', [
                'label' => 'Content Position',
                'choices' => [
                    'center' => 'Center',
                    'left' => 'Left',
                    'right' => 'Right',
                ],
                'default_value' => 'center',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('vertical_position', [
                'label' => 'Vertical Position',
                'choices' => [
                    'top' => 'Top',
                    'center' => 'Center',
                    'bottom' => 'Bottom',
                ],
                'default_value' => 'center',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Between Columns',
                'choices' => Choices::spacing(),
                'default_value' => 'gap-u-6'
            ]);
    }
}

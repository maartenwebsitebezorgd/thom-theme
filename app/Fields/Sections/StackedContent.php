<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\Visual;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class StackedContent
{
    /**
     * Creates a 'stacked_content' layout for flexible content.
     * Content on top (centered), visual below
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'stacked_content')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Stacked Content Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', defaults: [
                'margin_bottom' => 'mb-0',
            ]))
            ->addFields(Visual::create('visual_block', defaults: [
                'stretch_to_content' => 0,
                'clip_path' => '',
            ]))
            ->addFields(StyleSettings::create('style_settings'))
            ->addSelect('gap_size', [
                'label' => 'Gap Between Content and Visual',
                'choices' => Choices::spacing(),
                'default_value' => 'gap-u-8'
            ])
            ->addSelect('text_alignment', [
                'label' => 'Text Alignment',
                'choices' => [
                    'text-center' => 'Center',
                    'text-left' => 'Left',
                    'text-right' => 'Right',
                ],
                'default_value' => 'text-center'
            ]);
    }
}

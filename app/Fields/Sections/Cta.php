<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\Visual;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Cta
{
    /**
     * Creates a 'cta' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'cta')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'CTA Section',
                'display' => 'block'
            ])
            ->addFields(Visual::create('visual_block'))
            ->addFields(ContentWrapper::create('content_block', defaults: [
                'margin_bottom' => 'mb-0',
                'heading_text_style' => 'u-text-style-h3',
                'heading_tag' => 'h3',
            ]))
            ->addFields(StyleSettings::create('style_settings', defaults: [
                'theme' => 'acccent-light',
                'padding_top' => 'pt-section-small',
                'padding_bottom' => 'pb-section-small',
            ]))
            ->addSelect('content_layout', [
                'label' => 'Content Layout',
                'choices' => [
                    'visual-left' => 'Visual Left, Content Right',
                    'visual-right' => 'Visual Right, Content Left',
                ],
                'default_value' => 'visual-right'
            ])
            ->addSelect('vertical_alignment', [
                'label' => 'Vertical Alignment',
                'choices' => [
                    'items-start' => 'Top',
                    'items-center' => 'Center',
                    'items-end' => 'Bottom',
                ],
                'default_value' => 'items-center'
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Between Columns',
                'choices' => Choices::spacing(),
                'default_value' => 'gap-u-8'
            ]);
    }
}

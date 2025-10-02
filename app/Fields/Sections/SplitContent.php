<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\Visual;
use StoutLogic\AcfBuilder\FieldsBuilder;

class SplitContent
{
    /**
     * Creates a 'split_content' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'split_content')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Split Content Section',
                'display' => 'block'
            ])
                ->addFields(Visual::create('visual_block'))
                ->addFields(ContentWrapper::create('content_block'))
                ->addFields(StyleSettings::create('style_settings'))
                ->addSelect('content_layout', [
                    'label' => 'Content Layout',
                    'choices' => [
                        'visual-left' => 'Visual Left, Content Right',
                        'visual-right' => 'Visual Right, Content Left',
                    ],
                    'default_value' => 'visual-left'
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
                    'choices' => [
                        'gap-u-4' => 'Small',
                        'gap-u-6' => 'Medium',
                        'gap-u-8' => 'Large',
                        'gap-u-12' => 'Extra Large',
                    ],
                    'default_value' => 'gap-u-8'
                ]);
    }
}
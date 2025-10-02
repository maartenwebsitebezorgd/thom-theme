<?php

namespace App\Fields\Sections;

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
                ->addText('title', [
                    'label' => 'Hero Title',
                    'instructions' => 'Main heading for the hero section'
                ])
                ->addTextarea('subtitle', [
                    'label' => 'Hero Subtitle',
                    'instructions' => 'Supporting text below the title'
                ])
                ->addImage('background_image', [
                    'label' => 'Background Image',
                    'return_format' => 'array'
                ])
                ->addSelect('text_color', [
                    'label' => 'Text Color',
                    'choices' => [
                        'white' => 'White',
                        'black' => 'Black'
                    ],
                    'default_value' => 'white'
                ])
                ->addSelect('height', [
                    'label' => 'Section Height',
                    'choices' => [
                        'min-h-screen' => 'Full Screen',
                        'min-h-[70vh]' => 'Large',
                        'min-h-[50vh]' => 'Medium'
                    ],
                    'default_value' => 'min-h-screen'
                ]);
    }
}
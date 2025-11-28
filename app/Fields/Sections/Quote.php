<?php

namespace App\Fields\Sections;

use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Quote
{
    /**
     * Creates a 'quote' layout for flexible content.
     * Centered quote section with blue theme default
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'quote')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Quote Section',
                'display' => 'block'
            ])
            ->addTextarea('quote_text', [
                'label' => 'Quote Text',
                'instructions' => 'The main quote text',
                'required' => 1,
                'rows' => 4,
            ])
            ->addText('author_name', [
                'label' => 'Author Name',
                'instructions' => 'Name of the person being quoted',
            ])
            ->addText('author_title', [
                'label' => 'Author Title/Position',
                'instructions' => 'Job title, company, or other descriptor',
            ])
            ->addImage('author_image', [
                'label' => 'Author Image',
                'instructions' => 'Optional image of the author',
                'return_format' => 'array',
            ])
            ->addFields(StyleSettings::create('style_settings', defaults: [
                'theme' => 'dark',
                'padding_top' => 'pt-section-main',
                'padding_bottom' => 'pb-section-main',
            ]))
            ->addSelect('content_max_width', [
                'label' => 'Content Max Width',
                'instructions' => 'Maximum width for the centered quote',
                'choices' => [
                    'max-w-full' => 'Full Width',
                    'max-w-7xl' => 'Extra Large (1280px)',
                    'max-w-6xl' => 'Large (1152px)',
                    'max-w-5xl' => 'Medium (1024px)',
                    'max-w-4xl' => 'Small (896px)',
                    'max-w-3xl' => 'Extra Small (768px)',
                    'max-w-2xl' => 'Tiny (672px)',
                ],
                'default_value' => 'max-w-4xl',
            ])
            ->addSelect('quote_text_style', [
                'label' => 'Quote Text Style',
                'choices' => Choices::headingTextStyle(),
                'default_value' => 'u-text-style-h2',
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

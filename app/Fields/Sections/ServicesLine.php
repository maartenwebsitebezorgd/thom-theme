<?php

namespace App\Fields\Sections;

use App\Fields\Components\ServiceLineCard;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ServicesLine
{
    /**
     * Creates a 'services_line' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'services_line')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Services Line Section',
                'display' => 'block'
            ])
            ->addGroup('heading_content', [
                'label' => 'Heading Content',
                'layout' => 'block',
            ])
            ->addText('heading_text', [
                'label' => 'Heading Text',
                'instructions' => 'Enter the full heading text (e.g., "Direct benieuwd naar onze diensten?")',
                'default_value' => 'Direct benieuwd naar onze diensten?',
                'required' => 1,
            ])
            ->addText('link_text', [
                'label' => 'Link Text (Optional)',
                'instructions' => 'Enter the part of the heading that should be a link (e.g., "onze diensten"). Must be an exact match from the heading text.',
                'placeholder' => 'onze diensten',
            ])
            ->addLink('link', [
                'label' => 'Link URL',
                'instructions' => 'Choose where the link should go',
                'return_format' => 'array',
            ])
            ->conditional('link_text', '!=', '')
            ->endGroup()
            ->addTrueFalse('use_global_services', [
                'label' => 'Use Global Services',
                'instructions' => 'Select services from global settings',
                'default_value' => 0,
                'ui' => 1,
            ])
            ->addRepeater('selected_services', [
                'label' => 'Select & Order Services',
                'instructions' => 'Choose services and drag to reorder. <a href="' . admin_url('admin.php?page=services-options') . '" target="_blank">Manage global services</a>',
                'layout' => 'table',
                'button_label' => 'Add Service',
                'max' => 4,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_global_services',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('service', [
                'label' => 'Service',
                'choices' => [], // Will be populated dynamically
                'required' => 1,
            ])
            ->endRepeater()
            ->addRepeater('cards', [
                'label' => 'Service Cards',
                'instructions' => 'Add up to 5 service line cards',
                'min' => 1,
                'max' => 5,
                'layout' => 'block',
                'button_label' => 'Add Service Card',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_global_services',
                            'operator' => '!=',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addFields(ServiceLineCard::create('service_card'))
            ->endRepeater()
            ->addSelect('card_theme', [
                'label' => 'Card Theme',
                'instructions' => 'Choose the theme for all cards in this section',
                'choices' => Choices::cardTheme(),
                'default_value' => 'inherit',
            ])
            ->addFields(StyleSettings::create('style_settings'));
    }
}

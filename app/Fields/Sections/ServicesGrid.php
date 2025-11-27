<?php

namespace App\Fields\Sections;

use App\Fields\Components\ServiceCard;
use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ServicesGrid
{
    /**
     * Creates a 'services_grid' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'services_grid')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Services Grid Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block'))
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
                'min' => 2,
                'max' => 6,
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
            ->addFields(ServiceCard::create('service_card'))
            ->endRepeater()
            ->addSelect('card_theme', [
                'label' => 'Card Theme',
                'choices' => Choices::cardTheme(),
                'default_value' => 'grey',
                'wrapper' => ['width' => '100'],
            ])
            ->addSelect('heading_text_style', [
                'label' => 'Card Heading Text Style',
                'choices' => Choices::headingTextStyle(),
                'default_value' => 'u-text-style-h4',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('icon_size', [
                'label' => 'Card Icon Size',
                'choices' => Choices::iconSize(),
                'default_value' => 'size-u-5',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('grid_columns_desktop', [
                'label' => 'Grid Columns (Desktop)',
                'choices' => Choices::gridColumnsDesktop(),
                'default_value' => 'grid-cols-4',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('grid_columns_tablet', [
                'label' => 'Grid Columns (Tablet)',
                'choices' => Choices::gridColumnsTablet(),
                'default_value' => 'grid-cols-2',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('grid_columns_mobile', [
                'label' => 'Grid Columns (Mobile)',
                'choices' => Choices::gridColumnsMobile(),
                'default_value' => 'grid-cols-1',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Size',
                'choices' => Choices::gapSize(),
                'default_value' => 'gap-u-4'
            ])
            ->addFields(StyleSettings::create('style_settings'));
    }
}

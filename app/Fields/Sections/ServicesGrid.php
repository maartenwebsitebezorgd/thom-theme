<?php

namespace App\Fields\Sections;

use App\Fields\Components\ServiceCard;
use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
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
            ->addCheckbox('selected_services', [
                'label' => 'Select Services to Display',
                'instructions' => 'Choose which services to show. <a href="' . admin_url('admin.php?page=services-options') . '" target="_blank">Manage global services</a>',
                'choices' => [], // Will be populated dynamically
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
                'choices' => [
                    'inherit' => 'Inherit',
                    'light' => 'Light',
                    'grey' => 'Grey',
                    'accent-light' => 'Accent Light',
                    'accent' => 'Accent',
                    'dark' => 'Blue',
                ],
                'default_value' => 'auto',
                'wrapper' => ['width' => '100'],
            ])
            ->addSelect('grid_columns_desktop', [
                'label' => 'Grid Columns (Desktop)',
                'choices' => [
                    'grid-cols-2' => '2 Columns',
                    'grid-cols-3' => '3 Columns',
                    'grid-cols-4' => '4 Columns',
                ],
                'default_value' => 'grid-cols-4',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('grid_columns_tablet', [
                'label' => 'Grid Columns (Tablet)',
                'choices' => [
                    'md:grid-cols-1' => '1 Column',
                    'md:grid-cols-2' => '2 Columns',
                    'md:grid-cols-3' => '3 Columns',
                ],
                'default_value' => 'md:grid-cols-2',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('grid_columns_mobile', [
                'label' => 'Grid Columns (Mobile)',
                'choices' => [
                    'grid-cols-1' => '1 Column',
                    'grid-cols-2' => '2 Columns',
                ],
                'default_value' => 'grid-cols-1',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Size',
                'choices' => [
                    'gap-u-3' => 'Small',
                    'gap-u-4' => 'Medium',
                    'gap-u-6' => 'Large',
                    'gap-u-8' => 'Extra Large',
                ],
                'default_value' => 'gap-u-4'
            ])
            ->addFields(StyleSettings::create('style_settings'));
    }
}

<?php

namespace App\Fields\Sections;

use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Breadcrumb
{
    public static function addToFlexibleContent($flexibleContent, $name = 'breadcrumb')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Breadcrumb',
                'display' => 'block'
            ])
            ->addSelect('breadcrumb_type', [
                'label' => 'Breadcrumb Type',
                'instructions' => 'Choose how breadcrumbs are generated',
                'choices' => [
                    'auto' => 'Auto-Generated from Page Hierarchy',
                    'manual' => 'Manually Add Items',
                ],
                'default_value' => 'auto',
                'wrapper' => ['width' => '50'],
            ])
            ->addTrueFalse('show_home', [
                'label' => 'Show Home Link',
                'instructions' => 'Display "Home" as the first breadcrumb item',
                'default_value' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTrueFalse('show_current', [
                'label' => 'Show Current Page',
                'instructions' => 'Display the current page in breadcrumbs',
                'default_value' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addSelect('separator', [
                'label' => 'Separator',
                'instructions' => 'Character between breadcrumb items',
                'choices' => [
                    '/' => 'Forward Slash (/)',
                    '>' => 'Greater Than (>)',
                    'arrow' => 'Arrow (→)',
                    'pipe' => 'Pipe (|)',
                    'dot' => 'Dot (•)',
                ],
                'default_value' => '/',
                'wrapper' => ['width' => '33.33'],
            ])
            ->addSelect('text_alignment', [
                'label' => 'Text Alignment',
                'choices' => [
                    'justify-start' => 'Left',
                    'justify-center' => 'Center',
                    'justify-end' => 'Right',
                ],
                'default_value' => 'justify-start',
                'wrapper' => ['width' => '33.33'],
            ])
            ->addSelect('text_style', [
                'label' => 'Text Size',
                'choices' => Choices::paragraphTextStyle(),
                'default_value' => 'u-text-style-small',
                'wrapper' => ['width' => '33.33'],
            ])
            ->addRepeater('manual_items', [
                'label' => 'Breadcrumb Items',
                'instructions' => 'Add custom breadcrumb items',
                'button_label' => 'Add Item',
                'min' => 1,
                'max' => 4,
                'layout' => 'block',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'breadcrumb_type',
                            'operator' => '==',
                            'value' => 'manual'
                        ]
                    ]
                ]
            ])
            ->addText('label', [
                'label' => 'Label',
                'required' => 1,
                'wrapper' => ['width' => '50'],
            ])
            ->addLink('link', [
                'label' => 'Link',
                'instructions' => 'Leave empty for current page (last item)',
                'return_format' => 'array',
                'wrapper' => ['width' => '50'],
            ])
            ->endRepeater()
            ->addFields(StyleSettings::create('style_settings', defaults: [
                'theme' => 'inherit',
                'padding_top' => 'pt-section-tiny',
                'padding_bottom' => 'pb-section-tiny',
            ]));
    }
}

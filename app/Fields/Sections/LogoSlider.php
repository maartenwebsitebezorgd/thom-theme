<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class LogoSlider
{
    /**
     * Creates a 'logo_slider' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'logo_slider')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Logo Slider Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', [
                'alignment' => 'text-center',
                'heading_text_style' => 'u-text-style-h6',
            ]))
            ->addSelect('logo_source', [
                'label' => 'Logo Source',
                'instructions' => 'Choose where to get logos from',
                'choices' => [
                    'logos' => 'Logo Library',
                    'cases' => 'Cases',
                ],
                'default_value' => 'logos',
                'ui' => 1,
            ])
            ->addTrueFalse('use_latest', [
                'label' => 'Use Latest',
                'instructions' => 'Show logos automatically from latest entries',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addPostObject('selected_logos', [
                'label' => 'Select Logos',
                'instructions' => 'Choose specific logos to display',
                'post_type' => ['logo'],
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'logo_source',
                            'operator' => '==',
                            'value' => 'logos',
                        ],
                        [
                            'field' => 'use_latest',
                            'operator' => '!=',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addPostObject('selected_cases', [
                'label' => 'Select Cases',
                'instructions' => 'Choose specific cases to display',
                'post_type' => ['case'],
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'logo_source',
                            'operator' => '==',
                            'value' => 'cases',
                        ],
                        [
                            'field' => 'use_latest',
                            'operator' => '!=',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addRange('number_of_items', [
                'label' => 'Number of Items',
                'min' => 3,
                'max' => 20,
                'step' => 1,
                'default_value' => 8,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_latest',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addRange('scroll_speed', [
                'label' => 'Scroll Speed',
                'instructions' => 'Lower = slower, higher = faster',
                'min' => 10,
                'max' => 100,
                'step' => 5,
                'default_value' => 30,
                'wrapper' => ['width' => '33'],
            ])
            ->addTrueFalse('fade_edges', [
                'label' => 'Fade Edges',
                'instructions' => 'Add gradient fade effect on left/right edges',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33'],
            ])
            ->addTrueFalse('grayscale_effect', [
                'label' => 'Grayscale Effect',
                'instructions' => 'Show logos in grayscale with color on hover',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => ['width' => '33'],
            ])
            ->addTrueFalse('pause_on_hover', [
                'label' => 'Pause on Hover',
                'instructions' => 'Pause animation when hovering over the slider',
                'default_value' => 0,
                'ui' => 1,
            ])
            ->addFields(StyleSettings::create('style_settings', [
                'padding_top' => 'pt-section-small',
                'padding_bottom' => 'pb-section-small',
            ]));
    }
}

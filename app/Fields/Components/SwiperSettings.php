<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class SwiperSettings
{
    /**
     * Creates a 'swiper_settings' group field.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'swiper_settings')
    {
        $swiperSettings = new FieldsBuilder($name);

        $swiperSettings
            ->addGroup($name, [
                'label' => 'Swiper Settings',
                'layout' => 'block',
            ])
                ->addRange('slides_per_view_mobile', [
                    'label' => 'Slides Per View (Mobile)',
                    'min' => 1,
                    'max' => 4,
                    'step' => 0.5,
                    'default_value' => 1,
                    'wrapper' => ['width' => '33'],
                ])
                ->addRange('slides_per_view_tablet', [
                    'label' => 'Slides Per View (Tablet)',
                    'min' => 1,
                    'max' => 6,
                    'step' => 0.5,
                    'default_value' => 2,
                    'wrapper' => ['width' => '33'],
                ])
                ->addRange('slides_per_view_desktop', [
                    'label' => 'Slides Per View (Desktop)',
                    'min' => 1,
                    'max' => 8,
                    'step' => 0.5,
                    'default_value' => 3,
                    'wrapper' => ['width' => '33'],
                ])
                ->addRange('space_between', [
                    'label' => 'Space Between Slides (px)',
                    'min' => 0,
                    'max' => 100,
                    'step' => 5,
                    'default_value' => 20,
                    'wrapper' => ['width' => '33'],
                ])
                ->addTrueFalse('loop', [
                    'label' => 'Loop',
                    'instructions' => 'Enable continuous loop mode',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => ['width' => '33'],
                ])
                ->addTrueFalse('autoplay', [
                    'label' => 'Autoplay',
                    'instructions' => 'Enable autoplay',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => ['width' => '33'],
                ])
                ->addRange('autoplay_delay', [
                    'label' => 'Autoplay Delay (ms)',
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 500,
                    'default_value' => 3000,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'autoplay',
                                'operator' => '==',
                                'value' => '1',
                            ],
                        ],
                    ],
                ])
                ->addTrueFalse('navigation', [
                    'label' => 'Show Navigation Arrows',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => ['width' => '33'],
                ])
                ->addSelect('navigation_position', [
                    'label' => 'Navigation Position',
                    'choices' => [
                        'top-right' => 'Top Right (Above Content)',
                        'absolute' => 'Absolute (On Slides)',
                    ],
                    'default_value' => 'top-right',
                    'wrapper' => ['width' => '33'],
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'navigation',
                                'operator' => '==',
                                'value' => '1',
                            ],
                        ],
                    ],
                ])
                ->addTrueFalse('pagination', [
                    'label' => 'Show Pagination Dots',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => ['width' => '33'],
                ])
                ->addTrueFalse('centered_slides', [
                    'label' => 'Centered Slides',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => ['width' => '33'],
                ])
            ->endGroup();

        return $swiperSettings;
    }
}

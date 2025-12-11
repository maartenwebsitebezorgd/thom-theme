<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\SwiperSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class MultiSlider
{
    /**
     * Creates a 'multi_slider' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'multi_slider')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Multi Slider Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', defaults: [
                'margin_bottom' => 'mb-u-3',
                'heading_text_style' => 'u-text-style-h3',
                'heading_tag' => 'h2',
            ]))
            ->addSelect('post_type', [
                'label' => 'Post Type',
                'instructions' => 'Select which post type to display',
                'choices' => [
                    'post' => 'Blog Posts',
                    'case' => 'Cases',
                    'video' => 'Videos',
                    'team' => 'Team Members',
                ],
                'default_value' => 'post',
                'required' => 1,
            ])
            ->addTrueFalse('use_latest', [
                'label' => 'Use Latest Posts',
                'instructions' => 'Show latest posts automatically',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addPostObject('selected_posts', [
                'label' => 'Select Posts',
                'instructions' => 'Choose specific posts to display',
                'post_type' => ['post', 'case', 'video', 'team'],
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_latest',
                            'operator' => '!=',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addRange('number_of_posts', [
                'label' => 'Number of Posts',
                'min' => 2,
                'max' => 12,
                'step' => 1,
                'default_value' => 6,
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
            ->addSelect('image_aspect_ratio', [
                'label' => 'Image Aspect Ratio',
                'choices' => Choices::aspectRatio(),
                'default_value' => 'aspect-[16/9]',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('card_theme', [
                'label' => 'Card Theme',
                'choices' => Choices::cardTheme(),
                'default_value' => 'inherit',
                'wrapper' => ['width' => '33'],
            ])
            ->addFields(SwiperSettings::create('swiper_settings'))
            ->addFields(StyleSettings::create('style_settings'));
    }
}

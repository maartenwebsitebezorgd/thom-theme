<?php

namespace App\Fields\Sections;

use App\Fields\Components\ArticleSimple;
use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\SwiperSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class BlogsSlider
{
    /**
     * Creates a 'blogs_slider' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'blogs_slider')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Blogs Slider Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block'))
            ->addTrueFalse('use_latest_posts', [
                'label' => 'Use Latest Posts',
                'instructions' => 'Show latest blog posts automatically',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addPostObject('selected_posts', [
                'label' => 'Select Posts',
                'instructions' => 'Choose specific posts to display',
                'post_type' => ['post'],
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_latest_posts',
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
                            'field' => 'use_latest_posts',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('image_aspect_ratio', [
                'label' => 'Image Aspect Ratio',
                'choices' => Choices::aspectRatio(),
                'default_value' => 'aspect-[3/2]',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('card_theme', [
                'label' => 'Card Theme',
                'choices' => array_merge(
                    ['auto' => 'Auto (Opposite of Section)'],
                    Choices::cardTheme()
                ),
                'default_value' => 'inherit',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('card_background_color', [
                'label' => 'Card Background Color',
                'choices' => [
                    'auto' => 'Auto (Opposite of Section)',
                    '' => 'None',
                    'u-background-1' => 'Background One',
                    'u-background-2' => 'Background Two',
                ],
                'default_value' => 'auto',
                'wrapper' => ['width' => '33'],
            ])
            ->addFields(SwiperSettings::create('swiper_settings'))
            ->addFields(StyleSettings::create('style_settings'));
    }
}

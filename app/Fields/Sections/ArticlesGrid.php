<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ArticlesGrid
{
    /**
     * Creates an 'articles_grid' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'articles_grid')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Articles Grid Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', [
                'alignment' => 'text-center',
            ]))
            ->addTrueFalse('use_latest_posts', [
                'label' => 'Use Latest Posts',
                'instructions' => 'Show the latest blog posts automatically',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addPostObject('selected_posts', [
                'label' => 'Select Posts',
                'instructions' => 'Manually select specific posts to display',
                'post_type' => ['post'],
                'multiple' => 1,
                'return_format' => 'id',
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
                'instructions' => 'How many posts to display',
                'min' => 2,
                'max' => 6,
                'step' => 1,
                'default_value' => 3,
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
            ])
            ->addSelect('grid_columns_desktop', [
                'label' => 'Grid Columns (Desktop)',
                'choices' => Choices::gridColumnsDesktop(),
                'default_value' => 'grid-cols-3',
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

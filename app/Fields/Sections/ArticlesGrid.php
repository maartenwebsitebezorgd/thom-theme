<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\TeamHorizontalCard;
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
                'choices' => [
                    'aspect-square' => '1:1 (Square)',
                    'aspect-[3/2]' => '3:2 (Standard)',
                    'aspect-[4/3]' => '4:3',
                    'aspect-[16/9]' => '16:9 (Wide)',
                    'aspect-[21/9]' => '21:9 (Ultra Wide)',
                ],
                'default_value' => '3/2',
            ])
            ->addSelect('grid_columns_desktop', [
                'label' => 'Grid Columns (Desktop)',
                'choices' => [
                    'grid-cols-2' => '2 Columns',
                    'grid-cols-3' => '3 Columns',
                    'grid-cols-4' => '4 Columns',
                ],
                'default_value' => 'grid-cols-3',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('grid_columns_tablet', [
                'label' => 'Grid Columns (Tablet)',
                'choices' => [
                    'grid-cols-1' => '1 Column',
                    'grid-cols-2' => '2 Columns',
                    'grid-cols-3' => '3 Columns',
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
                'default_value' => 'gap-u-6'
            ])
            ->addGroup('team_card', [
                'label' => 'Team Card',
                'instructions' => 'Optional team member card displayed below the articles',
                'layout' => 'block',
            ])
                ->addFields(TeamHorizontalCard::create('team_horizontal_card'))
            ->endGroup()
            ->addFields(StyleSettings::create('style_settings'));
    }
}

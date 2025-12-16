<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class TeamGrid
{
    /**
     * Creates a 'team_grid' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'team_grid')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Team Grid Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', [
                'alignment' => 'text-center',
            ]))
            ->addTrueFalse('use_all_team', [
                'label' => 'Use All Team Members',
                'instructions' => 'Show all team members automatically',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addPostObject('selected_team', [
                'label' => 'Select Team Members',
                'instructions' => 'Manually select specific team members to display',
                'post_type' => ['team'],
                'multiple' => 1,
                'return_format' => 'id',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_all_team',
                            'operator' => '!=',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addRange('number_of_team', [
                'label' => 'Number of Team Members',
                'instructions' => 'How many team members to display',
                'min' => 2,
                'max' => 12,
                'step' => 1,
                'default_value' => 4,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'use_all_team',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('card_layout', [
                'label' => 'Card Layout',
                'instructions' => 'Choose the card style',
                'choices' => [
                    'standard' => 'Standard (Image on top, content below)',
                    'overlay' => 'Overlay (Image covering with content overlaid)',
                ],
                'default_value' => 'standard',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('image_aspect_ratio', [
                'label' => 'Image Aspect Ratio',
                'choices' => Choices::aspectRatio(),
                'default_value' => 'aspect-[4/5]',
                'wrapper' => ['width' => '50'],
            ])
            ->addTrueFalse('show_email', [
                'label' => 'Show Email',
                'instructions' => 'Display team member email addresses',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33.33'],
            ])
            ->addTrueFalse('show_phone', [
                'label' => 'Show Phone',
                'instructions' => 'Display team member phone numbers',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => ['width' => '33.33'],
            ])
            ->addTrueFalse('show_socials', [
                'label' => 'Show Social Links',
                'instructions' => 'Display team member social media links',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => ['width' => '33.33'],
            ])
            ->addTrueFalse('make_cards_clickable', [
                'label' => 'Make Cards Clickable',
                'instructions' => 'Link entire card to team member detail page',
                'default_value' => 0,
                'ui' => 1,
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

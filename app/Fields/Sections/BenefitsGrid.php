<?php

namespace App\Fields\Sections;

use App\Fields\Components\BenefitCard;
use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class BenefitsGrid
{
    /**
     * Creates a 'benefits_grid' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'benefits_grid')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Benefits Grid Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block'))
            ->addRepeater('cards', [
                'label' => 'Benefit Cards',
                'min' => 2,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Add Benefit Card',
            ])
            ->addFields(BenefitCard::create('benefit_card'))
            ->endRepeater()
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
                'default_value' => 'gap-u-4'
            ])
            ->addFields(StyleSettings::create('style_settings'));
    }
}

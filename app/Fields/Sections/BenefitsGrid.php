<?php

namespace App\Fields\Sections;

use App\Fields\Components\BenefitCard;
use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
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
            ->addFields(ContentWrapper::create('content_block', [
                'heading_tag' => 'h2',
                'heading_text_style' => 'u-text-style-h3',
                'paragraph_text_style' => 'u-text-style-main',
                'margin_bottom' => 'mb-u-6',
            ]))
            ->addRepeater('cards', [
                'label' => 'Benefit Cards',
                'min' => 2,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Add Benefit Card',
            ])
            ->addFields(BenefitCard::create('benefit_card'))
            ->endRepeater()
            ->addSelect('card_theme', [
                'label' => 'Card Theme',
                'choices' => array_merge(
                    ['auto' => 'Auto (Opposite of Section)'],
                    Choices::cardTheme()
                ),
                'default_value' => 'auto',
                'wrapper' => ['width' => '100'],
            ])
            ->addSelect('card_heading_text_style', [
                'label' => 'Card Heading Text Style',
                'choices' => Choices::headingTextStyle(),
                'default_value' => 'u-text-style-h5',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('card_text_style', [
                'label' => 'Card Text Style',
                'choices' => Choices::paragraphTextStyle(),
                'default_value' => 'u-text-style-small',
                'wrapper' => ['width' => '50'],
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

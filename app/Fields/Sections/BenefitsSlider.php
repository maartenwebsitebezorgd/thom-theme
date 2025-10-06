<?php

namespace App\Fields\Sections;

use App\Fields\Components\BenefitCard;
use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Components\SwiperSettings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class BenefitsSlider
{
    /**
     * Creates a 'benefits_slider' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'benefits_slider')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Benefits Slider Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block'))
            ->addRepeater('cards', [
                'label' => 'Benefit Cards',
                'min' => 2,
                'max' => 12,
                'layout' => 'block',
                'button_label' => 'Add Benefit Card',
            ])
                ->addFields(BenefitCard::create('benefit_card'))
            ->endRepeater()
            ->addSelect('card_theme', [
                'label' => 'Card Theme',
                'choices' => [
                    'auto' => 'Auto (Opposite of Section)',
                    'inherit' => 'Inherit',
                    'light' => 'Light',
                    'dark' => 'Dark',
                    'brand' => 'Brand',
                ],
                'default_value' => 'auto',
                'wrapper' => ['width' => '50'],
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
                'wrapper' => ['width' => '50'],
            ])
            ->addFields(SwiperSettings::create('swiper_settings'))
            ->addFields(StyleSettings::create('style_settings'));
    }
}

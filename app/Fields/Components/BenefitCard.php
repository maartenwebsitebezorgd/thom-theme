<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class BenefitCard
{
    /**
     * Creates a 'benefit_card' group field for grid layouts.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'benefit_card')
    {
        $benefitCard = new FieldsBuilder($name);

        $benefitCard
            ->addGroup($name, [
                'label' => 'Benefit Card',
                'layout' => 'block',
            ])
            ->addImage('icon', [
                'label' => 'Icon',
                'instructions' => 'Upload an icon or image for this card',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ])
            ->addText('heading', [
                'label' => 'Heading',
                'required' => 1,
            ])
            ->addWysiwyg('text', [
                'label' => 'Text',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ])
            ->addLink('link', [
                'label' => 'Link',
                'return_format' => 'array',
            ])
            ->addTrueFalse('make_card_clickable', [
                'label' => 'Make Whole Card Clickable',
                'instructions' => 'When enabled, clicking anywhere on the card will navigate to the link',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->endGroup();

        return $benefitCard;
    }
}

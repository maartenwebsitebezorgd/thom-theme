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
            ->addTextarea('text', [
                'label' => 'Text',
                'rows' => 4,
            ])
            ->endGroup();

        return $benefitCard;
    }
}

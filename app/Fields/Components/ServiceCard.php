<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ServiceCard
{
    /**
     * Creates a 'service_card' group field for grid layouts.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'service_card')
    {
        $serviceCard = new FieldsBuilder($name);

        $serviceCard
            ->addGroup($name, [
                'label' => 'Service Card',
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
            ->addLink('link', [
                'label' => 'Link',
                'return_format' => 'array',
            ])
            ->addText('label', [
                'label' => 'Card Label',
                'instructions' => 'Small text label shown in card footer (e.g., "ik wil impact maken")',
                'default_value' => 'ik wil impact maken',
            ])
            ->addTrueFalse('make_card_clickable', [
                'label' => 'Make Whole Card Clickable',
                'instructions' => 'When enabled, clicking anywhere on the card will navigate to the link',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->endGroup();

        return $serviceCard;
    }
}

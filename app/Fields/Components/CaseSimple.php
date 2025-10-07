<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class CaseSimple
{
    /**
     * Creates a 'case_simple' group field.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'case_simple')
    {
        $caseSimple = new FieldsBuilder($name);

        $caseSimple
            ->addGroup($name, [
                'label' => 'Case',
                'layout' => 'block',
            ])
            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'required' => 1,
            ])
            ->addText('client_name', [
                'label' => 'Client Name',
                'placeholder' => 'e.g., Boels',
            ])
            ->addText('title', [
                'label' => 'Title',
                'required' => 1,
            ])
            ->addTextarea('excerpt', [
                'label' => 'Excerpt',
                'rows' => 3,
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

        return $caseSimple;
    }
}

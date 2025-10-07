<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TeamHorizontalCard
{
    /**
     * Creates team horizontal card component fields
     * @param string $name The name of the field group.
     * @return FieldsBuilder
     */
    public static function create($name = 'team_horizontal_card')
    {
        $teamHorizontalCard = new FieldsBuilder($name);

        $teamHorizontalCard
            ->addPostObject('team_member', [
                'label' => 'Team Member',
                'instructions' => 'Select a team member to display',
                'post_type' => ['team'],
                'return_format' => 'id',
                'required' => 1,
            ])
            ->addText('custom_heading', [
                'label' => 'Custom Heading',
                'instructions' => 'Optional custom heading text (e.g., "Neem contact op met Marc om je project te bespreken")',
                'placeholder' => 'Leave empty for default',
            ])
            ->addLink('button', [
                'label' => 'Button',
                'instructions' => 'Optional call-to-action button',
                'return_format' => 'array',
            ]);

        return $teamHorizontalCard;
    }
}

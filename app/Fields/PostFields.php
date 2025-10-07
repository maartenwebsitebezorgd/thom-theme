<?php

namespace App\Fields;

use StoutLogic\AcfBuilder\FieldsBuilder;

class PostFields
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'addFields']);
    }

    public function addFields()
    {
        $postFields = new FieldsBuilder('post_fields');

        $postFields
            ->setLocation('post_type', '==', 'post')
            ->addPostObject('team_member_author', [
                'label' => 'Team Member Author',
                'instructions' => 'Link a team member as the author of this post (optional)',
                'post_type' => ['team'],
                'return_format' => 'id',
                'multiple' => 0,
                'allow_null' => 1,
            ]);

        acf_add_local_field_group($postFields->build());
    }
}

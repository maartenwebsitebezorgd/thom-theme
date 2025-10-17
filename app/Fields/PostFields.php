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
            ->addTab('Author', ['placement' => 'left'])
            ->addPostObject('team_member_author', [
                'label' => 'Team Member Author',
                'instructions' => 'Link a team member as the author of this post (optional)',
                'post_type' => ['team'],
                'return_format' => 'id',
                'multiple' => 0,
                'allow_null' => 1,
            ])
            ->addTab('Single Page Settings', ['placement' => 'left'])
            ->addText('detail_heading', [
                'label' => 'Main Title (Header)',
                'instructions' => 'Custom title for the single post page (leave empty to use post title)',
            ])
            ->addImage('main_image', [
                'label' => 'Main Image (Header)',
                'instructions' => 'Hero image for the post header (leave empty to use featured image)',
                'return_format' => 'array',
                'preview_size' => 'large',
            ])
            ->addWysiwyg('introduction', [
                'label' => 'Introduction',
                'instructions' => 'Introduction text displayed below the header',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ])
            ->addNumber('read_time', [
                'label' => 'Read Time (minutes)',
                'instructions' => 'Estimated reading time in minutes',
                'min' => 1,
                'max' => 60,
                'placeholder' => 'Auto-calculate if left empty',
            ])
            ->addPostObject('related_posts', [
                'label' => 'Related Posts',
                'instructions' => 'Select related posts to display at the end of this post',
                'post_type' => ['post'],
                'multiple' => 1,
                'return_format' => 'object',
                'ui' => 1,
                'filters' => ['search'],
            ]);

        acf_add_local_field_group($postFields->build());
    }
}

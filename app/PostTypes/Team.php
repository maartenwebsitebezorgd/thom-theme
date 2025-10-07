<?php

namespace App\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Team
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('acf/init', [$this, 'addFields']);
    }

    public function registerPostType()
    {
        register_post_type('team', [
            'label' => 'Team',
            'labels' => [
                'name' => 'Team Members',
                'singular_name' => 'Team Member',
                'add_new' => 'Add New Team Member',
                'add_new_item' => 'Add New Team Member',
                'edit_item' => 'Edit Team Member',
                'new_item' => 'New Team Member',
                'view_item' => 'View Team Member',
                'search_items' => 'Search Team Members',
                'not_found' => 'No team members found',
                'not_found_in_trash' => 'No team members found in trash',
            ],
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-groups',
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true,
            'rewrite' => ['slug' => 'team'],
        ]);
    }

    public function addFields()
    {
        $team = new FieldsBuilder('team_fields');

        $team
            ->setLocation('post_type', '==', 'team')
            ->addImage('headshot', [
                'label' => 'Headshot',
                'instructions' => 'Upload a headshot image for avatar/small profile picture',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ])
            ->addText('job_title', [
                'label' => 'Job Title',
                'instructions' => 'e.g., CEO, Developer, Designer',
                'required' => 1,
            ])
            ->addEmail('email', [
                'label' => 'Email Address',
            ])
            ->addText('phone', [
                'label' => 'Phone Number',
            ])
            ->addRepeater('social_links', [
                'label' => 'Social Links',
                'button_label' => 'Add Social Link',
                'layout' => 'table',
            ])
                ->addText('platform', [
                    'label' => 'Platform',
                    'instructions' => 'e.g., LinkedIn, Twitter, GitHub',
                ])
                ->addUrl('url', [
                    'label' => 'URL',
                ])
            ->endRepeater();

        acf_add_local_field_group($team->build());
    }
}

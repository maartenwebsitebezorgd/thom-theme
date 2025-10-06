<?php

namespace App\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Cases
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('acf/init', [$this, 'addFields']);
    }

    public function registerPostType()
    {
        register_post_type('case', [
            'label' => 'Cases',
            'labels' => [
                'name' => 'Cases',
                'singular_name' => 'Case',
                'add_new' => 'Add New Case',
                'add_new_item' => 'Add New Case',
                'edit_item' => 'Edit Case',
                'new_item' => 'New Case',
                'view_item' => 'View Case',
                'search_items' => 'Search Cases',
                'not_found' => 'No cases found',
                'not_found_in_trash' => 'No cases found in trash',
            ],
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true,
            'rewrite' => ['slug' => 'cases'],
        ]);
    }

    public function addFields()
    {
        $cases = new FieldsBuilder('case_fields');

        $cases
            ->setLocation('post_type', '==', 'case')
            ->addImage('logo', [
                'label' => 'Logo',
                'instructions' => 'Upload the company/client logo',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'required' => 1,
            ]);

        acf_add_local_field_group($cases->build());
    }
}

<?php

namespace App\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Logos
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('acf/init', [$this, 'addFields']);
    }

    public function registerPostType()
    {
        register_post_type('logo', [
            'label' => 'Logos',
            'labels' => [
                'name' => 'Logos',
                'singular_name' => 'Logo',
                'add_new' => 'Add New Logo',
                'add_new_item' => 'Add New Logo',
                'edit_item' => 'Edit Logo',
                'new_item' => 'New Logo',
                'view_item' => 'View Logo',
                'search_items' => 'Search Logos',
                'not_found' => 'No logos found',
                'not_found_in_trash' => 'No logos found in trash',
            ],
            'public' => false,
            'show_ui' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-images-alt2',
            'supports' => ['title'],
            'show_in_rest' => true,
            'rewrite' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
        ]);
    }

    public function addFields()
    {
        $logos = new FieldsBuilder('logo_fields');

        $logos
            ->setLocation('post_type', '==', 'logo')
            ->addImage('logo_image', [
                'label' => 'Logo Image',
                'instructions' => 'Upload the logo image (preferably SVG or PNG with transparent background)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'required' => 1,
            ])
            ->addText('company_name', [
                'label' => 'Company Name',
                'instructions' => 'Name of the company (optional, used for alt text if not provided in image)',
            ])
            ->addUrl('website_url', [
                'label' => 'Website URL',
                'instructions' => 'Optional website link for the logo',
            ]);

        acf_add_local_field_group($logos->build());
    }
}

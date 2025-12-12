<?php

namespace App\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Cases
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('init', [$this, 'registerTaxonomies']);
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
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'show_in_rest' => true,
            'rewrite' => ['slug' => 'cases'],
            'taxonomies' => ['case_category', 'case_tag'],
        ]);
    }

    public function registerTaxonomies()
    {
        // Register Case Categories
        register_taxonomy('case_category', ['case'], [
            'label' => 'Case Categories',
            'labels' => [
                'name' => 'Case Categories',
                'singular_name' => 'Case Category',
                'search_items' => 'Search Case Categories',
                'all_items' => 'All Case Categories',
                'parent_item' => 'Parent Case Category',
                'parent_item_colon' => 'Parent Case Category:',
                'edit_item' => 'Edit Case Category',
                'update_item' => 'Update Case Category',
                'add_new_item' => 'Add New Case Category',
                'new_item_name' => 'New Case Category Name',
                'menu_name' => 'Categories',
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => ['slug' => 'case-category'],
        ]);

        // Register Case Tags
        register_taxonomy('case_tag', ['case'], [
            'label' => 'Case Tags',
            'labels' => [
                'name' => 'Case Tags',
                'singular_name' => 'Case Tag',
                'search_items' => 'Search Case Tags',
                'all_items' => 'All Case Tags',
                'edit_item' => 'Edit Case Tag',
                'update_item' => 'Update Case Tag',
                'add_new_item' => 'Add New Case Tag',
                'new_item_name' => 'New Case Tag Name',
                'menu_name' => 'Tags',
            ],
            'hierarchical' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => ['slug' => 'case-tag'],
        ]);
    }

    public function addFields()
    {
        $cases = new FieldsBuilder('case_fields');

        $cases
            ->setLocation('post_type', '==', 'case')
            ->addTab('Client Content', ['placement' => 'left'])
            ->addImage('logo', [
                'label' => 'Client Logo',
                'instructions' => 'Upload the company/client logo (displayed on case cards)',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ])
            ->addText('client_name', [
                'label' => 'Client Name',
                'instructions' => 'Name of the client/company',
            ])
            ->addTab('Detail Page', ['placement' => 'left'])
            ->addImage('main_image', [
                'label' => 'Main Image',
                'instructions' => 'Hero image for the case detail page (leave empty to use featured image)',
                'return_format' => 'array',
                'preview_size' => 'large',
            ])
            ->addText('detail_heading', [
                'label' => 'Detail Page Heading',
                'instructions' => 'Custom heading for detail page (leave empty to use post title)',
            ])
            ->addWysiwyg('introduction', [
                'label' => 'Introduction',
                'instructions' => 'Introduction text for the detail page',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ])
            ->addTab('Team & Relations', ['placement' => 'left'])
            ->addPostObject('team_members', [
                'label' => 'Team Members',
                'instructions' => 'Select team members who worked on this case',
                'post_type' => ['team'],
                'multiple' => 1,
                'return_format' => 'object',
                'ui' => 1,
            ])
            ->addPostObject('related_cases', [
                'label' => 'Related Cases',
                'instructions' => 'Select related cases to recommend (optional - shown at bottom of case detail page)',
                'post_type' => ['case'],
                'multiple' => 1,
                'return_format' => 'object',
                'ui' => 1,
                'filters' => ['search'],
            ]);

        acf_add_local_field_group($cases->build());
    }
}

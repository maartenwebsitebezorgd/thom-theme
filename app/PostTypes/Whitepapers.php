<?php

namespace App\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Whitepapers
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('acf/init', [$this, 'addFields']);
    }

    public function registerPostType()
    {
        register_post_type('whitepaper', [
            'label' => 'Whitepapers',
            'labels' => [
                'name' => 'Whitepapers',
                'singular_name' => 'Whitepaper',
                'add_new' => 'Add New Whitepaper',
                'add_new_item' => 'Add New Whitepaper',
                'edit_item' => 'Edit Whitepaper',
                'new_item' => 'New Whitepaper',
                'view_item' => 'View Whitepaper',
                'search_items' => 'Search Whitepapers',
                'not_found' => 'No whitepapers found',
                'not_found_in_trash' => 'No whitepapers found in trash',
            ],
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-media-document',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'show_in_rest' => true,
            'rewrite' => ['slug' => 'whitepapers'],
        ]);
    }

    public function addFields()
    {
        $whitepaperFields = new FieldsBuilder('whitepaper_fields');

        $whitepaperFields
            ->setLocation('post_type', '==', 'whitepaper')
            ->addTab('Form Settings', ['placement' => 'left'])
            ->addImage('form_image', [
                'label' => 'Form Image',
                'instructions' => 'Image displayed in the left column of the form section',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ])
            ->addSelect('gravity_form', [
                'label' => 'Whitepaper Form',
                'instructions' => 'Select the Gravity Form for whitepaper download requests',
                'choices' => $this->getGravityForms(),
                'allow_null' => 0,
                'ui' => 1,
                'return_format' => 'value',
                'required' => 1,
            ])
            ->addText('form_heading', [
                'label' => 'Form Heading',
                'instructions' => 'Heading text for the form section',
                'default_value' => 'Vraag de whitepaper aan',
            ])
            ->addTextarea('form_paragraph', [
                'label' => 'Form Paragraph',
                'instructions' => 'Paragraph text for the form section',
                'rows' => 3,
                'default_value' => 'Laat je gegevens achter om de whitepaper te downloaden!',
            ]);

        acf_add_local_field_group($whitepaperFields->build());
    }

    /**
     * Get all Gravity Forms for ACF select field
     */
    private function getGravityForms()
    {
        $forms = [];

        if (class_exists('GFAPI')) {
            $gravity_forms = \GFAPI::get_forms();
            foreach ($gravity_forms as $form) {
                $forms[$form['id']] = $form['title'];
            }
        }

        return $forms;
    }
}
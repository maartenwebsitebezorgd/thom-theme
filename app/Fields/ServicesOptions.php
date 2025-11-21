<?php

namespace App\Fields;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ServicesOptions
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'addOptionsPage']);
        add_action('acf/init', [$this, 'addFields']);
        add_filter('acf/load_field/name=selected_services', [$this, 'loadServiceChoices']);
        add_filter('acf/load_field/name=service', [$this, 'loadServiceChoices']);
    }

    public function loadServiceChoices($field)
    {
        $field['choices'] = [];

        $globalServices = get_field('global_services', 'option');

        if ($globalServices) {
            foreach ($globalServices as $index => $service) {
                $heading = $service['heading'] ?? 'Service ' . ($index + 1);
                $field['choices'][$index] = $heading;
            }
        }

        return $field;
    }

    public function addOptionsPage()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Services',
                'menu_title' => 'Services',
                'menu_slug' => 'services-options',
                'capability' => 'edit_posts',
                'icon_url' => 'dashicons-grid-view',
                'position' => 30,
                'redirect' => false,
            ]);
        }
    }

    public function addFields()
    {
        $servicesOptions = new FieldsBuilder('services_options');

        $servicesOptions
            ->setLocation('options_page', '==', 'services-options')
            ->addRepeater('global_services', [
                'label' => 'Global Services',
                'instructions' => 'Define your default services that can be used across the site. Drag rows to reorder.',
                'layout' => 'row',
                'button_label' => 'Add Service',
                'collapsed' => 'heading',
            ])
            ->addImage('icon', [
                'label' => 'Icon',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'wrapper' => ['width' => '15'],
            ])
            ->addText('heading', [
                'label' => 'Heading',
                'required' => 1,
                'wrapper' => ['width' => '25'],
            ])
            ->addTextarea('text', [
                'label' => 'Description',
                'rows' => 2,
                'wrapper' => ['width' => '35'],
            ])
            ->addLink('link', [
                'label' => 'Link',
                'return_format' => 'array',
                'wrapper' => ['width' => '15'],
            ])
            ->addText('label', [
                'label' => 'Footer Label',
                'default_value' => 'ik wil impact maken',
                'wrapper' => ['width' => '10'],
            ])
            ->endRepeater();

        acf_add_local_field_group($servicesOptions->build());
    }
}

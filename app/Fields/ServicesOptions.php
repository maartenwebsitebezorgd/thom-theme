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
                'instructions' => 'Define your default services that can be used across the site',
                'layout' => 'block',
                'button_label' => 'Add Service',
            ])
            ->addImage('icon', [
                'label' => 'Icon',
                'instructions' => 'Upload an icon or image for this service',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ])
            ->addText('heading', [
                'label' => 'Heading',
                'required' => 1,
            ])
            ->addTextarea('text', [
                'label' => 'Text',
                'rows' => 4,
            ])
            ->addLink('link', [
                'label' => 'link',
                'instructions' => 'Link to service page',
                'rows' => 1,
            ])
            ->addText('label', [
                'label' => 'Card Label',
                'instructions' => 'Small text label shown in card footer (e.g., "ik wil impact maken")',
                'default_value' => 'ik wil impact maken',
            ])
            ->endRepeater();

        acf_add_local_field_group($servicesOptions->build());
    }
}

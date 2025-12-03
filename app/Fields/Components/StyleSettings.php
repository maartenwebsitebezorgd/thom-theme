<?php

namespace App\Fields\Components;

use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class StyleSettings
{
    /**
     * Creates a 'style_settings' group field.
     * @param string $name The name of the group field.
     * @param array $defaults Override default values for specific contexts
     * @return FieldsBuilder
     */
    public static function create($name = 'style_settings', $defaults = [])
    {
        // Merge with default values
        $defaults = array_merge([
            'theme' => 'inherit',
            'background_color' => '',
            'padding_top' => 'pt-section-main',
            'padding_bottom' => 'pb-section-main',
        ], $defaults);

        $styleSettings = new FieldsBuilder($name);

        $styleSettings
            ->addGroup($name, [
                'label' => 'Section Style Settings',
                'layout' => 'block',
            ])
            ->addTab('Style', ['placement' => 'left'])
            ->addSelect('theme', [
                'label' => 'Theme',
                'choices' => Choices::theme(),
                'default_value' => $defaults['theme'],
                'wrapper' => ['width' => '100'],
            ])
            ->addSelect('container_size', [
                'label' => 'Container Size',
                'choices' => Choices::containerSize(),
                'default_value' => $defaults['container_size'] ?? 'max-w-container-main',
                'wrapper' => ['width' => '100'],
            ])
            ->addSelect('padding_top', [
                'label' => 'Padding Top',
                'choices' => Choices::paddingTop(),
                'default_value' => $defaults['padding_top'],
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('padding_bottom', [
                'label' => 'Padding Bottom',
                'choices' => Choices::paddingBottom(),
                'default_value' => $defaults['padding_bottom'],
                'wrapper' => ['width' => '50'],
            ])
            ->endGroup();

        return $styleSettings;
    }
}

<?php

namespace App\Fields\Components;

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
            'theme' => 'default',
            'background_color' => '',
            'padding_top' => 'pt-section-main',
            'padding_bottom' => 'pb-section-main',
        ], $defaults);

        $styleSettings = new FieldsBuilder($name);

        $styleSettings
            ->addGroup($name, [
                'label' => 'Style Settings',
                'layout' => 'block',
            ])
                ->addTab('Style', ['placement' => 'left'])
                    ->addSelect('theme', [
                        'label' => 'Theme',
                        'choices' => [
                            'inherit' => 'Inherit',
                            'light' => 'Light',
                            'dark' => 'Dark',
                            'brand' => 'Brand',
                        ],
                        'default_value' => $defaults['theme'],
                        'wrapper' => ['width' => '25'],
                    ])
                    ->addSelect('background_color', [
                        'label' => 'Background Color',
                        'choices' => [
                            '' => 'None',
                            'u-background-1' => 'Background One',
                            'u-background-2' => 'Background Two',
                        ],
                        'default_value' => $defaults['background_color'],
                        'wrapper' => ['width' => '25'],
                    ])
                    ->addSelect('padding_top', [
                        'label' => 'Padding Top',
                        'choices' => [
                            'pt-section-none' => 'None',
                            'pt-section-small' => 'Small',
                            'pt-section-main' => 'Main',
                            'pt-section-medium' => 'Medium',
                            'pt-section-large' => 'Large',
                        ],
                        'default_value' => $defaults['padding_top'],
                        'wrapper' => ['width' => '25'],
                    ])
                    ->addSelect('padding_bottom', [
                        'label' => 'Padding Bottom',
                        'choices' => [
                            'pb-section-none' => 'None',
                            'pb-section-small' => 'Small',
                            'pb-section-main' => 'Main',
                            'pb-section-medium' => 'Medium',
                            'pb-section-large' => 'Large',
                        ],
                        'default_value' => $defaults['padding_bottom'],
                        'wrapper' => ['width' => '25'],
                    ])
                    ->addTrueFalse('enable_clip_path', [
                        'label' => 'Enable Clip Path',
                        'instructions' => 'Enable to apply a decorative clip path effect to the section.',
                        'default_value' => 0,
                        'ui' => 1,
                        'wrapper' => ['width' => '25'],
                    ])
            ->endGroup();

        return $styleSettings;
    }
}

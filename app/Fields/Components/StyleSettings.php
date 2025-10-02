<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class StyleSettings
{
    /**
     * Creates a 'style_settings' group field.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'style_settings')
    {
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
                        'default_value' => 'default',
                        'wrapper' => ['width' => '25'],
                    ])
                    ->addSelect('background_color', [
                        'label' => 'Background Color',
                        'choices' => [
                            '' => 'None',
                            'u-background-1' => 'Background One',
                            'u-background-2' => 'Background Two',
                        ],
                        'default_value' => '',
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
                        'default_value' => 'pt-section-main',
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
                        'default_value' => 'pb-section-main',
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

<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ContentWrapper
{
    /**
     * Creates a 'content_wrapper' group field.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'content_wrapper')
    {
        $contentWrapper = new FieldsBuilder($name);

        $contentWrapper
            ->addGroup($name, [
                'label' => 'Content Block',
                'layout' => 'block',
            ])
                ->addTab('Content', ['placement' => 'left'])
                    ->addText('eyebrow', [
                        'label' => 'Eyebrow Text',
                    ])
                    ->addText('heading', [
                        'label' => 'Heading',
                    ])
                    ->addWysiwyg('paragraph', [
                        'label' => 'Paragraph',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ])
                    ->addRepeater('button_group', [
                        'label' => 'Button Group',
                        'layout' => 'table',
                        'button_label' => 'Add Button',
                        'min' => 0,
                    ])
                        ->addLink('button', [
                            'label' => 'Button',
                        ])
                        ->addSelect('style', [
                            'label' => 'Style',
                            'choices' => [
                                'primary' => 'Primary',
                                'secondary' => 'Secondary'
                            ],
                            'default_value' => 'primary',
                        ])
                    ->endRepeater()

                ->addTab('Settings', ['placement' => 'left'])
                    ->addSelect('alignment', [
                        'label' => 'Text Alignment',
                        'choices' => [
                            'text-left' => 'Left',
                            'text-center' => 'Center',
                            'text-right' => 'Right',
                        ],
                        'default_value' => 'text-left',
                        'wrapper' => ['width' => '33'],
                    ])
                    ->addSelect('heading_tag', [
                        'label' => 'Heading Tag',
                        'choices' => [
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'p' => 'p',
                            'div' => 'div',
                        ],
                        'default_value' => 'h2',
                        'wrapper' => ['width' => '33'],
                    ])
                    ->addSelect('heading_text_style', [
                        'label' => 'Heading Text Style',
                        'instructions' => 'e.g., h1, h2, large',
                        'choices' => [
                            'display' => 'Display',
                            'u-text-style-h1' => 'H1 Style',
                            'u-text-style-h2' => 'H2 Style',
                            'u-text-style-h3' => 'H3 Style',
                            'u-text-style-h4' => 'H4 Style',
                            'u-text-style-h5' => 'H5 Style',
                            'u-text-style-h6' => 'H6 Style',
                        ],
                        'default_value' => 'u-text-style-h2',
                        'wrapper' => ['width' => '33'],
                    ])
                    ->addSelect('paragraph_text_style', [
                        'label' => 'Paragraph Text Style',
                        'instructions' => 'e.g., small, large',
                        'choices' => [
                            'u-text-style-small' => 'Small Style',
                            'u-text-style-main' => 'Main Style',
                            'u-text-style-medium' => 'Medium Style',
                            'u-text-style-large' => 'Large Style',
                        ],
                        'default_value' => 'u-text-style-main',
                        'wrapper' => ['width' => '33'],
                    ])
            ->endGroup();

        return $contentWrapper;
    }
}
<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class SplitForm
{
    public static function addToFlexibleContent($flexibleContent, $name = 'split_form')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Split Form Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', defaults: [
                'margin_bottom' => 'mb-0',
            ]))
            ->addTrueFalse('show_contact_person', [
                'label' => 'Show Contact Person',
                'instructions' => 'Display a team member as contact person below the content',
                'default_value' => 0,
                'ui' => 1,
            ])
            ->addPostObject('contact_person', [
                'label' => 'Contact Person',
                'instructions' => 'Select a team member to display as contact person',
                'post_type' => ['team'],
                'return_format' => 'id',
                'multiple' => 0,
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'show_contact_person',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addSelect('gravity_form', [
                'label' => 'Gravity Form',
                'instructions' => 'Select a Gravity Form to display',
                'choices' => self::getGravityForms(),
                'allow_null' => 1,
                'ui' => 1,
                'return_format' => 'value',
            ])
            ->addTrueFalse('form_title', [
                'label' => 'Show Form Title',
                'default_value' => 0,
                'ui' => 1,
            ])
            ->addTrueFalse('form_description', [
                'label' => 'Show Form Description',
                'default_value' => 0,
                'ui' => 1,
            ])
            ->addFields(StyleSettings::create(
                'style_settings',
                [
                    'theme' => 'accent',
                ]
            ))
            ->addSelect('content_layout', [
                'label' => 'Content Layout',
                'choices' => [
                    'form-right' => 'Content Left, Form Right',
                    'form-left' => 'Content Right, Form Left',
                ],
                'default_value' => 'form-right'
            ])
            ->addSelect('vertical_alignment', [
                'label' => 'Vertical Alignment',
                'choices' => [
                    'items-start' => 'Top',
                    'items-center' => 'Center',
                    'items-end' => 'Bottom',
                ],
                'default_value' => 'items-start'
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Between Columns',
                'choices' => Choices::spacing(),
                'default_value' => 'gap-u-6'
            ])
            ->addSelect('column_width', [
                'label' => 'Column Width Ratio',
                'choices' => [
                    '1:1' => '50/50 (Equal)',
                    '1:2' => '33/66 (Content Narrow)',
                    '2:1' => '66/33 (Form Narrow)',
                ],
                'default_value' => '1:1'
            ]);
    }

    /**
     * Get all Gravity Forms for ACF select field
     */
    private static function getGravityForms()
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

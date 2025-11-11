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
            ->addFields(StyleSettings::create('style_settings'))
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

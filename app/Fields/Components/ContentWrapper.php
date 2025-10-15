<?php

namespace App\Fields\Components;

use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContentWrapper
{
    /**
     * Creates a 'content_wrapper' group field.
     * @param string $name The name of the group field.
     * @param array $defaults Override default values for specific contexts
     * @return FieldsBuilder
     */
    public static function create($name = 'content_wrapper', $defaults = [])
    {
        // Merge with default values
        $defaults = array_merge([
            'alignment' => 'text-left',
            'heading_tag' => 'h2',
            'heading_text_style' => 'u-text-style-h2',
            'paragraph_text_style' => 'u-text-style-main',
            'margin_bottom' => 'mb-u-6',
        ], $defaults);

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
                'choices' => Choices::buttonStyle(),
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
                'default_value' => $defaults['alignment'],
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
                'default_value' => $defaults['heading_tag'],
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('heading_text_style', [
                'label' => 'Heading Text Style',
                'choices' => Choices::headingTextStyle(),
                'default_value' => $defaults['heading_text_style'],
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('paragraph_text_style', [
                'label' => 'Paragraph Text Style',
                'choices' => Choices::paragraphTextStyle(),
                'default_value' => $defaults['paragraph_text_style'],
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('max_width', [
                'label' => 'Max Width',
                'choices' => Choices::maxWidth(),
                'default_value' => 'u-max-width-70ch',
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('margin_bottom', [
                'label' => 'Margin Bottom',
                'choices' => Choices::marginBottom(),
                'default_value' => $defaults['margin_bottom'],
                'wrapper' => ['width' => '33'],
            ])
            ->endGroup();

        return $contentWrapper;
    }
}

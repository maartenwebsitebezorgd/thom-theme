<?php

namespace App\Fields\Sections;

use App\Fields\Components\ContentWrapper;
use App\Fields\Components\StyleSettings;
use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class TeamContactCta
{
    /**
     * Creates a 'team_contact_cta' layout for flexible content.
     * @param string $name The name of the layout.
     * @return FieldsBuilder
     */
    public static function addToFlexibleContent($flexibleContent, $name = 'team_contact_cta')
    {
        return $flexibleContent
            ->addLayout($name, [
                'label' => 'Team Contact CTA Section',
                'display' => 'block'
            ])
            ->addFields(ContentWrapper::create('content_block', defaults: [
                'margin_bottom' => 'mb-0',
                'heading_text_style' => 'u-text-style-h2',
                'heading_tag' => 'h2',
            ]))
            ->addPostObject('team_member', [
                'label' => 'Team Member',
                'instructions' => 'Select the team member expert for this service',
                'post_type' => ['team'],
                'return_format' => 'id',
                'multiple' => 0,
                'required' => 1,
                'ui' => 1,
            ])
            ->addFields(StyleSettings::create('style_settings', defaults: [
                'theme' => 'accent-light',
                'padding_top' => 'pt-section-small',
                'padding_bottom' => 'pb-section-small',
            ]))
            ->addSelect('content_layout', [
                'label' => 'Content Layout',
                'choices' => [
                    'member-left' => 'Team Member Left, Content Right',
                    'member-right' => 'Team Member Right, Content Left',
                ],
                'default_value' => 'member-left'
            ])
            ->addSelect('vertical_alignment', [
                'label' => 'Vertical Alignment',
                'choices' => [
                    'justify-start' => 'Top',
                    'justify-center' => 'Center',
                    'justify-end' => 'Bottom',
                ],
                'default_value' => 'justify-center'
            ])
            ->addSelect('gap_size', [
                'label' => 'Gap Between Columns',
                'choices' => Choices::spacing(),
                'default_value' => 'gap-u-5'
            ])
            ->addSelect('member_name_text_style', [
                'label' => 'Member Name Text Style',
                'choices' => Choices::headingTextStyle(),
                'default_value' => 'u-text-style-h5',
            ])
            ->addSelect('image_aspect_ratio', [
                'label' => 'Image Aspect Ratio',
                'choices' => Choices::aspectRatio(),
                'default_value' => 'aspect-[5/4]',
            ])
            ->addSelect('content_wrap_theme', [
                'label' => 'Content Wrapper Theme',
                'choices' => Choices::theme(),
                'default_value' => 'light',
            ])
            ->addSelect('wrapper_max_width', [
                'label' => 'Wrapper Max Width',
                'instructions' => 'Maximum width of the content wrapper',
                'choices' => [
                    'max-w-full' => 'Full Width',
                    'max-w-7xl' => 'Extra Large (1280px)',
                    'max-w-6xl' => 'Large (1152px)',
                    'max-w-5xl' => 'Medium (1024px)',
                    'max-w-4xl' => 'Small (896px)',
                    'max-w-3xl' => 'Extra Small (768px)',
                ],
                'default_value' => 'max-w-full',
            ]);
    }
}

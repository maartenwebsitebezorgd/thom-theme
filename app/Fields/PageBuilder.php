<?php

namespace App\Fields;

use App\Fields\Sections\Hero;
use App\Fields\Sections\ImageGallery;
use App\Fields\Sections\SplitContent;
use StoutLogic\AcfBuilder\FieldsBuilder;

class PageBuilder
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'addFields']);
    }

    public function addFields()
    {
        $pageBuilder = new FieldsBuilder('page_builder');
        
        $flexibleContent = $pageBuilder
            ->addFlexibleContent('content_blocks', [
                'label' => 'Page Content',
                'instructions' => 'Build your page by adding content blocks below.',
                'button_label' => 'Add Content Block'
            ]);

        // Add sections to flexible content
        $flexibleContent = Hero::addToFlexibleContent($flexibleContent);
        $flexibleContent = SplitContent::addToFlexibleContent($flexibleContent);
        $flexibleContent = ImageGallery::addToFlexibleContent($flexibleContent);

        $flexibleContent
                ->addLayout('call_to_action', [
                    'label' => 'Call to Action',
                    'display' => 'block'
                ])
                    ->addText('heading', [
                        'label' => 'CTA Heading'
                    ])
                    ->addTextarea('description', [
                        'label' => 'Description',
                        'rows' => 3
                    ])
                    ->addLink('button', [
                        'label' => 'Button',
                        'return_format' => 'array'
                    ])
                    ->addColorPicker('background_color', [
                        'label' => 'Background Color',
                        'default_value' => '#3b82f6'
                    ])
                    ->addSelect('text_alignment', [
                        'label' => 'Text Alignment',
                        'choices' => [
                            'text-center' => 'Center',
                            'text-left' => 'Left',
                            'text-right' => 'Right'
                        ],
                        'default_value' => 'text-center'
                    ])

                ->addLayout('two_column', [
                    'label' => 'Two Column Layout',
                    'display' => 'block'
                ])
                    ->addText('heading', [
                        'label' => 'Section Heading'
                    ])
                    ->addWysiwyg('left_content', [
                        'label' => 'Left Column Content',
                        'toolbar' => 'basic'
                    ])
                    ->addWysiwyg('right_content', [
                        'label' => 'Right Column Content',
                        'toolbar' => 'basic'
                    ])
                    ->addSelect('column_ratio', [
                        'label' => 'Column Ratio',
                        'choices' => [
                            '1:1' => '50/50',
                            '2:1' => '66/33',
                            '1:2' => '33/66'
                        ],
                        'default_value' => '1:1'
                    ])

            ->setLocation('post_type', '==', 'page')
                ->and('page_template', '!=', 'page-templates/no-builder.blade.php'); // Exclude certain templates if needed

        acf_add_local_field_group($pageBuilder->build());
    }
}
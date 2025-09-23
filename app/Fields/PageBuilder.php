<?php

namespace App\Fields;

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
        
        $pageBuilder
            ->addFlexibleContent('content_blocks', [
                'label' => 'Page Content',
                'instructions' => 'Build your page by adding content blocks below.',
                'button_label' => 'Add Content Block'
            ])
                ->addLayout('hero', [
                    'label' => 'Hero Section',
                    'display' => 'block'
                ])
                    ->addText('title', [
                        'label' => 'Hero Title',
                        'instructions' => 'Main heading for the hero section'
                    ])
                    ->addTextarea('subtitle', [
                        'label' => 'Hero Subtitle',
                        'instructions' => 'Supporting text below the title'
                    ])
                    ->addImage('background_image', [
                        'label' => 'Background Image',
                        'return_format' => 'array'
                    ])
                    ->addSelect('text_color', [
                        'label' => 'Text Color',
                        'choices' => [
                            'white' => 'White',
                            'black' => 'Black'
                        ],
                        'default_value' => 'white'
                    ])
                    ->addSelect('height', [
                        'label' => 'Section Height',
                        'choices' => [
                            'min-h-screen' => 'Full Screen',
                            'min-h-[70vh]' => 'Large',
                            'min-h-[50vh]' => 'Medium'
                        ],
                        'default_value' => 'min-h-screen'
                    ])

                ->addLayout('content_section', [
                    'label' => 'Content Section',
                    'display' => 'block'
                ])
                    ->addText('heading', [
                        'label' => 'Section Heading',
                        'instructions' => 'Optional heading for this section'
                    ])
                    ->addWysiwyg('content', [
                        'label' => 'Content',
                        'instructions' => 'Rich text content for this section',
                        'media_upload' => 1,
                        'toolbar' => 'full'
                    ])
                    ->addSelect('layout', [
                        'label' => 'Content Layout',
                        'choices' => [
                            'center' => 'Centered',
                            'left' => 'Left Aligned',
                            'wide' => 'Full Width'
                        ],
                        'default_value' => 'center'
                    ])
                    ->addSelect('background_color', [
                        'label' => 'Background Color',
                        'choices' => [
                            'bg-white' => 'White',
                            'bg-gray-50' => 'Light Gray',
                            'bg-gray-100' => 'Gray'
                        ],
                        'default_value' => 'bg-white'
                    ])

                ->addLayout('image_gallery', [
                    'label' => 'Image Gallery',
                    'display' => 'block'
                ])
                    ->addText('heading', [
                        'label' => 'Gallery Heading'
                    ])
                    ->addGallery('images', [
                        'label' => 'Gallery Images',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all'
                    ])
                    ->addSelect('columns', [
                        'label' => 'Columns',
                        'choices' => [
                            '2' => '2 Columns',
                            '3' => '3 Columns',
                            '4' => '4 Columns'
                        ],
                        'default_value' => '3'
                    ])
                    ->addSelect('aspect_ratio', [
                        'label' => 'Image Aspect Ratio',
                        'choices' => [
                            'aspect-square' => 'Square',
                            'aspect-[4/3]' => '4:3',
                            'aspect-[16/9]' => '16:9'
                        ],
                        'default_value' => 'aspect-square'
                    ])

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
<?php

namespace App\Fields;

use App\Fields\Sections\ArticlesGrid;
use App\Fields\Sections\BenefitsGrid;
use App\Fields\Sections\BlogsSlider;
use App\Fields\Sections\Breadcrumb;
use App\Fields\Sections\Cta;
use App\Fields\Sections\Hero;
use App\Fields\Sections\ImageGallery;
use App\Fields\Sections\LogoSlider;
use App\Fields\Sections\MultiSlider;
use App\Fields\Sections\Quote;
use App\Fields\Sections\ServicesGrid;
use App\Fields\Sections\ServicesLine;
use App\Fields\Sections\SplitContent;
use App\Fields\Sections\SplitForm;
use App\Fields\Sections\StackedContent;
use App\Fields\Sections\TeamContactCta;
use App\Fields\Sections\TeamGrid;
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
        $flexibleContent = Breadcrumb::addToFlexibleContent($flexibleContent);
        $flexibleContent = SplitContent::addToFlexibleContent($flexibleContent);
        $flexibleContent = StackedContent::addToFlexibleContent($flexibleContent);
        $flexibleContent = SplitForm::addToFlexibleContent($flexibleContent);
        $flexibleContent = Quote::addToFlexibleContent($flexibleContent);
        $flexibleContent = Cta::addToFlexibleContent($flexibleContent);
        $flexibleContent = TeamContactCta::addToFlexibleContent($flexibleContent);
        $flexibleContent = ArticlesGrid::addToFlexibleContent($flexibleContent);
        $flexibleContent = TeamGrid::addToFlexibleContent($flexibleContent);
        $flexibleContent = BenefitsGrid::addToFlexibleContent($flexibleContent);
        $flexibleContent = BlogsSlider::addToFlexibleContent($flexibleContent);
        $flexibleContent = MultiSlider::addToFlexibleContent($flexibleContent);
        $flexibleContent = ServicesGrid::addToFlexibleContent($flexibleContent);
        $flexibleContent = ServicesLine::addToFlexibleContent($flexibleContent);
        $flexibleContent = LogoSlider::addToFlexibleContent($flexibleContent);
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

        // Build and modify the field group to hide the content editor
        $fieldGroup = $pageBuilder->build();
        $fieldGroup['hide_on_screen'] = ['the_content'];

        acf_add_local_field_group($fieldGroup);
    }
}
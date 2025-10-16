<?php

namespace App\Fields;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TaxonomyFields
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'addCategoryFields']);
        add_action('acf/init', [$this, 'addCaseCategoryFields']);
    }

    /**
     * Add image field to post categories
     */
    public function addCategoryFields()
    {
        $category = new FieldsBuilder('category_fields');

        $category
            ->setLocation('taxonomy', '==', 'category')
            ->addImage('category_image', [
                'label' => 'Category Image',
                'instructions' => 'Upload an image for this category (displayed on archive pages)',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ]);

        acf_add_local_field_group($category->build());
    }

    /**
     * Add image field to case categories
     */
    public function addCaseCategoryFields()
    {
        $caseCategory = new FieldsBuilder('case_category_fields');

        $caseCategory
            ->setLocation('taxonomy', '==', 'case_category')
            ->addImage('category_image', [
                'label' => 'Category Image',
                'instructions' => 'Upload an image for this case category (displayed on archive pages)',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ]);

        acf_add_local_field_group($caseCategory->build());
    }
}

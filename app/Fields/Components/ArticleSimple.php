<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ArticleSimple
{
    /**
     * Creates an 'article_simple' group field.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'article_simple')
    {
        $articleSimple = new FieldsBuilder($name);

        $articleSimple
            ->addGroup($name, [
                'label' => 'Article',
                'layout' => 'block',
            ])
            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'required' => 1,
            ])
            ->addText('category', [
                'label' => 'Category',
                'placeholder' => 'e.g., Branding',
            ])
            ->addText('title', [
                'label' => 'Title',
                'required' => 1,
            ])
            ->addTextarea('excerpt', [
                'label' => 'Excerpt',
                'rows' => 3,
            ])
            ->addLink('link', [
                'label' => 'Link',
                'return_format' => 'array',
            ])
            ->addTrueFalse('make_card_clickable', [
                'label' => 'Make Whole Card Clickable',
                'instructions' => 'When enabled, clicking anywhere on the card will navigate to the link',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->endGroup();

        return $articleSimple;
    }
}

<?php

namespace App\Fields\Components;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Background
{
    /**
     * Creates a 'background' group field for background images/videos.
     * @param string $name The name of the group field.
     * @return FieldsBuilder
     */
    public static function create($name = 'background')
    {
        $background = new FieldsBuilder($name);

        $background
            ->addGroup($name, [
                'label' => 'Background',
                'layout' => 'block',
            ])
                ->addTab('Media', ['placement' => 'left'])
                    ->addImage('image', [
                        'label' => 'Background Image',
                        'instructions' => 'Upload your background image. WebP format recommended for best performance.',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                    ])
                    ->addUrl('video_url', [
                        'label' => 'Background Video URL (Optional)',
                        'instructions' => 'YouTube, Vimeo, or direct MP4 URL. Will override image if provided.',
                    ])

                ->addTab('Settings', ['placement' => 'left'])
                    ->addSelect('position', [
                        'label' => 'Background Position',
                        'choices' => [
                            'bg-center' => 'Center',
                            'bg-top' => 'Top',
                            'bg-bottom' => 'Bottom',
                            'bg-left' => 'Left',
                            'bg-right' => 'Right',
                        ],
                        'default_value' => 'bg-center',
                        'wrapper' => ['width' => '50'],
                    ])
                    ->addSelect('size', [
                        'label' => 'Background Size',
                        'choices' => [
                            'bg-cover' => 'Cover (Fill container)',
                            'bg-contain' => 'Contain (Show full image)',
                            'bg-auto' => 'Auto (Original size)',
                        ],
                        'default_value' => 'bg-cover',
                        'wrapper' => ['width' => '50'],
                    ])
                    ->addTrueFalse('fixed', [
                        'label' => 'Fixed Background (Parallax)',
                        'instructions' => 'Keep background fixed while content scrolls',
                        'default_value' => 0,
                        'wrapper' => ['width' => '33'],
                    ])
                    ->addRange('overlay_opacity', [
                        'label' => 'Overlay Opacity',
                        'instructions' => 'Dark overlay for better text readability',
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                        'default_value' => 40,
                        'append' => '%',
                        'wrapper' => ['width' => '33'],
                    ])
                    ->addColorPicker('overlay_color', [
                        'label' => 'Overlay Color',
                        'default_value' => '#000000',
                        'wrapper' => ['width' => '33'],
                    ])

                ->addTab('Performance', ['placement' => 'left'])
                    ->addTrueFalse('lazy_loading', [
                        'label' => 'Lazy Loading',
                        'instructions' => 'Load image only when it comes into view (recommended: OFF for hero backgrounds)',
                        'default_value' => 0,
                        'wrapper' => ['width' => '50'],
                    ])
                    ->addTrueFalse('priority_loading', [
                        'label' => 'Priority Loading',
                        'instructions' => 'Load this image immediately (recommended: ON for hero backgrounds)',
                        'default_value' => 1,
                        'wrapper' => ['width' => '50'],
                    ])

            ->endGroup();

        return $background;
    }
}
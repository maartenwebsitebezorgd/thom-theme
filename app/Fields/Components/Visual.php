<?php

namespace App\Fields\Components;

use App\Fields\Helpers\Choices;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Visual
{
    /**
     * Creates a 'visual' group field optimized for performance.
     * @param string $name The name of the group field.
     * @param array $defaults Override default values for any field.
     * @return FieldsBuilder
     */
    public static function create($name = 'visual', array $defaults = [])
    {
        $visual = new FieldsBuilder($name);

        $visual
            ->addGroup($name, [
                'label' => 'Visual Component',
                'layout' => 'block',
            ])
            ->addTab('Media', ['placement' => 'left'])
            ->addImage('image', [
                'label' => 'Image',
                'instructions' => 'Upload your main image. WebP format recommended for best performance.',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ])
            ->addText('alt_text', [
                'label' => 'Alt Text',
                'instructions' => 'Describe the image for accessibility. If empty, will use image alt text.',
            ])
            ->addUrl('video_url', [
                'label' => 'Video URL (Optional)',
                'instructions' => 'YouTube, Vimeo, or direct MP4 URL. Will override image if provided.',
            ])
            ->addTextarea('caption', [
                'label' => 'Caption (Optional)',
                'rows' => 2,
            ])

            ->addTab('Layout', ['placement' => 'left'])
            ->addSelect('aspect_ratio', [
                'label' => 'Aspect Ratio',
                'choices' => array_merge(
                    Choices::aspectRatio(),
                    [
                        'aspect-[2/1]' => '2:1 (Banner)',
                        'aspect-auto' => 'Auto (Original)',
                    ]
                ),
                'default_value' => $defaults['aspect_ratio'] ?? 'aspect-[16/9]',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('object_fit', [
                'label' => 'Object Fit',
                'choices' => [
                    'object-cover' => 'Cover (Crop to fill)',
                    'object-contain' => 'Contain (Show full image)',
                    'object-fill' => 'Fill (Stretch to fit)',
                    'object-none' => 'None (Original size)',
                    'object-scale-down' => 'Scale Down',
                ],
                'default_value' => $defaults['object_fit'] ?? 'object-cover',
                'wrapper' => ['width' => '50'],
            ])
            ->addTrueFalse('stretch_to_content', [
                'label' => 'Stretch to Content',
                'instructions' => 'Maintain aspect ratio as minimum, but stretch taller if content is longer',
                'default_value' => $defaults['stretch_to_content'] ?? 1,
                'wrapper' => ['width' => '33'],
            ])
            ->addTrueFalse('full_width', [
                'label' => 'Full Width',
                'instructions' => 'Extend beyond container margins (full browser width)',
                'default_value' => $defaults['full_width'] ?? 0,
                'wrapper' => ['width' => '33'],
            ])
            ->addSelect('border_radius', [
                'label' => 'Border Radius',
                'choices' => [
                    '' => 'None',
                    'rounded-sm' => 'Small',
                    'rounded' => 'Medium',
                    'rounded-lg' => 'Large',
                    'rounded-xl' => 'Extra Large',
                    'rounded-2xl' => '2X Large',
                    'rounded-full' => 'Full (Circle/Pill)',
                ],
                'default_value' => $defaults['border_radius'] ?? '',
                'wrapper' => ['width' => '33'],
            ])

            ->addTab('Performance', ['placement' => 'left'])
            ->addTrueFalse('lazy_loading', [
                'label' => 'Lazy Loading',
                'instructions' => 'Load image only when it comes into view (recommended: ON)',
                'default_value' => $defaults['lazy_loading'] ?? 1,
                'wrapper' => ['width' => '50'],
            ])
            ->addTrueFalse('priority_loading', [
                'label' => 'Priority Loading',
                'instructions' => 'Load this image immediately (use for above-the-fold images)',
                'default_value' => $defaults['priority_loading'] ?? 0,
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('image_sizes', [
                'label' => 'Responsive Sizes',
                'instructions' => 'Optimize loading for different screen sizes',
                'choices' => [
                    'auto' => 'Auto (Recommended)',
                    '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw' => 'Grid Layout',
                    '(max-width: 768px) 100vw, 50vw' => 'Two Column',
                    '100vw' => 'Full Width',
                    '(max-width: 640px) 100vw, 640px' => 'Content Width',
                ],
                'default_value' => $defaults['image_sizes'] ?? 'auto',
            ])

            ->addTab('Effects', ['placement' => 'left'])
            ->addSelect('hover_effect', [
                'label' => 'Hover Effect',
                'choices' => [
                    '' => 'None',
                    'hover:scale-105' => 'Scale Up',
                    'hover:scale-95' => 'Scale Down',
                    'hover:opacity-80' => 'Fade',
                    'hover:grayscale' => 'Grayscale',
                    'hover:blur-sm' => 'Blur',
                    'hover:brightness-110' => 'Brighten',
                ],
                'default_value' => $defaults['hover_effect'] ?? '',
                'wrapper' => ['width' => '50'],
            ])
            ->addRange('opacity', [
                'label' => 'Opacity',
                'min' => 0,
                'max' => 100,
                'step' => 5,
                'default_value' => $defaults['opacity'] ?? 100,
                'append' => '%',
                'wrapper' => ['width' => '50'],
            ])
            ->addSelect('clip_path', [
                'label' => 'Clip Path',
                'choices' => [
                    '' => 'None',
                    'diagonal-left' => 'Diagonal Left',
                    'diagonal-right' => 'Diagonal Right',
                    'custom' => 'Custom',
                ],
                'default_value' => $defaults['clip_path'] ?? 'diagonal-left',
                'wrapper' => ['width' => '50'],
            ])
            ->addText('custom_clip_path', [
                'label' => 'Custom Clip Path',
                'instructions' => 'e.g., polygon(0% 50%, 25rem 0%, 100% 0%, 100% 100%, 25rem 100%)',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'clip_path',
                            'operator' => '==',
                            'value' => 'custom',
                        ],
                    ],
                ],
            ])

            ->endGroup();

        return $visual;
    }
}

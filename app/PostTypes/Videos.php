<?php

namespace App\PostTypes;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Videos
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action('acf/init', [$this, 'addFields']);
    }

    public function registerPostType()
    {
        register_post_type('video', [
            'label' => 'Videos',
            'labels' => [
                'name' => 'Videos',
                'singular_name' => 'Video',
                'add_new' => 'Add New Video',
                'add_new_item' => 'Add New Video',
                'edit_item' => 'Edit Video',
                'new_item' => 'New Video',
                'view_item' => 'View Video',
                'search_items' => 'Search Videos',
                'not_found' => 'No videos found',
                'not_found_in_trash' => 'No videos found in trash',
            ],
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-video-alt3',
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
            'show_in_rest' => true,
            'rewrite' => ['slug' => 'videos'],
        ]);
    }

    public function addFields()
    {
        $videos = new FieldsBuilder('video_fields');

        $videos
            ->setLocation('post_type', '==', 'video')
            ->addUrl('video_url', [
                'label' => 'Video URL',
                'instructions' => 'YouTube, Vimeo, or direct video URL',
                'required' => 1,
            ])
            ->addText('duration', [
                'label' => 'Duration',
                'instructions' => 'e.g., 2:35',
                'placeholder' => '0:00',
            ])
            ->addTextarea('description', [
                'label' => 'Short Description',
                'rows' => 3,
            ]);

        acf_add_local_field_group($videos->build());
    }
}

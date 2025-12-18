<?php

namespace App\Fields;

use StoutLogic\AcfBuilder\FieldsBuilder;

class PostFields
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'addFields']);
        add_filter('manage_post_posts_columns', [$this, 'addTeamMemberColumn']);
        add_action('manage_post_posts_custom_column', [$this, 'displayTeamMemberColumn'], 10, 2);
    }

    public function addFields()
    {
        $postFields = new FieldsBuilder('post_fields');

        $postFields
            ->setLocation('post_type', '==', 'post')
            ->addTab('Author', ['placement' => 'left'])
            ->addPostObject('team_member_author', [
                'label' => 'Team Member Author',
                'instructions' => 'Link a team member as the author of this post (optional)',
                'post_type' => ['team'],
                'return_format' => 'id',
                'multiple' => 0,
                'allow_null' => 1,
            ])
            ->addTab('Single Page Settings', ['placement' => 'left'])
            ->addText('detail_heading', [
                'label' => 'Main Title (Header)',
                'instructions' => 'Custom title for the single post page (leave empty to use post title)',
            ])
            ->addImage('main_image', [
                'label' => 'Main Image (Header)',
                'instructions' => 'Hero image for the post header (leave empty to use featured image)',
                'return_format' => 'array',
                'preview_size' => 'large',
            ])
            ->addWysiwyg('introduction', [
                'label' => 'Introduction',
                'instructions' => 'Introduction text displayed below the header',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ])
            ->addNumber('read_time', [
                'label' => 'Read Time (minutes)',
                'instructions' => 'Estimated reading time in minutes',
                'min' => 1,
                'max' => 60,
                'placeholder' => 'Auto-calculate if left empty',
            ])
            ->addPostObject('related_posts', [
                'label' => 'Related Posts',
                'instructions' => 'Select related posts to display at the end of this post',
                'post_type' => ['post'],
                'multiple' => 1,
                'return_format' => 'object',
                'ui' => 1,
                'filters' => ['search'],
            ]);

        acf_add_local_field_group($postFields->build());
    }

    /**
     * Add Team Member Author column to admin list
     */
    public function addTeamMemberColumn($columns)
    {
        // Replace default author column with team member column
        $new_columns = [];
        foreach ($columns as $key => $value) {
            if ($key === 'author') {
                $new_columns['team_member_author'] = 'Author';
            } else {
                $new_columns[$key] = $value;
            }
        }

        return $new_columns;
    }

    /**
     * Display Team Member Author in admin list
     */
    public function displayTeamMemberColumn($column, $post_id)
    {
        if ($column === 'team_member_author') {
            $team_member_id = get_field('team_member_author', $post_id);

            if ($team_member_id) {
                $team_member_name = get_the_title($team_member_id);
                echo esc_html($team_member_name);
            } else {
                // Fallback to WordPress user if no team member selected
                $post = get_post($post_id);
                $author_id = $post->post_author;
                $author = get_userdata($author_id);
                echo esc_html($author->display_name);
            }
        }
    }
}

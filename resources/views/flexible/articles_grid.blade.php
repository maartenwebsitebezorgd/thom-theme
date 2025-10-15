@php
$contentBlock = get_sub_field('content_block');
$useLatestPosts = get_sub_field('use_latest_posts');
$selectedPosts = get_sub_field('selected_posts');
$numberOfPosts = get_sub_field('number_of_posts') ?? 6;
$imageAspectRatio = get_sub_field('image_aspect_ratio') ?? 'aspect-ratio-[3/2]';
$teamCard = get_sub_field('team_card');
$styleSettings = get_sub_field('style_settings');

// Grid settings
$gridColumnsDesktop = get_sub_field('grid_columns_desktop') ?? 'grid-cols-3';
$gridColumnsTablet = get_sub_field('grid_columns_tablet') ?? 'md:grid-cols-2';
$gridColumnsMobile = get_sub_field('grid_columns_mobile') ?? 'grid-cols-1';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-6';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';

// Get posts
if ($useLatestPosts) {
$posts = get_posts([
'post_type' => 'post',
'posts_per_page' => $numberOfPosts,
'orderby' => 'date',
'order' => 'DESC',
]);
} else {
$posts = [];
if ($selectedPosts) {
foreach ($selectedPosts as $postId) {
$post = get_post($postId);
if ($post) {
$posts[] = $post;
}
}
}
}

// Build articles array from posts and collect unique team members
$articles = [];
$teamMembers = [];
$teamMemberIds = []; // Track unique team member IDs

foreach ($posts as $post) {
    $thumbnail = get_post_thumbnail_id($post->ID);
    $image = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;
    $categories = get_the_category($post->ID);
    $category = !empty($categories) ? $categories[0]->name : null;

    // Get team member author for this post
    $teamMemberAuthorId = get_field('team_member_author', $post->ID);

    $articles[] = [
        'image' => $image ? [
            'url' => $image[0],
            'alt' => get_post_meta($thumbnail, '_wp_attachment_image_alt', true),
            'width' => $image[1] ?? null,
            'height' => $image[2] ?? null,
        ] : null,
        'category' => $category,
        'title' => $post->post_title,
        'excerpt' => get_the_excerpt($post),
        'link' => [
            'url' => get_permalink($post->ID),
            'title' => 'Read more',
            'target' => '_self',
        ],
        'make_card_clickable' => true,
        'team_member_id' => $teamMemberAuthorId,
    ];

    // Collect unique team member data
    if ($teamMemberAuthorId && !in_array($teamMemberAuthorId, $teamMemberIds)) {
        $teamMemberPost = get_post($teamMemberAuthorId);
        if ($teamMemberPost) {
            $teamMemberIds[] = $teamMemberAuthorId;
            $teamMembers[] = [
                'id' => $teamMemberAuthorId,
                'name' => $teamMemberPost->post_title,
                'headshot' => get_field('headshot', $teamMemberAuthorId),
                'job_title' => get_field('job_title', $teamMemberAuthorId),
                'email' => get_field('email', $teamMemberAuthorId),
                'phone' => get_field('phone', $teamMemberAuthorId),
            ];
        }
    }
}

// Get custom heading and button from team card settings
$customHeading = $teamCard['custom_heading'] ?? null;
$button = $teamCard['button'] ?? null;
@endphp

<section data-theme="{{ $theme }}" class="articles-grid u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container">

    {{-- Section Content (Heading, Paragraph, Buttons) --}}
    @if ($contentBlock)
    <div class="mb-u-8">
      <x-content-wrapper :content="$contentBlock" />
    </div>
    @endif

    {{-- Articles Grid --}}
    @if ($articles)
    <div class="articles-grid-wrapper" data-articles-grid>
      <div class="articles-grid grid {{ $gridColumnsMobile }} {{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
        @foreach ($articles as $index => $article)
        <div data-article-card data-team-member-id="{{ $article['team_member_id'] ?? '' }}" data-article-index="{{ $index }}">
          <x-article-simple
            :article="$article"
            :image-aspect-ratio="$imageAspectRatio"
            :section-theme="$theme" />
        </div>
        @endforeach
      </div>

      {{-- Team Card - Dynamic display based on hover --}}
      @if (!empty($teamMembers))
      <div class="team-card-wrapper mt-u-8" data-team-card-container>
        @foreach ($teamMembers as $index => $teamMember)
        <div
          class="team-member-card {{ $index === 0 ? '' : 'hidden' }}"
          data-team-member-card="{{ $teamMember['id'] }}">
          <x-team-horizontal-card
            :card="[
              'team_member' => $teamMember['id'],
              'custom_heading' => $customHeading,
              'button' => $button,
            ]"
            :section-theme="$theme" />
        </div>
        @endforeach
      </div>
      @endif
    </div>
    @endif

  </div>
</section>
@php
$contentBlock = get_sub_field('content_block');
$postType = get_sub_field('post_type') ?? 'post';
$useLatest = get_sub_field('use_latest');
$selectedPosts = get_sub_field('selected_posts');
$numberOfPosts = get_sub_field('number_of_posts') ?? 6;
$styleSettings = get_sub_field('style_settings');
$swiperSettings = get_sub_field('swiper_settings');

// Get posts
if ($useLatest) {
    $posts = get_posts([
        'post_type' => $postType,
        'posts_per_page' => $numberOfPosts,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
} else {
    $posts = [];
    if ($selectedPosts) {
        foreach ($selectedPosts as $postId) {
            $posts[] = get_post($postId);
        }
    }
}

// Build items array based on post type
$items = [];
foreach ($posts as $post) {
    $thumbnail = get_post_thumbnail_id($post->ID);
    $image = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;

    $itemData = [
        'image' => $image ? [
            'url' => $image[0],
            'alt' => get_post_meta($thumbnail, '_wp_attachment_image_alt', true),
        ] : null,
        'title' => $post->post_title,
        'excerpt' => get_the_excerpt($post),
        'link' => [
            'url' => get_permalink($post->ID),
            'title' => 'Read more',
            'target' => '_self',
        ],
        'make_card_clickable' => true,
    ];

    // Add post-type specific fields
    switch ($postType) {
        case 'post':
            $categories = get_the_category($post->ID);
            $itemData['category'] = !empty($categories) ? $categories[0]->name : null;
            $items[] = ['type' => 'article', 'data' => $itemData];
            break;

        case 'case':
            $itemData['client_name'] = get_field('client_name', $post->ID) ?? null;
            // Get case categories
            $caseCategories = get_the_terms($post->ID, 'case_category');
            $itemData['category'] = !empty($caseCategories) && !is_wp_error($caseCategories) ? $caseCategories[0]->name : null;
            $items[] = ['type' => 'case', 'data' => $itemData];
            break;

        case 'video':
            $itemData['video_url'] = get_field('video_url', $post->ID) ?? null;
            $itemData['duration'] = get_field('duration', $post->ID) ?? null;
            $items[] = ['type' => 'video', 'data' => $itemData];
            break;

        case 'team':
            $itemData['job_title'] = get_field('job_title', $post->ID) ?? null;
            $items[] = ['type' => 'team', 'data' => $itemData];
            break;

        default:
            $items[] = ['type' => 'article', 'data' => $itemData];
    }
}

// Image and card styling (section level)
$imageAspectRatio = get_sub_field('image_aspect_ratio') ?? '3/2';
$cardTheme = get_sub_field('card_theme') ?? 'auto';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
@endphp

<section data-theme="{{ $theme }}" class="multi-slider overflow-clip u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container">

    {{-- Section Content (Heading, Paragraph, Buttons) --}}
    @if ($contentBlock)
    <x-content-wrapper :content="$contentBlock" />
    @endif

    {{-- Swiper Slider --}}
    @if ($items)
    <x-swiper :settings="$swiperSettings">
      @foreach ($items as $item)
      <div class="swiper-slide">
        @if ($item['type'] === 'case')
          <x-case-simple
            :case="$item['data']"
            :image-aspect-ratio="$imageAspectRatio"
            :section-theme="$theme"
            :card-theme="$cardTheme" />
        @else
          <x-article-simple
            :article="$item['data']"
            :image-aspect-ratio="$imageAspectRatio"
            :section-theme="$theme"
            :card-theme="$cardTheme" />
        @endif
      </div>
      @endforeach
    </x-swiper>
    @endif

  </div>
</section>

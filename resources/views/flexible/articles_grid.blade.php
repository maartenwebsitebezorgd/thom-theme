@php
$contentBlock = get_sub_field('content_block');
$useLatestPosts = get_sub_field('use_latest_posts');
$selectedPosts = get_sub_field('selected_posts');
$numberOfPosts = get_sub_field('number_of_posts') ?? 6;
$imageAspectRatio = get_sub_field('image_aspect_ratio') ?? 'aspect-[3/2]';
$styleSettings = get_sub_field('style_settings');

// Grid settings
$gridColumnsDesktop = get_sub_field('grid_columns_desktop') ?? 'grid-cols-3';
$gridColumnsTablet = get_sub_field('grid_columns_tablet') ?? 'grid-cols-2';
$gridColumnsMobile = get_sub_field('grid_columns_mobile') ?? 'grid-cols-1';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-4';

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

// Build articles array from posts
$articles = [];

foreach ($posts as $post) {
$thumbnail = get_post_thumbnail_id($post->ID);
$image = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;
$categories = get_the_category($post->ID);
$category = !empty($categories) ? $categories[0]->name : null;

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
'title' => 'Lees meer',
'target' => '_self',
],
'make_card_clickable' => true,
];
}
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
    <div class="articles-grid-wrapper">
      <div class="articles-grid grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
        @foreach ($articles as $article)
        <div>
          <x-article-simple
            :article="$article"
            :image-aspect-ratio="$imageAspectRatio"
            :section-theme="$theme" />
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</section>
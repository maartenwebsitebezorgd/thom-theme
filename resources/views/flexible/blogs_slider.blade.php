@php
$contentBlock = get_sub_field('content_block');
$useLatestPosts = get_sub_field('use_latest_posts');
$selectedPosts = get_sub_field('selected_posts');
$numberOfPosts = get_sub_field('number_of_posts') ?? 6;
$styleSettings = get_sub_field('style_settings');
$swiperSettings = get_sub_field('swiper_settings');

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
$posts[] = get_post($postId);
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
'article_simple' => [
'image' => $image ? [
'url' => $image[0],
'alt' => get_post_meta($thumbnail, '_wp_attachment_image_alt', true),
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
]
];
}

// Image and card styling (section level)
$imageAspectRatio = get_sub_field('image_aspect_ratio') ?? '3/2';
$cardTheme = get_sub_field('card_theme') ?? 'auto';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
@endphp

<section data-theme="{{ $theme }}" class="blogs-slider overflow-clip u-section {{ $paddingTop }} {{ $paddingBottom }}">
    <div class="u-container">

        {{-- Section Content (Heading, Paragraph, Buttons) --}}
        @if ($contentBlock)
        <x-content-wrapper :content="$contentBlock" />
        @endif

        {{-- Swiper Slider --}}
        @if ($articles)
        <x-swiper :settings="$swiperSettings" classes="group/blog-slider">
            @foreach ($articles as $articleItem)
            <div class="swiper-slide">
                <x-article-simple
                    :article="$articleItem['article_simple']"
                    :image-aspect-ratio="$imageAspectRatio"
                    :section-theme="$theme"
                    :card-theme="$cardTheme"
                    classes="opacity-100 group-hover/blog-slider:opacity-70 hover:!opacity-100 transition-opacity ease-in-out duration-200" />
            </div>
            @endforeach
        </x-swiper>
        @endif

    </div>
</section>
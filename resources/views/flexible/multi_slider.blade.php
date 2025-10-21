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

// Determine partial template based on post type
$partialTemplate = match($postType) {
'case' => 'content-case',
'post' => 'content',
default => 'content-' . $postType,
};

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
        @if (!empty($posts))
        <x-swiper :settings="$swiperSettings" classes="group/multi-slider">
            @foreach ($posts as $postItem)
            @php
            // Setup global post data for WordPress functions
            global $post;
            $post = $postItem;
            setup_postdata($post);

            // Pass variables to partial scope
            $sectionTheme = $theme;
            $makeCardClickable = true;
            $showExcerpt = true;
            $showCategory = true;
            $partialClasses = 'opacity-100 group-hover/multi-slider:opacity-70 hover:!opacity-100 transition-opacity ease-in-out duration-200'; // Optional: pass custom classes to partials if needed
            @endphp

            <div class="swiper-slide">
                @include('partials.' . $partialTemplate)
            </div>

            @php wp_reset_postdata(); @endphp
            @endforeach
        </x-swiper>
        @endif

    </div>
</section>
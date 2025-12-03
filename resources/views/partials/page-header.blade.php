@php
// Get settings from ACF options with fallbacks
$theme = get_field('header_theme', 'option') ?? 'grey';
$alignment = get_field('header_alignment', 'option') ?? 'text-center';
$paddingTop = get_field('header_padding_top', 'option') ?? 'pt-section-small';
$paddingBottom = get_field('header_padding_bottom', 'option') ?? 'pb-section-small';

// Visual/Split layout settings - start with theme option defaults
$enableVisual = get_field('enable_visual', 'option') ?? false;
$visualImage = null;
$visualAspectRatio = get_field('visual_aspect_ratio', 'option') ?? 'aspect-[16/9]';
$contentLayout = get_field('content_layout', 'option') ?? 'visual-left';
$verticalAlignment = get_field('vertical_alignment', 'option') ?? 'items-center';
$gapSize = get_field('header_gap_size', 'option') ?? 'gap-u-8';
$shouldStretch = get_field('stretch_to_content', 'option') ?? true;
$priorityLoading = get_field('priority_loading', 'option') ?? true;
$clipPath = get_field('clip_path', 'option') ?? 'diagonal-left';

// Priority 1: Check for page featured image (for regular pages and posts page)
if (is_page() || is_home()) {
$pageId = is_home() ? get_option('page_for_posts') : get_the_ID();
if ($pageId && has_post_thumbnail($pageId)) {
$thumbnailId = get_post_thumbnail_id($pageId);
$visualImage = [
'ID' => $thumbnailId,
'id' => $thumbnailId,
'url' => wp_get_attachment_image_url($thumbnailId, 'full'),
'alt' => get_post_meta($thumbnailId, '_wp_attachment_image_alt', true),
];
$enableVisual = true;
}
}

// Priority 2: Check for category image on archive pages
if (!$visualImage && (is_category() || is_tax('case_category'))) {
$term = get_queried_object();
$categoryImage = get_field('category_image', $term);
if ($categoryImage) {
$visualImage = $categoryImage;
$enableVisual = true;
}
}

// Priority 3: Fallback to theme options visual image
if (!$visualImage) {
$visualImage = get_field('visual_image', 'option');
}

// Determine the title and description based on the page type
if (is_home()) {
$pageTitle = __('Blog', 'sage');
// Get excerpt from the posts page
$postsPageId = get_option('page_for_posts');
$pageDescription = $postsPageId ? get_the_excerpt($postsPageId) : null;
} elseif (is_archive()) {
$pageTitle = get_the_archive_title();
$pageDescription = get_the_archive_description();
} elseif (is_search()) {
$pageTitle = sprintf(__('Search Results for "%s"', 'sage'), get_search_query());
$pageDescription = null;
} elseif (is_404()) {
$pageTitle = __('Not Found', 'sage');
$pageDescription = null;
} else {
$pageTitle = $title ?? get_the_title();
$pageDescription = get_the_excerpt();
}

// Build visual block if enabled
$visualBlock = ($enableVisual && $visualImage) ? [
'media_type' => 'image',
'image' => $visualImage,
'aspect_ratio' => $visualAspectRatio,
'stretch_to_content' => $shouldStretch,
'priority_loading' => $priorityLoading,
'clip_path' => $clipPath,
] : null;

// Determine column order
$visualFirst = $contentLayout === 'visual-left';
@endphp

<section data-theme="{{ $theme }}" class="page-header u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container max-w-container-main">
    @if($visualBlock)
    {{-- Split Layout with Visual --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 {{ $gapSize }} {{ $shouldStretch ? 'items-stretch' : $verticalAlignment }}">
      @if($visualFirst)
      {{-- Visual Left Layout --}}
      <div class="visual-column {{ $shouldStretch ? 'flex' : '' }}">
        <x-visual :visual="$visualBlock" class="{{ $shouldStretch ? 'flex-1' : '' }}" />
      </div>
      <div class="content-column flex {{ $verticalAlignment }}">
        <div class="u-margin-trim">
          <h1 class="page-title u-text-style-h1 u-margin-bottom-text">{!! $pageTitle !!}</h1>
          @if($pageDescription)
          <div class="page-description u-text-style-main u-margin-bottom-text">
            {!! $pageDescription !!}
          </div>
          @endif
        </div>
      </div>
      @else
      {{-- Visual Right Layout --}}
      <div class="content-column flex {{ $verticalAlignment }}">
        <div class="u-margin-trim">
          <h1 class="page-title u-text-style-h1 u-margin-bottom-text">{!! $pageTitle !!}</h1>
          @if($pageDescription)
          <div class="page-description u-text-style-main u-margin-bottom-text">
            {!! $pageDescription !!}
          </div>
          @endif
        </div>
      </div>
      <div class="visual-column {{ $shouldStretch ? 'flex' : '' }}">
        <x-visual :visual="$visualBlock" class="{{ $shouldStretch ? 'flex-1' : '' }}" />
      </div>
      @endif
    </div>
    @else
    {{-- Default Centered Layout --}}
    <div class="{{ $alignment }} u-margin-trim">
      <h1 class="page-title u-text-style-h1 u-margin-bottom-text">{!! $pageTitle !!}</h1>

      @if($pageDescription)
      <div class="page-description u-text-style-main u-margin-bottom-text">
        {!! $pageDescription !!}
      </div>
      @endif
    </div>
    @endif
  </div>
</section>
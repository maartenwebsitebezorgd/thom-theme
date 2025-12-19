@php
$post_id = get_the_ID();
$thumbnail = get_post_thumbnail_id($post_id);
$image = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;

// Get settings from parent scope or use defaults
$sectionTheme = $sectionTheme ?? 'light';
$cardTheme = $cardTheme ?? 'auto';
$imageAspectRatio = $imageAspectRatio ?? 'aspect-[16/9]';
$showExcerpt = $showExcerpt ?? true;
$showCategory = $showCategory ?? false;
$makeCardClickable = $makeCardClickable ?? true;
$partialClasses = $partialClasses ?? ''; // Accept custom classes from parent

// Auto theme: Use opposite of section theme (light <-> dark)
if ($cardTheme === 'auto') {
  $cardTheme = match($sectionTheme) {
    'light' => 'grey',
    'dark' => 'accent-light',
    default => 'inherit',
  };
}

// Build visual block for Visual component
$visualBlock = $image ? [
  'media_type' => 'image',
  'image' => [
    'url' => $image[0],
    'alt' => get_post_meta($thumbnail, '_wp_attachment_image_alt', true),
    'width' => $image[1] ?? null,
    'height' => $image[2] ?? null,
  ],
  'aspect_ratio' => $imageAspectRatio,
] : null;

// Generate unique ID for aria-labelledby
$uniqueId = uniqid('whitepaper-');

// Generate post classes as array
$postClasses = get_post_class('whitepaper-simple-wrap w-full h-full flex flex-col overflow-hidden group ' . $partialClasses);
$articleClasses = implode(' ', $postClasses);
@endphp

<article
  class="{{ $articleClasses }}"
  data-theme="{{ $cardTheme }}"
  role="article"
  aria-labelledby="{{ $uniqueId }}-title">

  @if($makeCardClickable)
  <a
    href="{{ get_permalink() }}"
    class="whitepaper-link-wrapper flex flex-col h-full no-underline"
    aria-label="{{ get_the_title() }}: Lees meer">
  @else
  <div class="whitepaper-link-wrapper flex flex-col h-full">
  @endif

    @if($visualBlock)
    <div class="whitepaper-simple-media-wrap overflow-hidden">
      <div class="whitepaper-simple-image-zoom">
        <x-visual :visual="$visualBlock" />
      </div>
    </div>
    @endif

    <div class="whitepaper-simple-content-wrap flex flex-col grow">
      <div class="whitepaper-simple-content-top flex-1 px-u-4 pt-u-5 pb-u-5 u-margin-trim">

        <h3 id="{{ $uniqueId }}-title" class="whitepaper-simple-title u-text-style-h5 u-margin-bottom-text">
          <span class="whitepaper-simple-title-text">{!! get_the_title() !!}</span>
        </h3>

        @if($showExcerpt && (has_excerpt() || get_the_content()))
        @php
        $excerptWordCount = function_exists('get_field') ? get_field('excerpt_word_count', 'option') : 20;
        $excerptWordCount = $excerptWordCount ?: 20;
        $excerptMoreText = function_exists('get_field') ? get_field('excerpt_more_text', 'option') : '...';
        $excerptMoreText = $excerptMoreText !== null ? $excerptMoreText : '...';
        @endphp
        <p class="u-text-style-main u-margin-bottom-text">
          {{ wp_trim_words(get_the_excerpt(), $excerptWordCount, $excerptMoreText) }}
        </p>
        @endif
      </div>

      <div class="whitepaper-simple-content-bottom flex flex-nowrap items-center justify-end px-u-4 pt-u-4 pb-u-4">
        @if($makeCardClickable)
        <span class="button button--icon-only ml-auto" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </span>
        @else
        <a
          href="{{ get_permalink() }}"
          class="button button--icon-only ml-auto">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </a>
        @endif
      </div>
    </div>

  @if($makeCardClickable)
  </a>
  @else
  </div>
  @endif
</article>

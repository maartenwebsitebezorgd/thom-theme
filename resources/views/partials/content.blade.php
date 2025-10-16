@php
  $post_id = get_the_ID();
  $thumbnail = get_post_thumbnail_id($post_id);
  $image = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;
  $categories = get_the_category($post_id);
  $category = !empty($categories) ? $categories[0]->name : null;

  // Get settings from parent scope or use defaults
  $sectionTheme = $sectionTheme ?? 'light';
  $cardTheme = $cardTheme ?? 'auto';
  $imageAspectRatio = $imageAspectRatio ?? 'aspect-[3/2]';
  $showExcerpt = $showExcerpt ?? true;
  $showCategory = $showCategory ?? true;
  $makeCardClickable = $makeCardClickable ?? true;

  // Auto theme: Use opposite of section theme (light <-> dark)
  if ($cardTheme === 'auto') {
    $cardTheme = match($sectionTheme) {
      'light' => 'grey',
      'grey' => 'light',
      'dark' => 'accent-light',
      'accent' => 'light',
      'accent-light' => 'accent',
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
  $uniqueId = uniqid('article-');
@endphp

<article
  @php(post_class('article-simple-wrap w-full h-full flex flex-col overflow-hidden group'))
  data-theme="{{ $cardTheme }}"
  role="article"
  aria-labelledby="{{ $uniqueId }}-title">

  @if($makeCardClickable)
    <a
      href="{{ get_permalink() }}"
      class="article-link-wrapper flex flex-col h-full no-underline"
      aria-label="{{ get_the_title() }}: Read more">
  @else
    <div class="article-link-wrapper flex flex-col h-full">
  @endif

    @if($visualBlock)
      <div class="article-simple-media-wrap overflow-hidden">
        <div class="article-simple-image-zoom">
          <x-visual :visual="$visualBlock" />
        </div>
      </div>
    @endif

    <div class="article-simple-content-wrap flex flex-col grow">
      <div class="article-simple-content-top flex-1 px-u-4 pt-u-5 pb-u-5 u-margin-trim">
        <h2 id="{{ $uniqueId }}-title" class="article-simple-title u-text-style-h5 mb-u-4">
          <span class="article-simple-title-text">{!! get_the_title() !!}</span>
        </h2>

        @if($showExcerpt && (has_excerpt() || get_the_content()))
          <p class="u-text-style-small u-margin-bottom-text">
            {{ wp_trim_words(get_the_excerpt(), 20) }}
          </p>
        @endif
      </div>

      <div class="article-simple-content-bottom flex flex-nowrap items-center justify-between px-u-4 pt-u-4 pb-u-4 border-t border-[var(--theme-border)]">
        @if($showCategory && $category)
          <div class="category-wrapper flex flex-row flex-wrap gap-u-2 items-center">
            <span class="u-text-style-small text-[var(--theme-text)]/60" aria-label="Category">
              {{ $category }}
            </span>
          </div>
        @endif

        @if($makeCardClickable)
          <span class="underline-offset-2 u-text-style-small underline" aria-hidden="true">
            Read more
          </span>
        @else
          <a
            href="{{ get_permalink() }}"
            class="underline-offset-2 u-text-style-small underline">
            Read more
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

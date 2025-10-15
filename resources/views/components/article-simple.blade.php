@props([
'article' => [],
'imageAspectRatio' => '3/2',
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
])

@php
$image = $article['image'] ?? null;
$category = $article['category'] ?? null;
$title = $article['title'] ?? null;
$excerpt = $article['excerpt'] ?? null;
$link = $article['link'] ?? null;
$makeCardClickable = $article['make_card_clickable'] ?? true;

// Auto theme: Use opposite of section theme (light <-> dark)
  if ($cardTheme === 'auto') {
  $cardTheme = match($sectionTheme) {
  'light' => 'grey',
  'dark' => 'accent-light',
  default => 'inherit',
  };
  }

  $linkUrl = $link['url'] ?? null;
  $linkTarget = $link['target'] ?? '_self';
  $linkTitle = $link['title'] ?? 'Read more';

  // Build visual block for Visual component
  $visualBlock = $image ? [
  'media_type' => 'image',
  'image' => $image,
  'aspect_ratio' => $imageAspectRatio,
  ] : null;

  // Generate unique ID for aria-labelledby
  $uniqueId = uniqid('article-');
  @endphp

  @if($makeCardClickable && $linkUrl)
  <article
    data-theme="{{ $cardTheme }}"
    class="article-simple-wrap w-full h-full flex flex-col overflow-hidden group"
    role="article"
    aria-labelledby="{{ $uniqueId }}-title">
    <a
      href="{{ $linkUrl }}"
      target="{{ $linkTarget }}"
      @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif
      class="article-link-wrapper flex flex-col h-full no-underline"
      aria-label="{{ $title }}: {{ $linkTitle }}">
      @else
      <article
        data-theme="{{ $cardTheme }}"
        class="article-simple-wrap h-full flex flex-col overflow-hidden"
        role="article"
        aria-labelledby="{{ $uniqueId }}-title">
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
            @if($title)
            <h3 id="{{ $uniqueId }}-title" class="article-simple-title u-text-style-h5 mb-u-4">
              <span class="article-simple-title-text">{{ $title }}</span>
            </h3>
            @endif

            @if($excerpt)
            <p class="u-text-style-small u-margin-bottom-text">{{ $excerpt }}</p>
            @endif
          </div>

          <div class="article-simple-content-bottom flex flex-nowrap items-center justify-between px-u-4 pt-u-4 pb-u-4 border-t border-[var(--theme-border)]">
            @if($category)
            <div class="category-wrapper flex flex-row flex-wrap gap-u-2 items-center">
              <span class="u-text-style-small text-[var(--theme-text)]/60" aria-label="Category">{{ $category }}</span>
            </div>
            @endif

            @if($link && !$makeCardClickable)
            <a
              href="{{ $linkUrl }}"
              target="{{ $linkTarget }}"
              @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif
              class="underline-offset-2 u-text-style-small underline">
              {{ $linkTitle }}
            </a>
            @elseif($link && $makeCardClickable)
            <span class="underline-offset-2 u-text-style-small underline" aria-hidden="true">{{ $linkTitle }}</span>
            @endif
          </div>
        </div>

        @if($makeCardClickable && $linkUrl)
    </a>
  </article>
  @else
  </article>
  @endif
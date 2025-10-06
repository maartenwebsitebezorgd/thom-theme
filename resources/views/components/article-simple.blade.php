@props([
'article' => [],
'imageAspectRatio' => '3/2',
'sectionBgColor' => '',
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
'cardBgColor' => 'auto',
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
  'light' => 'dark',
  'dark' => 'light',
  default => 'inherit',
  };
  }

  // Auto background: Use opposite of section background
  if ($cardBgColor === 'auto') {
  $cardBgColor = match($sectionBgColor) {
  'u-background-1' => 'u-background-2',
  'u-background-2' => 'u-background-1',
  default => 'u-background-1',
  };
  }

  $linkUrl = $link['url'] ?? null;
  $linkTarget = $link['target'] ?? '_self';

  // Build visual block for Visual component
  $visualBlock = $image ? [
  'media_type' => 'image',
  'image' => $image,
  'aspect_ratio' => $imageAspectRatio,
  ] : null;
  @endphp

  <article
    data-theme="{{ $cardTheme }}"
    class="article-simple-wrap {{ $cardBgColor }} @if($makeCardClickable && $linkUrl) cursor-pointer @endif"
    @if($makeCardClickable && $linkUrl)
    onclick="window.open('{{ $linkUrl }}', '{{ $linkTarget }}')"
    @endif>
    @if($visualBlock)
    <div class="article-simple-media-wrap overflow-hidden">
      <x-visual :visual="$visualBlock" />
    </div>
    @endif

    <div class="article-simple-content-wrap p-u-5">
      <div class="article-simple-content-top u-margin-trim">
        @if($category)
        <div class="category-wrapper flex flex-row flex-wrap gap-u-2 items-center mb-u-3">
          <span class="u-text-style-small">{{ $category }}</span>
        </div>
        @endif

        @if($title)
        <h3 class="u-text-style-h4 mb-u-4">{{ $title }}</h3>
        @endif

        @if($excerpt)
        <p class="u-text-style-main u-margin-bottom-text">{{ $excerpt }}</p>
        @endif
      </div>

      <div class="article-simple-content-bottom">
        @if($link && !$makeCardClickable)
        <a href="{{ $linkUrl }}" target="{{ $linkTarget }}" class="button button--primary">
          {{ $link['title'] ?: 'Read more' }}
        </a>
        @endif
      </div>
    </div>
  </article>
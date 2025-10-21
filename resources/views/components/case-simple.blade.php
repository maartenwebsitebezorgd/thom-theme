@props([
'case' => [],
'imageAspectRatio' => '3/2',
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
'classes' => '',
])

@php
$image = $case['image'] ?? null;
$clientName = $case['client_name'] ?? null;
$title = $case['title'] ?? null;
$excerpt = $case['excerpt'] ?? null;
$category = $case['category'] ?? null;
$link = $case['link'] ?? null;
$makeCardClickable = $case['make_card_clickable'] ?? true;

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
  $linkTitle = $link['title'] ?? 'View case';

  // Build visual block for Visual component
  $visualBlock = $image ? [
  'media_type' => 'image',
  'image' => $image,
  'aspect_ratio' => $imageAspectRatio,
  ] : null;

  // Generate unique ID for aria-labelledby
  $uniqueId = uniqid('case-');
  @endphp

  @if($makeCardClickable && $linkUrl)
  <article
    data-theme="{{ $cardTheme }}"
    class="case-simple-wrap w-full h-full flex flex-col overflow-hidden group {{ $classes }}"
    role="article"
    aria-labelledby="{{ $uniqueId }}-title">
    <a
      href="{{ $linkUrl }}"
      target="{{ $linkTarget }}"
      @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif
      class="case-link-wrapper flex flex-col h-full no-underline"
      aria-label="{{ $title }}: {{ $linkTitle }}">
      @else
      <article
        data-theme="{{ $cardTheme }}"
        class="case-simple-wrap h-full flex flex-col overflow-hidden {{ $classes }}"
        role="article"
        aria-labelledby="{{ $uniqueId }}-title">
        @endif
        @if($visualBlock)
        <div class="case-simple-media-wrap overflow-hidden">
          <div class="case-simple-image-zoom">
            <x-visual :visual="$visualBlock" />
          </div>
        </div>
        @endif

        <div class="case-simple-content-wrap flex flex-col grow">
          <div class="case-simple-content-top flex-1 px-u-4 pt-u-5 pb-u-5 u-margin-trim">
            @if($title)
            <h3 id="{{ $uniqueId }}-title" class="case-simple-title u-text-style-h5 mb-u-4">
              <span class="case-simple-title-text">{{ $title }}</span>
            </h3>
            @endif

            @if($category)
            <div class="category-wrapper flex flex-row flex-wrap gap-u-2 items-center mb-u-4">
              <span class="u-text-style-small py-u-1 px-u-1 bg-[var(--swatch--accent-main)]" aria-label="Category">{{ $category }}</span>
            </div>
            @endif

            @if($excerpt)
            <p class="u-text-style-main u-margin-bottom-text">{{ $excerpt }}</p>
            @endif
          </div>

          <div class="case-simple-content-bottom flex flex-nowrap items-center justify-between px-u-4 pt-u-4 pb-u-4">
            @if($clientName)
            <div class="client-wrapper flex flex-row flex-wrap gap-u-2 items-center">
              <span class="u-text-style-small text-[var(--theme-text)]/90" aria-label="Client">{{ $clientName }}</span>
            </div>
            @endif

            @if($link && !$makeCardClickable)
            <a
              href="{{ $linkUrl }}"
              target="{{ $linkTarget }}"
              @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif
              class="button button--icon-only ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </a>
            @elseif($link && $makeCardClickable)
            <span class="button button--icon-only ml-auto " aria-hidden="true"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg></span>
            @endif
          </div>
        </div>

        @if($makeCardClickable && $linkUrl)
    </a>
  </article>
  @else
  </article>
  @endif
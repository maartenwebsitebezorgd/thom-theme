@props([
'card' => [],
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
'headingTextStyle' => 'u-text-style-h4',
'paragraphTextStyle' => 'u-text-style-main',
'iconSize' => 'size-u-5',
'classes ' => '',
])

@php
$icon = $card['icon'] ?? null;
$heading = $card['heading'] ?? '';
$text = $card['text'] ?? '';
$link = $card['link'] ?? null;
$label = $card['label'] ?? 'ik wil impact maken';
$makeCardClickable = $card['make_card_clickable'] ?? true;

// Calculate negative margin for icon alignment (roughly 1/3 of icon size)
$iconMarginTop = match($iconSize) {
'size-u-3' => '-mt-[0.25rem]', // u-3 is ~0.75rem, 1/3 = 0.25rem
'size-u-4' => '-mt-[0.33rem]', // u-4 is ~1rem, 1/3 = 0.33rem
'size-u-5' => '-mt-[0.5rem]', // u-5 is ~1.25rem, 1/3 = 0.42rem
'size-u-6' => '-mt-[0.55rem]', // u-6 is ~1.5rem, 1/3 = 0.5rem
default => '-mt-[0.33rem]',
};

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
  $linkTitle = $link['title'] ?? 'Learn more';

  // Generate unique ID for aria-labelledby
  $uniqueId = uniqid('service-');
  @endphp

  @if($makeCardClickable && $linkUrl)
  <div
    data-theme="{{ $cardTheme }}"
    class="service-card-wrap w-full h-full flex flex-col overflow-hidden group {{ $classes }}">
    <a
      href="{{ $linkUrl }}"
      target="{{ $linkTarget }}"
      @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif
      class="service-link-wrapper flex flex-col h-full no-underline"
      aria-label="{{ $heading }}: {{ $linkTitle }}">
      @else
      <div
        data-theme="{{ $cardTheme }}"
        class="service-card-wrap h-full flex flex-col overflow-hidden {{ $classes }}">
        @endif
        <div class="service-card-content-wrap flex flex-col grow">
          <div class="service-card-content-top flex-1 px-u-5 pt-u-5 pb-u-5 u-margin-trim">
            <div class="flex flex-row gap-u-3 mb-u-5">
              @if ($icon)
              <div class="service-card-icon {{ $iconSize }} {{ $iconMarginTop }} shrink-0">
                <img src="{{ $icon['url'] }}" alt="{{ $icon['alt'] ?: $heading }}" class="w-full h-full object-contain" loading="lazy">
              </div>
              @endif

              @if ($heading)
              <h3 id="{{ $uniqueId }}-title" class="service-card-heading {{ $headingTextStyle }} !font-bold">
                <span class="service-card-heading-text">{{ $heading }}</span>
              </h3>
              @endif
            </div>

            @if ($text)
            <p class="service-card-text {{ $paragraphTextStyle }} u-margin-bottom-text">{{ $text }}</p>
            @endif
          </div>

          <div class="service-card-content-bottom flex flex-row gap-u-2 items-center justify-between px-u-5 pt-u-3 pb-u-3 border-t border-[var(--theme-border)]">

            @if($label)
            <span class="u-text-style-small text-[var(--theme-text)]/60">{{ $label }}</span>
            @endif


            @if($link && !$makeCardClickable)
            <a href="{{ $linkUrl }}"
              target="{{ $linkTarget }}"
              @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif class="button button--icon-only ml-auto" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </a>
            @elseif($link && $makeCardClickable)
            <span class="button button--icon-only ml-auto group-hover" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </span>
            @endif
          </div>
        </div>

        @if($makeCardClickable && $linkUrl)
    </a>
  </div>
  @else
  </div>
  @endif
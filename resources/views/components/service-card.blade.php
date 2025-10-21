@props([
'card' => [],
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
'classes ' => '',
])

@php
$icon = $card['icon'] ?? null;
$heading = $card['heading'] ?? '';
$text = $card['text'] ?? '';
$link = $card['link'] ?? null;
$makeCardClickable = $card['make_card_clickable'] ?? true;

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
          <div class="service-card-content-top flex-1 px-u-4 pt-u-5 pb-u-5 u-margin-trim">
            <div class="flex flex-row gap-u-2 mb-u-5">
              @if ($icon)
              <div class="service-card-icon size-u-3 shrink-0">
                <img src="{{ $icon['url'] }}" alt="{{ $icon['alt'] ?: $heading }}" class="w-full h-full object-contain" loading="lazy">
              </div>
              @endif

              @if ($heading)
              <h3 id="{{ $uniqueId }}-title" class="service-card-heading u-text-style-main !font-bold">
                <span class="service-card-heading-text">{{ $heading }}</span>
              </h3>
              @endif
            </div>

            @if ($text)
            <p class="service-card-text u-text-style-small u-margin-bottom-text">{{ $text }}</p>
            @endif
          </div>

          <div class="service-card-content-bottom flex flex-row gap-u-2 items-center justify-between px-u-4 pt-u-4 pb-u-4 border-t border-[var(--theme-border)]">

            <span class="u-text-style-small text-[var(--theme-text)]/60">ik wil impact maken</span>


            @if($link && !$makeCardClickable)
            <a
              href="{{ $linkUrl }}"
              target="{{ $linkTarget }}"
              @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif
              class="underline-offset-2 u-text-style-small underline ml-auto">
              {{ $linkTitle }}
            </a>
            @elseif($link && $makeCardClickable)
            <span class="underline-offset-2 u-text-style-small underline ml-auto" aria-hidden="true">{{ $linkTitle }}</span>
            @endif
          </div>
        </div>

        @if($makeCardClickable && $linkUrl)
    </a>
  </div>
  @else
  </div>
  @endif
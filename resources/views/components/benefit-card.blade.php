@props([
'card' => [],
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
'classes' => '',
])

@php
$icon = $card['icon'] ?? null;
$heading = $card['heading'] ?? '';
$text = $card['text'] ?? '';

// Auto theme: Use opposite of section theme (light <-> dark)
  if ($cardTheme === 'auto') {
  $cardTheme = match($sectionTheme) {
  'light' => 'grey',
  'dark' => 'accent-light',
  default => 'inherit',
  };
  }
  @endphp

  <div class="card w-full p-u-5 {{ $classes }}" data-theme="{{ $cardTheme }}">
    <div class="card_content-top content-wrapper u-margin-trim">
      @if ($icon)
      <div class="card-icon mb-u-5">
        <img src="{{ $icon['url'] }}" alt="{{ $icon['alt'] ?: $heading }}" class="w-8 h-8 object-contain" loading="lazy">
      </div>
      @endif

      @if ($heading)
      <h3 class="card-heading u-text-style-h6 u-margin-bottom-text">{{ $heading }}</h3>
      @endif

      @if ($text)
      <p class="card-text u-text-style-main u-margin-bottom-text">{{ $text }}</p>
      @endif
    </div>
  </div>
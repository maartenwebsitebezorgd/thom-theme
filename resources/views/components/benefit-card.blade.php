@props([
'card' => [],
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
'headingTextStyle' => 'u-text-style-h5',
'textStyle' => 'u-text-style-small',
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
        <img src="{{ $icon['url'] }}" alt="{{ $icon['alt'] ?: $heading }}" class="w-u-6 h-u-6 object-contain" loading="lazy">
      </div>
      @endif

      @if ($heading)
      <h3 class="card-heading {{ $headingTextStyle }} u-margin-bottom-text">{{ $heading }}</h3>
      @endif

      @if ($text)
      <div class="card-text {{ $textStyle }} u-margin-bottom-text prose">{!! $text !!}</div>
      @endif
    </div>
  </div>
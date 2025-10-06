@props([
'card' => [],
'sectionBgColor' => null,
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
'cardBgColor' => 'auto',
])

@php
$icon = $card['icon'] ?? null;
$heading = $card['heading'] ?? '';
$text = $card['text'] ?? '';

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
@endphp

<div class="card p-u-6 {{ $cardBgColor }}" data-theme="{{ $cardTheme }}">
    <div class="card_content-top content-wrapper">
      @if ($icon)
      <div class="card-icon mb-u-5">
        <img src="{{ $icon['url'] }}" alt="{{ $icon['alt'] ?: $heading }}" class="w-8 h-8 object-contain" loading="lazy">
      </div>
      @endif

      @if ($heading)
      <h3 class="card-heading u-text-style-h5 u-margin-bottom-text ">{{ $heading }}</h3>
      @endif

      @if ($text)
      <p class="card-text u-text-style-small u-margin-bottom-text">{{ $text }}</p>
      @endif
    </div>
  </div>
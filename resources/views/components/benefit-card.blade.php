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

  // Map text style to prose modifier
  $proseSize = match($textStyle) {
  'u-text-style-small' => 'prose-p:text-small prose-ul:text-small prose-ol:text-small prose-li:text-small',
  'u-text-style-main' => 'prose-p:text-main prose-ul:text-main prose-ol:text-main prose-li:text-main',
  'u-text-style-medium' => 'prose-p:text-medium prose-ul:text-medium prose-ol:text-medium prose-li:text-medium',
  'u-text-style-large' => 'prose-p:text-large prose-ul:text-large prose-ol:text-large prose-li:text-large',
  default => 'prose-p:text-small prose-ul:text-small prose-ol:text-small prose-li:text-small',
  };
  @endphp

  <div class="card w-full p-u-5 {{ $classes }}" data-theme="{{ $cardTheme }}">
    <div class="card_content-top content-wrapper u-margin-trim">
      @if ($icon)
      <div class="card-icon mb-u-5 text-">
        <img src="{{ $icon['url'] }}" alt="{{ $icon['alt'] ?: $heading }}" class="w-u-6 h-u-6 object-contain" loading="lazy">
      </div>
      @endif

      @if ($heading)
      <h3 class="card-heading {{ $headingTextStyle }} u-margin-bottom-text">{{ $heading }}</h3>
      @endif

      @if ($text)
      <div class="card-text prose {{ $proseSize }}">{!! $text !!}</div>
      @endif
    </div>
  </div>
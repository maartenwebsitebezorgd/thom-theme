@php
$icon = $card['icon'] ?? null;
$heading = $card['heading'] ?? '';
$text = $card['text'] ?? '';
@endphp

<div class="card p-u-6 bg-white">
  <div class="card_content-top content-wrapper">
    @if ($icon)
    <div class="card-icon u-margin-bottom-text">
      <img src="{{ $icon['url'] }}" alt="{{ $icon['alt'] ?: $heading }}" class="w-16 h-16 object-contain" loading="lazy">
    </div>
    @endif

    @if ($heading)
    <h3 class="card-heading u-text-style-h4 u-margin-bottom-text ">{{ $heading }}</h3>
    @endif

    @if ($text)
    <p class="card-text u-text-style-small u-margin-bottom-text">{{ $text }}</p>
    @endif
  </div>
</div>
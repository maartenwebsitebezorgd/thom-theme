@props([
'content' => [],
])

@php
// Set default values
$eyebrow = $content['eyebrow'] ?? null;
$heading = $content['heading'] ?? null;
$paragraph = $content['paragraph'] ?? null;
$buttonGroup = $content['button_group'] ?? [];

// Process heading to add accent color to text between ==
if ($heading) {
$heading = preg_replace('/==(.+?)==/', '<span class="u-text-accent">$1</span>', $heading);
}

// Settings
$marginBottom = $content['margin_bottom'] ?? 'mb-u-8';
$alignment = $content['alignment'] ?? 'text-left';
$headingTag = $content['heading_tag'] ?? 'h2';
$headingTextStyle = $content['heading_text_style'] ?? 'u-text-style-h2';
$paragraphTextStyle = $content['paragraph_text_style'] ?? 'u-text-style-main';
$maxWidth = $content['max_width'] ?? 'u-max-width-70ch';
if ($alignment === 'text-center') {
$alignment = 'mx-auto text-center';
}
@endphp

@if ($eyebrow || $heading || $paragraph || !empty($buttonGroup))
<div class="content-wrapper u-margin-trim {{ $alignment }} {{ $maxWidth }} {{ $marginBottom }}">

  @if ($eyebrow)
  <p class="u-text-style-tagline mb-u-5">
    {!! $eyebrow !!}
  </p>
  @endif

  @if ($heading)
  <{{ $headingTag }} class="{{ $headingTextStyle }} u-margin-bottom-text">
    {!! $heading !!}
  </{{ $headingTag }}>
  @endif

  @if ($paragraph)
  <div class="prose {{ $paragraphTextStyle }} u-margin-bottom-text">
    {!! $paragraph !!}
  </div>
  @endif

  @if (!empty($buttonGroup))
  <div class="mt-u-6 flex flex-wrap gap-4 @if($alignment === 'text-center') justify-center @elseif($alignment === 'text-right') justify-end @else justify-start @endif">
    @foreach ($buttonGroup as $item)
    @php
    $button = $item['button'];
    $style = $item['style'] ?? 'primary';
    @endphp
    <a href="{{ $button['url'] }}" target="{{ $button['target'] }}" class="button button--{{ $style }}">{{ $button['title'] }}</a>
    @endforeach
  </div>
  @endif

</div>
@endif
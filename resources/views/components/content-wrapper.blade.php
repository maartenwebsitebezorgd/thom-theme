@props([
    'content' => [],
])

@php
  // Set default values
  $eyebrow = $content['eyebrow'] ?? null;
  $heading = $content['heading'] ?? null;
  $paragraph = $content['paragraph'] ?? null;
  $buttonGroup = $content['button_group'] ?? [];
  
  // Settings
  $alignment = $content['alignment'] ?? 'text-left';
  $headingTag = $content['heading_tag'] ?? 'h2';
  $headingTextStyle = $content['heading_text_style'] ?? 'u-text-style-h2';
  $paragraphTextStyle = $content['paragraph_text_style'] ?? 'u-text-style-main';

@endphp

@if ($eyebrow || $heading || $paragraph || !empty($buttonGroup))
  <div class="content-wrapper {{ $alignment }}">
    
    @if ($eyebrow)
      <p class="u-text-style-tagline u-margin-bottom-text text-indigo-600">
        {!! $eyebrow !!}
      </p>
    @endif

    @if ($heading)
      <{{ $headingTag }} class="{{ $headingTextStyle }} u-margin-bottom-text">
        {!! $heading !!}
      </{{ $headingTag }}>
    @endif

    @if ($paragraph)
      <div class="prose u-text-style-main u-margin-bottom-text">
        {!! $paragraph !!}
      </div>
    @endif

    @if (!empty($buttonGroup))
      <div class="mt-6 flex flex-wrap gap-4 @if($alignment === 'text-center') justify-center @elseif($alignment === 'text-right') justify-end @else justify-start @endif">
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
@php
$backgroundBlock = get_sub_field('background_block');
$visualBlock = get_sub_field('visual_block');
$contentBlock = get_sub_field('content_block');
$styleSettings = get_sub_field('style_settings');

// Layout settings
$contentPosition = get_sub_field('content_position') ?? 'center';
$verticalPosition = get_sub_field('vertical_position') ?? 'center';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-6';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';

//image settings
$visualFullWidth = $visualBlock['full_width'] ?? false;


// Map positions to flexbox classes
$horizontalAlign = match($contentPosition) {
'left' => 'justify-start',
'right' => 'justify-end',
default => 'justify-center'
};

$verticalAlign = match($verticalPosition) {
'top' => 'items-start',
'bottom' => 'items-end',
default => 'items-center'
};

// Check if visual should stretch with content
$shouldStretch = ($visualBlock['stretch_to_content'] ?? false);

// Check if background has content
$hasBackground = !empty($backgroundBlock['image']) || !empty($backgroundBlock['video_url']);
@endphp

<section data-theme="{{ $theme }}" class="hero u-section relative {{ $paddingTop }} {{ $paddingBottom }} overflow-hidden">

  {{-- Background Image/Video (only show if content exists) --}}
  @if ($hasBackground)
  <x-background :background="$backgroundBlock" />
  @endif

  {{-- Hero Content --}}
  <div class="u-container relative z-10 theme-bg">
    <div class="split-content_layout grid grid-cols-1 lg:grid-cols-2 {{ $gapSize }} {{ $shouldStretch ? 'items-stretch' : $verticalAlign }}">
      {{-- Content Column --}}
      <div class="content-column flex {{ $verticalAlign }}">
        <x-content-wrapper :content="$contentBlock" />
      </div>

      {{-- Visual Column --}}
      <div class="visual-column {{ $shouldStretch ? 'flex' : '' }} @if($visualFullWidth) max-w-none lg:w-[50vw] w-[100vw] @endif">
        <x-visual :visual="$visualBlock" class="{{ $shouldStretch ? 'flex-1' : '' }}" />
      </div>
    </div>
  </div>

</section>
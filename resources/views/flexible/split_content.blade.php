@php
$visualBlock = get_sub_field('visual_block');
$contentBlock = get_sub_field('content_block');
$styleSettings = get_sub_field('style_settings');

// Layout settings
$contentLayout = get_sub_field('content_layout') ?? 'visual-left';
$verticalAlignment = get_sub_field('vertical_alignment') ?? 'items-center';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-8';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';

// Determine column order
$visualFirst = $contentLayout === 'visual-left';

// Check if visual should stretch with content
$shouldStretch = ($visualBlock['stretch_to_content'] ?? false);
@endphp

<section data-theme="{{ $theme }}" class="u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container {{ $containerSize }}">
    <div class="split-content_layout grid md:grid-cols-2 {{ $gapSize }} {{ $shouldStretch ? 'items-stretch' : $verticalAlignment }}">

      @if ($visualFirst)
      {{-- Visual Left Layout --}}
      <div class="visual-column order-last md:order-first {{ $shouldStretch ? 'flex' : '' }}">
        <x-visual :visual="$visualBlock" class="{{ $shouldStretch ? 'flex-1' : '' }}" />
      </div>
      <div class="content-column flex {{ $verticalAlignment }}">
        <x-content-wrapper :content="$contentBlock" />
      </div>
      @else
      {{-- Visual Right Layout --}}
      <div class="content-column flex {{ $verticalAlignment }}">
        <x-content-wrapper :content="$contentBlock" />
      </div>
      <div class="visual-column order-last md:order-last  {{ $shouldStretch ? 'flex' : '' }}">
        <x-visual :visual="$visualBlock" class="{{ $shouldStretch ? 'flex-1' : '' }}" />
      </div>
      @endif

    </div>
  </div>
</section>
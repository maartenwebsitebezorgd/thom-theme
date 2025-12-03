@php
$contentBlock = get_sub_field('content_block');
$visualBlock = get_sub_field('visual_block');
$styleSettings = get_sub_field('style_settings');

// Layout settings
$contentMaxWidth = get_sub_field('content_max_width') ?? 'max-w-full';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-8';
$textAlignment = get_sub_field('text_alignment') ?? 'text-center';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';
@endphp

<section data-theme="{{ $theme }}" class="u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container {{ $containerSize }}">
    <div class="stacked-content_layout flex flex-col {{ $contentMaxWidth }} mx-auto {{ $gapSize }}">

      {{-- Content Block (Centered) --}}
      <div class="content-wrapper  w-full {{ $textAlignment }}">
        <x-content-wrapper :content="$contentBlock" />
      </div>

      {{-- Visual Block --}}
      <div class="visual-wrapper w-full">
        <x-visual :visual="$visualBlock" />
      </div>

    </div>
  </div>
</section>
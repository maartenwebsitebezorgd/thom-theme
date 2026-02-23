@php
$contentBlock = get_sub_field('content_block');
$images = get_sub_field('images');
$styleSettings = get_sub_field('style_settings');

// Grid settings
$gridColumnsDesktop = get_sub_field('grid_columns_desktop') ?? 'grid-cols-3';
$gridColumnsTablet = get_sub_field('grid_columns_tablet') ?? 'grid-cols-2';
$gridColumnsMobile = get_sub_field('grid_columns_mobile') ?? 'grid-cols-1';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-4';
$aspectRatio = get_sub_field('aspect_ratio') ?? 'aspect-square';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';
@endphp

<section data-theme="{{ $theme }}" class="image-gallery u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container {{ $containerSize }}">

    @if ($contentBlock)
    <x-content-wrapper :content="$contentBlock" />
    @endif

    @if ($images)
    <div class="image-gallery_grid grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
      @foreach ($images as $image)
      <div class="image-gallery_item overflow-hidden {{ $aspectRatio }}">
        <img
          src="{{ $image['sizes']['large'] ?? $image['url'] }}"
          alt="{{ $image['alt'] ?: ($image['title'] ?? '') }}"
          class="w-full h-full object-cover"
          loading="lazy"
          width="{{ $image['width'] ?? null }}"
          height="{{ $image['height'] ?? null }}" />
      </div>
      @endforeach
    </div>
    @endif

  </div>
</section>

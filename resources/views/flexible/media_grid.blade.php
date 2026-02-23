@php
$contentBlock = get_sub_field('content_block');
$items = get_sub_field('items');
$styleSettings = get_sub_field('style_settings');

// Grid settings
$gridColumnsDesktop = get_sub_field('grid_columns_desktop') ?? 'grid-cols-3';
$gridColumnsTablet = get_sub_field('grid_columns_tablet') ?? 'grid-cols-2';
$gridColumnsMobile = get_sub_field('grid_columns_mobile') ?? 'grid-cols-1';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-4';
$aspectRatio = get_sub_field('aspect_ratio') ?? 'aspect-[16/9]';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';
@endphp

<section data-theme="{{ $theme }}" class="media-grid u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container {{ $containerSize }}">

    @if ($contentBlock)
    <x-content-wrapper :content="$contentBlock" />
    @endif

    @if ($items)
    <div class="media-grid_grid grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
      @foreach ($items as $item)
      @php
      $visual = [
        'image'      => $item['media_type'] === 'image' ? ($item['image'] ?? null) : null,
        'video_url'  => match($item['media_type']) {
          'video_url'  => $item['video_url'] ?? null,
          'video_file' => $item['video_file']['url'] ?? null,
          default      => null,
        },
        'poster'       => $item['poster_image']['url'] ?? null,
        'aspect_ratio' => $aspectRatio,
      ];
      @endphp
      <x-visual :visual="$visual" />
      @endforeach
    </div>
    @endif

  </div>
</section>

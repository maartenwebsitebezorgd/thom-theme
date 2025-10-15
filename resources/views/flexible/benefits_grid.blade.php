@php
$contentBlock = get_sub_field('content_block');
$cards = get_sub_field('cards');
$styleSettings = get_sub_field('style_settings');

// Grid settings
$gridColumnsDesktop = get_sub_field('grid_columns_desktop') ?? 'grid-cols-4';
$gridColumnsTablet = get_sub_field('grid_columns_tablet') ?? 'grid-cols-2';
$gridColumnsMobile = get_sub_field('grid_columns_mobile') ?? 'grid-cols-1';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-6';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
// Card styling (section level)
$cardTheme = get_sub_field('card_theme') ?? 'inherit';

@endphp

<section data-theme="{{ $theme }}" class="benefits-grid u-section {{ $paddingTop }} {{ $paddingBottom }} @if ($bgColor) {{ $bgColor }} @endif">
  <div class="u-container">

    {{-- Section Content (Heading, Paragraph, Buttons) --}}
    @if ($contentBlock)
    <div class="mb-u-8">
      <x-content-wrapper :content="$contentBlock" />
    </div>
    @endif

    {{-- Cards Grid --}}
    @if ($cards)
    <div class="cards-grid grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
      @foreach ($cards as $cardItem)
      <x-benefit-card :card="$cardItem['benefit_card']" :section-theme="$theme" :card-theme="$cardTheme" />
      @endforeach
    </div>
    @endif

  </div>
</section>
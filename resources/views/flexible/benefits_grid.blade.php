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
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';
// Card styling (section level)
$cardTheme = get_sub_field('card_theme') ?? 'inherit';
$cardHeadingTextStyle = get_sub_field('card_heading_text_style') ?? 'u-text-style-h5';
$cardTextStyle = get_sub_field('card_text_style') ?? 'u-text-style-small';

@endphp

<section data-theme="{{ $theme }}" class="benefits-grid u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container {{ $containerSize }}">

    {{-- Section Content (Heading, Paragraph, Buttons) --}}
    @if ($contentBlock)
    <div class="">
      <x-content-wrapper :content="$contentBlock" />
    </div>
    @endif

    {{-- Cards Grid --}}
    @if ($cards)
    <div class="cards-grid group/benefits grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
      @foreach ($cards as $cardItem)
      <x-benefit-card
        classes="opacity-100 hover:!opacity-100 transition-opacity ease-in-out duration-200"
        :card="$cardItem['benefit_card']"
        :section-theme="$theme"
        :card-theme="$cardTheme"
        :heading-text-style="$cardHeadingTextStyle"
        :text-style="$cardTextStyle" />
      @endforeach
    </div>
    @endif

  </div>
</section>
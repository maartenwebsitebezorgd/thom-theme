@php
$contentBlock = get_sub_field('content_block');
$useGlobalServices = get_sub_field('use_global_services');
$selectedServices = get_sub_field('selected_services');
$styleSettings = get_sub_field('style_settings');

// Card styling (section level)
$cardTheme = get_sub_field('card_theme') ?? 'auto';
$headingTextStyle = get_sub_field('heading_text_style') ?? 'u-text-style-h6';
$iconSize = get_sub_field('icon_size') ?? 'size-u-4';

// Get cards based on mode
if ($useGlobalServices) {
    $globalServices = get_field('global_services', 'option');
    $cards = [];

    if ($globalServices && $selectedServices) {
        foreach ($selectedServices as $selectedItem) {
            $serviceIndex = $selectedItem['service'] ?? null;
            if ($serviceIndex !== null && isset($globalServices[$serviceIndex])) {
                $cards[] = ['service_card' => $globalServices[$serviceIndex]];
            }
        }
    }
} else {
    $cards = get_sub_field('cards');
}

// Grid settings
$gridColumnsDesktop = get_sub_field('grid_columns_desktop') ?? 'grid-cols-4';
$gridColumnsTablet = get_sub_field('grid_columns_tablet') ?? 'grid-cols-2';
$gridColumnsMobile = get_sub_field('grid_columns_mobile') ?? 'grid-cols-1';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-6';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
@endphp

<section data-theme="{{ $theme }}" class="services-grid u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container">

    {{-- Section Content (Heading, Paragraph, Buttons) --}}
    @if ($contentBlock)
    <x-content-wrapper :content="$contentBlock" />
    @endif

    {{-- Cards Grid --}}
    @if ($cards)
    <div class="cards-grid grid group/services {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
      @foreach ($cards as $cardItem)
      <x-service-card
        :card="$cardItem['service_card']"
        :section-theme="$theme"
        :card-theme="$cardTheme"
        :heading-text-style="$headingTextStyle"
        :icon-size="$iconSize"
        classes="opacity-100 group-hover/services:opacity-60 hover:!opacity-100 transition-opacity ease-in-out duration-200" />
      @endforeach
    </div>
    @endif

  </div>
</section>
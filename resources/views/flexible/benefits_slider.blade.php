@php
$contentBlock = get_sub_field('content_block');
$cards = get_sub_field('cards');
$styleSettings = get_sub_field('style_settings');
$swiperSettings = get_sub_field('swiper_settings');

// Card styling (section level)
$cardTheme = get_sub_field('card_theme') ?? 'auto';
$cardBgColor = get_sub_field('card_background_color') ?? 'auto';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$bgColor = $styleSettings['background_color'] ?? null;
@endphp

<section data-theme="{{ $theme }}" class="benefits-slider u-section {{ $paddingTop }} {{ $paddingBottom }} @if ($bgColor) {{ $bgColor }} @endif">
  <div class="u-container">

    {{-- Section Content (Heading, Paragraph, Buttons) --}}
    @if ($contentBlock)
    <div class="mb-u-8">
      <x-content-wrapper :content="$contentBlock" />
    </div>
    @endif

    {{-- Swiper Slider --}}
    @if ($cards)
    <x-swiper :settings="$swiperSettings">
      @foreach ($cards as $cardItem)
        <div class="swiper-slide">
          <x-benefit-card
            :card="$cardItem['benefit_card']"
            :section-bg-color="$bgColor"
            :section-theme="$theme"
            :card-theme="$cardTheme"
            :card-bg-color="$cardBgColor" />
        </div>
      @endforeach
    </x-swiper>
    @endif

  </div>
</section>

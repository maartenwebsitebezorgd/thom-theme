@php
$contentBlock = get_sub_field('content_block');
$useLatestCases = get_sub_field('use_latest_cases');
$selectedCases = get_sub_field('selected_cases');
$numberOfCases = get_sub_field('number_of_cases') ?? 8;
$scrollSpeed = get_sub_field('scroll_speed') ?? 30;
$fadeEdges = get_sub_field('fade_edges') ?? false;
$grayscaleEffect = get_sub_field('grayscale_effect') ?? false;
$pauseOnHover = get_sub_field('pause_on_hover') ?? false;
$styleSettings = get_sub_field('style_settings');

// Get cases
if ($useLatestCases) {
    $cases = get_posts([
        'post_type' => 'case',
        'posts_per_page' => $numberOfCases,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
} else {
    $cases = [];
    if ($selectedCases) {
        foreach ($selectedCases as $caseId) {
            $cases[] = get_post($caseId);
        }
    }
}

// Get logos
$logos = [];
foreach ($cases as $case) {
    $logo = get_field('logo', $case->ID);
    if ($logo) {
        $logos[] = [
            'url' => $logo['url'],
            'alt' => $logo['alt'] ?: $case->post_title,
            'title' => $case->post_title,
        ];
    }
}

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$bgColor = $styleSettings['background_color'] ?? null;

$uniqueId = uniqid('logo-slider-');
@endphp

<section data-theme="{{ $theme }}" class="logo-slider u-section {{ $paddingTop }} {{ $paddingBottom }} @if ($bgColor) {{ $bgColor }} @endif">
  <div class="u-container">

    {{-- Section Content (Heading, Paragraph, Buttons) --}}
    @if ($contentBlock)
      <x-content-wrapper :content="$contentBlock" />
    @endif

    {{-- Logo Slider --}}
    @if ($logos)
    <div class="logo-slider-wrapper @if($fadeEdges) fade-edges @endif @if($pauseOnHover) pause-on-hover @endif" id="{{ $uniqueId }}" data-scroll-speed="{{ $scrollSpeed }}">
      <div class="logo-slider-track">
        @foreach ($logos as $logo)
        <div class="logo-slide @if($grayscaleEffect) grayscale-effect @endif">
          <img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] }}" title="{{ $logo['title'] }}" loading="lazy">
        </div>
        @endforeach
        {{-- Duplicate multiple times for seamless loop on any screen size --}}
        @foreach ($logos as $logo)
        <div class="logo-slide @if($grayscaleEffect) grayscale-effect @endif">
          <img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] }}" title="{{ $logo['title'] }}" loading="lazy">
        </div>
        @endforeach
        @foreach ($logos as $logo)
        <div class="logo-slide @if($grayscaleEffect) grayscale-effect @endif">
          <img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] }}" title="{{ $logo['title'] }}" loading="lazy">
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</section>

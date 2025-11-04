@props([
'settings' => [],
'slides' => [],
'classes' => '',
])

@php
$uniqueId = uniqid('swiper-');

// Swiper settings
$slidesPerViewMobile = $settings['slides_per_view_mobile'] ?? 1;
$slidesPerViewTablet = $settings['slides_per_view_tablet'] ?? 2;
$slidesPerViewDesktop = $settings['slides_per_view_desktop'] ?? 3;
$spaceBetween = $settings['space_between'] ?? 20;
$loop = $settings['loop'] ?? false;
$autoplay = $settings['autoplay'] ?? false;
$autoplayDelay = $settings['autoplay_delay'] ?? 3000;
$navigation = $settings['navigation'] ?? true;
$navigationPosition = $settings['navigation_position'] ?? 'top-right';
$pagination = $settings['pagination'] ?? true;
$centeredSlides = $settings['centered_slides'] ?? false;

// Build config JSON
$config = [
'slidesPerView' => (float)$slidesPerViewMobile,
'spaceBetween' => (int)$spaceBetween,
'loop' => (bool)$loop,
'centeredSlides' => (bool)$centeredSlides,
'breakpoints' => [
768 => [
'slidesPerView' => (float)$slidesPerViewTablet,
],
1024 => [
'slidesPerView' => (float)$slidesPerViewDesktop,
],
],
];

if ($navigation) {
$config['navigation'] = [
'nextEl' => '.swiper-button-next-' . $uniqueId,
'prevEl' => '.swiper-button-prev-' . $uniqueId,
];
}

if ($pagination) {
$config['pagination'] = [
'el' => '.swiper-pagination-' . $uniqueId,
'clickable' => true,
];
}

if ($autoplay) {
$config['autoplay'] = [
'delay' => (int)$autoplayDelay,
'disableOnInteraction' => false,
];
}

$configJson = json_encode($config);
@endphp

<div class="swiper-container swiper-nav-{{ $navigationPosition }} {{ $classes }}" data-swiper-id="{{ $uniqueId }}">
  @if ($navigation && $navigationPosition === 'top-right')
  <div class="swiper-navigation-top">
    <div class="swiper-button-prev swiper-button-prev-{{ $uniqueId }}"></div>
    <div class="swiper-button-next swiper-button-next-{{ $uniqueId }}"></div>
  </div>
  @endif

  <div class="swiper {{ $uniqueId }}" data-swiper-config="{{ $configJson }}">
    <div class="swiper-wrapper group/multi-slider">
      {{ $slot }}
    </div>
  </div>

  @if ($pagination)
  <div class="swiper-pagination swiper-pagination-{{ $uniqueId }}"></div>
  @endif

  @if ($navigation && $navigationPosition === 'absolute')
  <div class="swiper-button-prev swiper-button-prev-{{ $uniqueId }}"></div>
  <div class="swiper-button-next swiper-button-next-{{ $uniqueId }}"></div>
  @endif
</div>
@props([
'background' => [],
'class' => '',
])

@php
// Extract background settings
$image = $background['image'] ?? null;
$videoUrl = $background['video_url'] ?? null;

// Settings
$position = $background['position'] ?? 'bg-center';
$size = $background['size'] ?? 'bg-cover';
$fixed = $background['fixed'] ?? false;
$overlayOpacity = $background['overlay_opacity'] ?? 40;
$overlayColor = $background['overlay_color'] ?? '#000000';

// Performance
$lazyLoading = $background['lazy_loading'] ?? false;
$priorityLoading = $background['priority_loading'] ?? true;

// Check if it's a video
$isVideo = !empty($videoUrl);
$isYouTube = $isVideo && (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be'));
$isVimeo = $isVideo && str_contains($videoUrl, 'vimeo.com');

// Extract video ID for embed URLs
$getYouTubeId = function($url) {
preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
return $matches[1] ?? null;
};

$getVimeoId = function($url) {
preg_match('/vimeo\.com\/(?:channels\/[^\/]+\/|groups\/[^\/]+\/videos\/|album\/\d+\/video\/|video\/|)(\d+)(?:$|\/|\?)/', $url, $matches);
return $matches[1] ?? null;
};

// Convert overlay opacity to decimal
$overlayOpacityDecimal = $overlayOpacity / 100;

// Build background classes
$backgroundClasses = [
'absolute',
'inset-0',
'w-full',
'h-full',
$position,
$size,
$fixed ? 'bg-fixed' : '',
$class
];
@endphp

@if ($image || $isVideo)
<div class="background-component absolute inset-0 overflow-hidden">

  {{-- Video Background --}}
  @if ($isVideo)
  @if ($isYouTube)
  @php $videoId = $getYouTubeId($videoUrl); @endphp
  @if ($videoId)
  <div class="absolute inset-0 w-full h-full pointer-events-none">
    <iframe
      class="absolute top-1/2 left-1/2 w-[100vw] h-[56.25vw] min-h-[100vh] min-w-[177.77vh] -translate-x-1/2 -translate-y-1/2"
      src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1"
      frameborder="0"
      allow="autoplay; encrypted-media"
      title="Background video"></iframe>
  </div>
  @endif

  @elseif ($isVimeo)
  @php $videoId = $getVimeoId($videoUrl); @endphp
  @if ($videoId)
  <div class="absolute inset-0 w-full h-full pointer-events-none">
    <iframe
      class="absolute top-1/2 left-1/2 w-[100vw] h-[56.25vw] min-h-[100vh] min-w-[177.77vh] -translate-x-1/2 -translate-y-1/2"
      src="https://player.vimeo.com/video/{{ $videoId }}?autoplay=1&muted=1&loop=1&background=1&controls=0"
      frameborder="0"
      allow="autoplay; fullscreen"
      title="Background video"></iframe>
  </div>
  @endif

  @else
  {{-- Direct video file --}}
  <video
    class="absolute inset-0 w-full h-full object-cover"
    autoplay
    muted
    loop
    playsinline
    @if($lazyLoading && !$priorityLoading) preload="none" @else preload="auto" @endif>
    <source src="{{ $videoUrl }}" type="video/mp4">
  </video>
  @endif

  {{-- Image Background --}}
  @elseif ($image)
  <div
    class="{{ implode(' ', array_filter($backgroundClasses)) }}"
    style="background-image: url('{{ $image['sizes']['large'] ?? $image['url'] }}');"
    role="img"
    aria-label="{{ $image['alt'] ?? '' }}"></div>

  {{-- Preload for better performance if priority loading --}}
  @if ($priorityLoading)
  <link rel="preload" as="image" href="{{ $image['sizes']['large'] ?? $image['url'] }}" />
  @endif
  @endif

  {{-- Overlay --}}
  @if ($overlayOpacity > 0)
  <div
    class="absolute inset-0 pointer-events-none"
    style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacityDecimal }};"></div>
  @endif

</div>
@endif
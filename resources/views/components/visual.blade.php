@props([
    'visual' => [],
    'class' => '',
    'aspectRatio' => null,
    'objectFit' => null,
    'stretchToContent' => null,
    'fullWidth' => null,
    'borderRadius' => null,
    'lazyLoading' => null,
    'priorityLoading' => null,
    'hoverEffect' => null,
    'clipPath' => null,
])

@php
  // Extract visual settings
  $image = $visual['image'] ?? null;
  $altText = $visual['alt_text'] ?? $image['alt'] ?? '';
  $videoUrl = $visual['video_url'] ?? null;
  $caption = $visual['caption'] ?? null;

  // Layout settings - props override visual array
  $aspectRatio = $aspectRatio ?? $visual['aspect_ratio'] ?? 'aspect-[16/9]';
  $objectFit = $objectFit ?? $visual['object_fit'] ?? 'object-cover';
  $stretchToContent = $stretchToContent ?? $visual['stretch_to_content'] ?? false;
  $fullWidth = $fullWidth ?? $visual['full_width'] ?? false;
  $borderRadius = $borderRadius ?? $visual['border_radius'] ?? '';

  // Performance settings - props override visual array
  $lazyLoading = $lazyLoading ?? $visual['lazy_loading'] ?? true;
  $priorityLoading = $priorityLoading ?? $visual['priority_loading'] ?? false;
  $imageSizes = $visual['image_sizes'] ?? 'auto';

  // Effects - props override visual array
  $hoverEffect = $hoverEffect ?? $visual['hover_effect'] ?? '';
  $opacity = $visual['opacity'] ?? 100;
  $clipPath = $clipPath ?? $visual['clip_path'] ?? '';
  $customClipPath = $visual['custom_clip_path'] ?? '';

  // Build classes
  $containerClasses = [
    'visual-component',
    'relative',
    'overflow-hidden',
    $fullWidth ? 'w-screen -mx-[var(--site--margin)] relative left-1/2 right-1/2 -translate-x-1/2' : '',
    $stretchToContent ? 'h-full min-h-0' : ($aspectRatio !== 'aspect-auto' ? $aspectRatio : ''),
    $borderRadius,
    $hoverEffect ? "transition-all duration-300 ease-in-out {$hoverEffect}" : '',
    $class
  ];

  // Build style attributes
  $styleAttributes = [];

  // Add aspect ratio when stretching to content
  if ($stretchToContent && $aspectRatio !== 'aspect-auto') {
    $aspectRatioValue = match($aspectRatio) {
      'aspect-square' => '1/1',
      'aspect-[4/3]' => '4/3',
      'aspect-[3/2]' => '3/2',
      'aspect-[16/9]' => '16/9',
      'aspect-[21/9]' => '21/9',
      'aspect-[2/1]' => '2/1',
      default => null
    };

    if ($aspectRatioValue) {
      $styleAttributes[] = 'aspect-ratio: ' . $aspectRatioValue;
      $styleAttributes[] = 'min-height: 100%';
    }
  }

  // Add clip path
  if ($clipPath) {
    $clipPathValue = match($clipPath) {
      'diagonal-left' => 'polygon(25% 0%, 100% 0%, 100% 100%, 25% 100%, 0% 50%);',
      'diagonal-right' => 'polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%);',
      'custom' => $customClipPath,
      default => null
    };

    if ($clipPathValue) {
      $styleAttributes[] = 'clip-path: ' . $clipPathValue;
    }
  }

  // Build final style attribute
  $styleAttribute = !empty($styleAttributes) ? 'style="' . implode('; ', $styleAttributes) . '"' : '';

  $mediaClasses = [
    'w-full',
    'h-full',
    $objectFit,
    $opacity < 100 ? 'opacity-' . $opacity : '',
  ];

  // Generate responsive sizes attribute
  $sizesAttribute = match($imageSizes) {
    'auto' => $fullWidth ? '100vw' : '(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 1200px',
    default => $imageSizes
  };

  // Generate srcset for responsive images
  $generateSrcset = function($image) {
    if (!$image || !isset($image['sizes'])) return '';

    $srcset = [];
    $sizes = ['thumbnail', 'medium', 'medium_large', 'large', 'full'];

    foreach ($sizes as $size) {
      if (isset($image['sizes'][$size . '-width']) && isset($image['sizes'][$size])) {
        $width = $image['sizes'][$size . '-width'];
        $url = $image['sizes'][$size];
        $srcset[] = "{$url} {$width}w";
      }
    }

    return implode(', ', $srcset);
  };

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
@endphp

@if ($image || $isVideo)
  <figure class="{{ implode(' ', array_filter($containerClasses)) }} !mb-0"
          {!! $styleAttribute !!}>

    {{-- Video Content --}}
    @if ($isVideo)
      @if ($isYouTube)
        @php $videoId = $getYouTubeId($videoUrl); @endphp
        @if ($videoId)
          <iframe
            class="{{ implode(' ', array_filter($mediaClasses)) }}"
            src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?rel=0&modestbranding=1&showinfo=0"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            loading="{{ $lazyLoading && !$priorityLoading ? 'lazy' : 'eager' }}"
            title="{{ $altText }}"
          ></iframe>
        @endif

      @elseif ($isVimeo)
        @php $videoId = $getVimeoId($videoUrl); @endphp
        @if ($videoId)
          <iframe
            class="{{ implode(' ', array_filter($mediaClasses)) }}"
            src="https://player.vimeo.com/video/{{ $videoId }}?dnt=1&app_id=122963"
            frameborder="0"
            allow="autoplay; fullscreen; picture-in-picture"
            allowfullscreen
            loading="{{ $lazyLoading && !$priorityLoading ? 'lazy' : 'eager' }}"
            title="{{ $altText }}"
          ></iframe>
        @endif

      @else
        {{-- Direct video file --}}
        <video
          class="{{ implode(' ', array_filter($mediaClasses)) }}"
          controls
          @if($lazyLoading && !$priorityLoading) preload="none" @else preload="metadata" @endif
        >
          <source src="{{ $videoUrl }}" type="video/mp4">
          <p>Your browser doesn't support video playback. <a href="{{ $videoUrl }}">Download the video</a>.</p>
        </video>
      @endif

    {{-- Image Content --}}
    @elseif ($image)
      <img
        class="{{ implode(' ', array_filter($mediaClasses)) }}"
        src="{{ $image['sizes']['medium'] ?? $image['url'] }}"
        @if($generateSrcset($image)) srcset="{{ $generateSrcset($image) }}" @endif
        @if($imageSizes !== 'auto') sizes="{{ $sizesAttribute }}" @endif
        alt="{{ $altText }}"
        width="{{ $image['width'] ?? '' }}"
        height="{{ $image['height'] ?? '' }}"
        @if($lazyLoading && !$priorityLoading)
          loading="lazy"
          decoding="async"
        @else
          loading="eager"
          @if($priorityLoading) fetchpriority="high" @endif
        @endif
      />
    @endif

    {{-- Caption --}}
    @if ($caption)
      <figcaption class="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-4 text-sm">
        {{ $caption }}
      </figcaption>
    @endif

  </figure>
@endif
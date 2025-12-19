@php
$post_id = get_the_ID();
$thumbnail = get_post_thumbnail_id($post_id);
$image = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;

// Get video fields
$videoUrl = function_exists('get_field') ? get_field('video_url', $post_id) : null;
$duration = function_exists('get_field') ? get_field('duration', $post_id) : null;
$description = function_exists('get_field') ? get_field('description', $post_id) : null;

// Get settings from parent scope or use defaults
$sectionTheme = $sectionTheme ?? 'light';
$cardTheme = $cardTheme ?? 'auto';
$imageAspectRatio = $imageAspectRatio ?? 'aspect-video';
$showExcerpt = $showExcerpt ?? true;
$showCategory = $showCategory ?? false;
$makeCardClickable = $makeCardClickable ?? false;
$partialClasses = $partialClasses ?? ''; // Accept custom classes from parent

// Auto theme: Use opposite of section theme (light <-> dark)
if ($cardTheme === 'auto') {
  $cardTheme = match($sectionTheme) {
    'light' => 'grey',
    'dark' => 'accent-light',
    default => 'inherit',
  };
}

// Build visual block for thumbnail
$visualBlock = $image ? [
  'media_type' => 'image',
  'image' => [
    'url' => $image[0],
    'alt' => get_post_meta($thumbnail, '_wp_attachment_image_alt', true),
    'width' => $image[1] ?? null,
    'height' => $image[2] ?? null,
  ],
  'aspect_ratio' => $imageAspectRatio,
] : null;

// Generate unique ID for video player
$uniqueId = uniqid('video-');

// Generate post classes as array
$postClasses = get_post_class('video-card w-full h-full flex flex-col overflow-hidden group ' . $partialClasses);
$articleClasses = implode(' ', $postClasses);

// Extract video embed ID from URL or detect direct video files
$embedCode = null;
$isDirectVideo = false;
if ($videoUrl) {
  if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $matches) ||
      preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $videoUrl, $matches) ||
      preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $matches)) {
    $embedCode = 'https://www.youtube.com/embed/' . $matches[1];
  } elseif (preg_match('/vimeo\.com\/([0-9]+)/', $videoUrl, $matches)) {
    $embedCode = 'https://player.vimeo.com/video/' . $matches[1];
  } elseif (preg_match('/\.(mp4|webm|ogg|mov)$/i', $videoUrl)) {
    // Direct video file (MP4, WebM, OGG, MOV)
    $embedCode = $videoUrl;
    $isDirectVideo = true;
  }
}
@endphp

<article
  class="{{ $articleClasses }}"
  data-theme="{{ $cardTheme }}"
  role="article"
  aria-labelledby="{{ $uniqueId }}-title">

  <div class="video-link-wrapper flex flex-col h-full">

    {{-- Video Thumbnail with Play Button --}}
    <div class="video-card-media-wrap relative overflow-hidden">
      @if($embedCode)
      {{-- Embedded Video Player (shown immediately if no thumbnail, otherwise hidden) --}}
      <div id="{{ $uniqueId }}-player" class="video-embed-container {{ $imageAspectRatio }} relative {{ $visualBlock ? 'hidden' : '' }}">
        @if($isDirectVideo)
        {{-- HTML5 Video Player for MP4/WebM/OGG --}}
        <video
          class="absolute inset-0 w-full h-full object-cover"
          controls
          playsinline>
          <source src="{{ $embedCode }}" type="video/{{ pathinfo($embedCode, PATHINFO_EXTENSION) }}">
          Your browser does not support the video tag.
        </video>
        @else
        {{-- iFrame for YouTube/Vimeo --}}
        <iframe
          src="{{ $embedCode }}{{ $visualBlock ? '?autoplay=1' : '' }}"
          class="absolute inset-0 w-full h-full"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
        @endif
      </div>
      @endif

      @if($visualBlock)
      {{-- Thumbnail with Play Overlay --}}
      <div id="{{ $uniqueId }}-thumbnail" class="video-card-thumbnail relative cursor-pointer" @if($embedCode) onclick="playVideo('{{ $uniqueId }}')" @endif>
        <x-visual :visual="$visualBlock" />

        {{-- Play Button Overlay --}}
        <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition-colors">
          <div class="w-16 h-16 flex items-center justify-center rounded-full bg-white/90 group-hover:bg-white group-hover:scale-110 transition-all">
            <svg class="w-8 h-8 text-[var(--theme-accent)] ml-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M8 5v14l11-7z"/>
            </svg>
          </div>
        </div>

        {{-- Duration Badge --}}
        @if($duration)
        <div class="absolute bottom-2 right-2 px-2 py-1 bg-black/80 text-white text-xs font-medium rounded">
          {{ $duration }}
        </div>
        @endif
      </div>
      @endif
    </div>

    {{-- Video Content --}}
    <div class="video-card-content-wrap flex flex-col grow">
      <div class="video-card-content-top flex-1 px-u-4 pt-u-5 pb-u-5 u-margin-trim">

        <h3 id="{{ $uniqueId }}-title" class="video-card-title u-text-style-h5 u-margin-bottom-text">
          <span class="video-card-title-text">{!! get_the_title() !!}</span>
        </h3>

        @if($showExcerpt && ($description || has_excerpt() || get_the_content()))
        @php
        $excerptText = $description ?: get_the_excerpt();
        $excerptWordCount = function_exists('get_field') ? get_field('excerpt_word_count', 'option') : 20;
        $excerptWordCount = $excerptWordCount ?: 20;
        $excerptMoreText = function_exists('get_field') ? get_field('excerpt_more_text', 'option') : '...';
        $excerptMoreText = $excerptMoreText !== null ? $excerptMoreText : '...';
        @endphp
        <p class="u-text-style-main u-margin-bottom-text">
          {{ wp_trim_words($excerptText, $excerptWordCount, $excerptMoreText) }}
        </p>
        @endif
      </div>

      @if(!$embedCode)
      <div class="video-card-content-bottom flex flex-nowrap items-center justify-end px-u-4 pt-u-4 pb-u-4">
        <a
          href="{{ get_permalink() }}"
          class="button button--icon-only ml-auto">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </a>
      </div>
      @endif
    </div>

  </div>
</article>

@if($embedCode)
<script>
function playVideo(videoId) {
  const thumbnail = document.getElementById(videoId + '-thumbnail');
  const player = document.getElementById(videoId + '-player');

  if (thumbnail && player) {
    thumbnail.classList.add('hidden');
    player.classList.remove('hidden');

    // For HTML5 video elements, explicitly trigger play
    const videoElement = player.querySelector('video');
    if (videoElement) {
      videoElement.play().catch(function(error) {
        console.log('Autoplay was prevented:', error);
      });
    }
  }
}
</script>
@endif

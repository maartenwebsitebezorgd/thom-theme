@php
$quoteText = get_sub_field('quote_text');
$authorName = get_sub_field('author_name');
$authorTitle = get_sub_field('author_title');
$authorImage = get_sub_field('author_image');
$styleSettings = get_sub_field('style_settings');

// Layout settings
$contentMaxWidth = get_sub_field('content_max_width') ?? 'max-w-4xl';
$quoteTextStyle = get_sub_field('quote_text_style') ?? 'u-text-style-h3';
$textAlignment = get_sub_field('text_alignment') ?? 'text-center';

// Style settings
$theme = $styleSettings['theme'] ?? 'blue';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';
@endphp

<section data-theme="{{ $theme }}" class="u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container {{ $containerSize }}">
    <div class="quote_layout {{ $contentMaxWidth }} mx-auto w-full {{ $textAlignment }}">

      {{-- Quote Text --}}
      @if($quoteText)
      <blockquote class="quote-text">
        <p class="{{ $quoteTextStyle }} u-margin-bottom-text">{{ $quoteText }}</p>
      </blockquote>
      @endif

      {{-- Author Info --}}
      @if($authorName || $authorTitle || $authorImage)
      <div class="quote-author flex flex-col {{ $textAlignment === 'text-center' ? 'items-center' : ($textAlignment === 'text-right' ? 'items-end' : 'items-start') }} gap-u-4 mt-u-6">

        @if($authorImage)
        <div class="author-image w-16 h-16 rounded-full overflow-hidden">
          <img
            src="{{ $authorImage['sizes']['thumbnail'] ?? $authorImage['url'] }}"
            alt="{{ $authorImage['alt'] ?: $authorName }}"
            class="w-full h-full object-cover" />
        </div>
        @endif

        <div class="author-details">
          @if($authorName)
          <cite class="author-name u-text-style-h6 not-italic block">{{ $authorName }}</cite>
          @endif

          @if($authorTitle)
          <span class="author-title u-text-style-small block opacity-80 mt-u-1">{{ $authorTitle }}</span>
          @endif
        </div>
      </div>
      @endif

    </div>
  </div>
</section>
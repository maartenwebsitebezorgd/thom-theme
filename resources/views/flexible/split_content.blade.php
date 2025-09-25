@php
  $contentBlock = get_sub_field('content_block');
  $layout = get_sub_field('layout') ?: 'center';
  $bgColor = get_sub_field('background_color') ?: 'bg-white';

  $maxWidthClass = match ($layout) {
      'left' => 'max-w-4xl',
      'wide' => 'max-w-full',
      default => 'max-w-4xl',
  };
@endphp

<section class="u-section {{ $bgColor }}">
  <div class="u-container">
    <x-content-wrapper :content="$contentBlock" />
  </div>
</section>
@extends('layouts.app')

@section('content')
@include('partials.page-header')

@php
// Get filter settings from ACF options
$enableFilters = get_field('enable_filters', 'option') ?? true;
$activeFilters = get_field('active_filters', 'option') ?? ['category-badges'];
$filterTheme = get_field('filter_theme', 'option') ?? 'light';

// Get section settings from ACF options with fallbacks
$sectionTheme = get_field('section_theme', 'option') ?? 'light';
$gridColumnsDesktop = get_field('grid_columns_desktop', 'option') ?? 'grid-cols-3';
$gridColumnsTablet = get_field('grid_columns_tablet', 'option') ?? 'grid-cols-2';
$gridColumnsMobile = get_field('grid_columns_mobile', 'option') ?? 'grid-cols-1';
$gapSize = get_field('gap_size', 'option') ?? 'gap-u-6';

// Get card settings from ACF options with fallbacks
$cardTheme = get_field('card_theme', 'option') ?? 'auto';
$imageAspectRatio = get_field('image_aspect_ratio', 'option') ?? 'aspect-[3/2]';
$showExcerpt = get_field('show_excerpt', 'option') ?? true;
$showCategory = get_field('show_category', 'option') ?? false;
$makeCardClickable = get_field('make_card_clickable', 'option') ?? true;
@endphp

{{-- Whitepapers Grid --}}
<section data-theme="{{ $sectionTheme }}" class="pt-section-small pb-section-small">
  <div class="u-container max-w-container-main">
    <div class="whitepapers-grid">
      @if (! have_posts())
      <div class="u-max-width-70ch mx-auto text-center">
        <p class="u-text-style-medium mb-u-6">
          {!! __('Sorry, no whitepapers were found.', 'sage') !!}
        </p>
        {!! get_search_form(false) !!}
      </div>
      @else
      {{-- Whitepapers Grid --}}
      <div class="grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
        @php
        while (have_posts()) {
            the_post();
        @endphp
            @include('partials.content-whitepaper')
        @php
        }
        @endphp
      </div>

      {{-- Pagination --}}
      <div class="mt-section-main">
        @include('partials.pagination')
      </div>
      @endif
    </div>
</section>

{{-- Flexible Content Blocks from Whitepapers Archive Page --}}
@php
$whitepapersPageId = get_field('page_for_whitepapers', 'option');

if ($whitepapersPageId && have_rows('content_blocks', $whitepapersPageId)) {
    while (have_rows('content_blocks', $whitepapersPageId)) {
        the_row();
        $layout = get_row_layout();

        // Try to include the flexible content block
        $flexibleView = 'flexible.' . $layout;
        if (view()->exists($flexibleView)) {
            echo view($flexibleView)->render();
        } elseif (view()->exists('flexible.default')) {
            echo view('flexible.default')->render();
        }
    }
}
@endphp

@endsection

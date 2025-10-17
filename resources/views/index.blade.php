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
$showCategory = get_field('show_category', 'option') ?? true;
$makeCardClickable = get_field('make_card_clickable', 'option') ?? true;
@endphp

{{-- Filters --}}
@if($enableFilters && !empty($activeFilters))
<x-filters.filter-container :filters="$activeFilters" :theme="$filterTheme" />
@endif

{{-- Posts Grid --}}
<section data-theme="{{ $sectionTheme }}" class="pt-section-main pb-section-main">
  <div class="u-container">
    <div class="posts-grid">
      @if (! have_posts())
      <div class="u-max-width-70ch mx-auto text-center">
        <p class="u-text-style-medium mb-u-6">
          {!! __('Sorry, no posts were found.', 'sage') !!}
        </p>
        {!! get_search_form(false) !!}
      </div>
      @else
      {{-- Posts Grid --}}
      <div class="grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
        @while(have_posts()) @php(the_post())
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
        @endwhile
      </div>

      {{-- Pagination --}}
      @if (function_exists('wp_pagenavi'))
      <div class="mt-section-main">
        {!! wp_pagenavi() !!}
      </div>
      @else
      <div class="mt-section-main flex justify-between gap-u-4">
        <div>
          {!! get_previous_posts_link(__('&larr; Newer Posts', 'sage')) !!}
        </div>
        <div>
          {!! get_next_posts_link(__('Older Posts &rarr;', 'sage')) !!}
        </div>
      </div>
      @endif
      @endif
    </div>
</section>
@endsection
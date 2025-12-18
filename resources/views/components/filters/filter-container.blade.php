@props([
'filters' => [], // Array of filter types to display: ['category-badges', 'search-field', 'dropdown-filter']
'theme' => 'light',
])

@php
// Check if we have any filters to display
$hasFilters = !empty($filters);
@endphp

@if($hasFilters)
<section data-theme="{{ $theme }}" class="u-section filter-section pt-section-small pb-section-small">
  <div class="u-container max-w-container-main">
    <div class="filters-wrapper flex flex-col gap-u-4">
      @foreach($filters as $filterType)
      @if($filterType === 'category-badges')
      <x-filters.category-badges />
      @elseif($filterType === 'search-field')
      <x-filters.search-field />
      @elseif($filterType === 'dropdown-filter')
      <x-filters.dropdown-filter />
      @endif
      @endforeach
    </div>
  </div>
</section>
@endif
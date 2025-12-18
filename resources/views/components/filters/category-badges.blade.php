@php
// Determine current taxonomy and post type based on the archive
$currentTaxonomy = 'category'; // Default to posts category
$postType = 'post';

if (is_tax('case_category') || (is_post_type_archive('case') || get_post_type() === 'case')) {
    $currentTaxonomy = 'case_category';
    $postType = 'case';
}

// Get all categories for the current taxonomy
$categories = get_terms([
    'taxonomy' => $currentTaxonomy,
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC',
]);

// Get current category if on a category archive
$currentCategoryId = null;
if (is_category() || is_tax('case_category')) {
    $currentTerm = get_queried_object();
    $currentCategoryId = $currentTerm->term_id ?? null;
}

// Get archive URL (main posts or cases archive)
$allUrl = is_tax('case_category') || is_post_type_archive('case')
    ? get_post_type_archive_link('case')
    : (get_option('page_for_posts') ? get_permalink(get_option('page_for_posts')) : home_url('/'));
@endphp

@if(!empty($categories))
<div class="category-badges-filter" data-filter-type="category">
  <div class="badges-scroll-container overflow-x-auto scrollbar-hide">
    <div class="badges-wrapper flex gap-u-2">
      {{-- All Badge --}}
      <button
        type="button"
        class="badge {{ $currentCategoryId === null ? 'badge-active' : 'badge-outline' }}"
        data-category-id=""
        data-category-slug=""
        data-category-name="All"
        data-filter-action="category"
        aria-label="{{ __('Show all', 'sage') }}"
      >
        {{ __('Alle', 'sage') }}
      </button>

      {{-- Category Badges --}}
      @foreach($categories as $category)
        <button
          type="button"
          class="badge {{ $currentCategoryId === $category->term_id ? 'badge-active' : 'badge-outline' }}"
          data-category-id="{{ $category->term_id }}"
          data-category-name="{{ $category->name }}"
          data-category-slug="{{ $category->slug }}"
          data-filter-action="category"
          aria-label="{{ sprintf(__('Filter by %s', 'sage'), $category->name) }}"
        >
          {!! $category->name !!}
          <span class="opacity-70 ml-u-1">({{ $category->count }})</span>
        </button>
      @endforeach
    </div>
  </div>
</div>

<style>
  /* Hide scrollbar but keep functionality */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>
@endif

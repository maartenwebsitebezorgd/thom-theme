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
<div class="category-badges-filter">
  <div class="badges-scroll-container overflow-x-auto scrollbar-hide">
    <div class="badges-wrapper flex gap-u-2">
      {{-- All Badge --}}
      <x-ui.badge
        :href="$allUrl"
        :variant="$currentCategoryId === null ? 'active' : 'outline'"
      >
        {{ __('All', 'sage') }}
      </x-ui.badge>

      {{-- Category Badges --}}
      @foreach($categories as $category)
        <x-ui.badge
          :href="get_term_link($category)"
          :variant="$currentCategoryId === $category->term_id ? 'active' : 'outline'"
        >
          {{ $category->name }}
          <span class="opacity-70 ml-u-1">({{ $category->count }})</span>
        </x-ui.badge>
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

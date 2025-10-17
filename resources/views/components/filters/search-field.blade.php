@props([
  'placeholder' => 'Search...',
])

<div class="search-field-filter" data-filter-type="search">
  <div class="relative">
    <input
      type="text"
      id="archive-search-input"
      data-search-input
      placeholder="{{ $placeholder }}"
      class="w-full px-u-4 py-u-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-colors"
      autocomplete="off"
    />
    <svg class="absolute right-u-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
    {{-- Loading spinner (hidden by default) --}}
    <div class="absolute right-u-3 top-1/2 -translate-y-1/2 hidden search-loading">
      <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    </div>
  </div>
</div>

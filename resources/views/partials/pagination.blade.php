@php
/**
* Pagination Navigation
* Tailwind-inspired pagination with numbered pages
*/

global $wp_query;

if (!isset($wp_query)) {
return;
}

$total_pages = $wp_query->max_num_pages;
$current_page = max(1, get_query_var('paged'));

// Only show pagination if there's more than one page
if ($total_pages <= 1) {
  return;
  }

  // Pagination settings
  $mid_size=2; // Number of pages to show on either side of current page
  $end_size=1; // Number of pages to show at the beginning and end

  // Generate page numbers array
  $pages=[];

  // Always add first page
  $pages[]=1;

  // Add pages around current page
  $start=max(2, $current_page - $mid_size);
  $end=min($total_pages - 1, $current_page + $mid_size);

  // Add ellipsis after first page if needed
  if ($start> 2) {
  $pages[] = '...';
  }

  // Add middle pages
  for ($i = $start; $i <= $end; $i++) {
    $pages[]=$i;
    }

    // Add ellipsis before last page if needed
    if ($end < $total_pages - 1) {
    $pages[]='...' ;
    }

    // Always add last page (if more than 1 page)
    if ($total_pages> 1) {
    $pages[] = $total_pages;
    }

    // Remove duplicate pages
    $pages = array_unique($pages);
    @endphp

    <nav class="flex items-center justify-center" aria-label="Pagination">
      <div class="flex items-center gap-u-1">
        {{-- Previous Button --}}
        @if ($current_page > 1)
        <a
          href="{{ get_previous_posts_page_link() }}"
          class="inline-flex items-center justify-center min-w-[2.5rem] aspect-square px-u-3 rounded-round border border-[var(--theme-text)]/20 hover:bg-[var(--theme-text)]/5 transition-colors u-text-style-small"
          aria-label="{{ __('Previous page', 'sage') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
        @else
        <span class="inline-flex items-center justify-center min-w-[2.5rem] aspect-square px-u-3 rounded-round border border-[var(--theme-text)]/10 text-[var(--theme-text)]/30 cursor-not-allowed u-text-style-small" aria-disabled="true">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </span>
        @endif

        {{-- Page Numbers --}}
        @foreach ($pages as $page)
        @if ($page === '...')
        <span class="inline-flex items-center justify-center min-w-[2.5rem] aspect-square px-u-3 rounded-round bg-[var(--button-primary-bg)] u-text-style-small text-[var(--theme-text)]">
          &hellip;
        </span>
        @elseif ($page == $current_page)
        <span
          class="inline-flex items-center justify-center min-w-[2.5rem] aspect-square px-u-3 rounded-round bg-[var(--button-primary-bg)] text-white font-medium u-text-style-small"
          aria-current="page">
          {{ $page }}
        </span>
        @else
        <a
          href="{{ get_pagenum_link($page) }}"
          class="inline-flex items-center justify-center min-w-[2.5rem] aspect-square px-u-3 rounded-round bg-transparent border border-[var(--theme-text)]/20 hover:bg-[var(--theme-text)]/5 transition-colors u-text-style-small"
          aria-label="{{ sprintf(__('Go to page %s', 'sage'), $page) }}">
          {{ $page }}
        </a>
        @endif
        @endforeach

        {{-- Next Button --}}
        @if ($current_page < $total_pages)
          <a
          href="{{ get_next_posts_page_link() }}"
          class="inline-flex items-center justify-center min-w-[2.5rem] aspect-square px-u-3 rounded-round bg-transparent border border-[var(--theme-text)]/20 hover:bg-[var(--theme-text)]/5 transition-colors u-text-style-small"
          aria-label="{{ __('Next page', 'sage') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
          </a>
          @else
          <span class="inline-flex items-center justify-center min-w-[2.5rem] aspect-square px-u-3 rounded-round bg-transparent border border-[var(--theme-text)]/10 text-[var(--theme-text)]/30 cursor-not-allowed u-text-style-small" aria-disabled="true">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </span>
          @endif
      </div>
    </nav>
/**
 * Archive Filters JavaScript
 * Handles live search and filtering for archive pages
 */

class ArchiveFilters {
  constructor() {
    this.searchInput = document.querySelector('[data-search-input]');
    this.postsGrid = document.querySelector('.posts-grid');
    this.searchTimeout = null;
    this.searchDelay = 500; // ms debounce delay

    if (this.searchInput) {
      this.init();
    }
  }

  init() {
    // Add event listener for search input
    this.searchInput.addEventListener('input', (e) => {
      this.handleSearch(e.target.value);
    });

    // Add loading state class to grid container
    if (this.postsGrid) {
      this.postsGrid.classList.add('filterable-grid');
    }
  }

  handleSearch(query) {
    // Clear existing timeout
    if (this.searchTimeout) {
      clearTimeout(this.searchTimeout);
    }

    // Show loading state
    this.setLoadingState(true);

    // Debounce the search
    this.searchTimeout = setTimeout(() => {
      this.performSearch(query);
    }, this.searchDelay);
  }

  async performSearch(query) {
    try {
      // Get current post type and taxonomy from page
      const postType = this.getPostType();
      const taxonomy = this.getTaxonomy();
      const termId = this.getTermId();

      console.log('Performing search:', { query, postType, taxonomy, termId });

      // Build request data
      const formData = new FormData();
      formData.append('action', 'archive_filter_search');
      formData.append('nonce', window.sageData.nonce);
      formData.append('search', query);
      formData.append('post_type', postType);
      formData.append('paged', 1); // Reset to page 1 on search

      if (taxonomy && termId) {
        formData.append('taxonomy', taxonomy);
        formData.append('term_id', termId);
      }

      // Perform the AJAX request
      const response = await fetch(window.sageData.ajaxUrl, {
        method: 'POST',
        body: formData,
      });

      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const data = await response.json();
      console.log('Search response:', data);

      if (data.success) {
        this.updateGrid(data.data.html);
        this.updateUrl(query);
      } else {
        console.error('Search failed:', data.data);
        this.showError(data.data.message || 'Search failed. Please try again.');
      }
    } catch (error) {
      console.error('Search error:', error);
      this.showError('An error occurred. Please try again.');
    } finally {
      this.setLoadingState(false);
    }
  }

  updateGrid(html) {
    console.log('updateGrid called, postsGrid element:', this.postsGrid);
    console.log('HTML to insert:', html.substring(0, 200) + '...'); // Log first 200 chars

    if (this.postsGrid) {
      // Fade out
      this.postsGrid.style.opacity = '0.5';
      this.postsGrid.style.transition = 'opacity 150ms ease-in-out';

      // Update content after a brief delay for smooth transition
      setTimeout(() => {
        this.postsGrid.innerHTML = html;
        this.postsGrid.style.opacity = '1';
        console.log('Grid updated successfully');
      }, 150);
    } else {
      console.error('postsGrid element not found!');
    }
  }

  updateUrl(query) {
    // Update URL without page reload
    const url = new URL(window.location);

    if (query && query.trim() !== '') {
      url.searchParams.set('s', query);
    } else {
      url.searchParams.delete('s');
    }

    window.history.pushState({}, '', url);
  }

  setLoadingState(isLoading) {
    const searchIcon = document.querySelector('.search-icon');
    const searchLoading = document.querySelector('.search-loading');

    if (isLoading) {
      if (searchIcon) searchIcon.classList.add('hidden');
      if (searchLoading) searchLoading.classList.remove('hidden');
      if (this.searchInput) this.searchInput.classList.add('opacity-50');
    } else {
      if (searchIcon) searchIcon.classList.remove('hidden');
      if (searchLoading) searchLoading.classList.add('hidden');
      if (this.searchInput) this.searchInput.classList.remove('opacity-50');
    }
  }

  showError(message) {
    // You could implement a toast notification here
    console.error(message);
  }

  getPostType() {
    // Try to detect post type from body class
    const bodyClasses = document.body.className;

    if (bodyClasses.includes('post-type-archive-case') || bodyClasses.includes('tax-case_category')) {
      return 'case';
    }

    return 'post'; // Default to posts
  }

  getTaxonomy() {
    const bodyClasses = document.body.className;

    if (bodyClasses.includes('tax-case_category')) {
      return 'case_category';
    } else if (bodyClasses.includes('category')) {
      return 'category';
    }

    return null;
  }

  getTermId() {
    // Try to get term ID from body class
    const bodyClasses = document.body.className.split(' ');

    for (const className of bodyClasses) {
      if (className.startsWith('term-')) {
        return className.replace('term-', '');
      }
    }

    return null;
  }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new ArchiveFilters();
});

/**
 * Archive Filters JavaScript
 * Handles live search and filtering for archive pages with AJAX
 */

class ArchiveFilters {
  constructor() {
    this.searchInput = document.querySelector('[data-search-input]');
    this.categoryButtons = document.querySelectorAll('[data-filter-action="category"]');
    this.postsGrid = document.querySelector('.posts-grid, .cases-grid');
    this.searchTimeout = null;
    this.searchDelay = 500; // ms debounce delay

    // Filter state
    this.state = {
      search: '',
      categoryIds: [], // Array for multiple categories
      categorySlugs: [], // Array for multiple category slugs
      postType: this.getPostType(),
      taxonomy: this.getTaxonomy(),
      page: 1, // Current page for pagination
    };

    // Initialize from URL on page load
    this.initFromUrl();

    if (this.searchInput || this.categoryButtons.length > 0) {
      this.init();
    }
  }

  init() {
    // Search input listener
    if (this.searchInput) {
      this.searchInput.addEventListener('input', (e) => {
        this.handleSearchInput(e.target.value);
      });
    }

    // Category button listeners
    if (this.categoryButtons.length > 0) {
      this.categoryButtons.forEach(button => {
        button.addEventListener('click', (e) => {
          e.preventDefault();
          this.handleCategoryClick(e.currentTarget);
        });
      });
    }

    // Browser back/forward button support
    window.addEventListener('popstate', () => {
      this.initFromUrl();
      this.performFilter();
    });

    // Add grid class for filtering
    if (this.postsGrid) {
      this.postsGrid.classList.add('filterable-grid');
    }

    // Delegate pagination click events (since pagination is dynamically loaded)
    document.addEventListener('click', (e) => {
      // Check if clicked element or its parent is a pagination link
      const paginationLink = e.target.closest('nav[aria-label="Pagination"] a');
      if (paginationLink) {
        e.preventDefault();
        this.handlePaginationClick(paginationLink);
      }
    });
  }

  initFromUrl() {
    // Read filter state from URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    this.state.search = urlParams.get('s') || '';
    const categorySlugsParam = urlParams.get('category') || '';

    // Update search input if present
    if (this.searchInput && this.state.search) {
      this.searchInput.value = this.state.search;
    }

    // Parse multiple categories from comma-separated slugs
    if (categorySlugsParam) {
      const slugs = categorySlugsParam.split(',').filter(s => s.trim() !== '');

      slugs.forEach(slug => {
        const categoryButton = document.querySelector(`[data-category-slug="${slug.trim()}"]`);
        if (categoryButton) {
          const categoryId = categoryButton.dataset.categoryId || '';
          if (!this.state.categoryIds.includes(categoryId)) {
            this.state.categoryIds.push(categoryId);
            this.state.categorySlugs.push(slug.trim());
          }
        }
      });

      this.updateActiveCategoryButtons();
    }
  }

  handleSearchInput(query) {
    // Clear existing timeout
    if (this.searchTimeout) {
      clearTimeout(this.searchTimeout);
    }

    // Update state
    this.state.search = query;
    this.state.page = 1; // Reset to page 1 on search

    // Show loading state
    this.setLoadingState(true);

    // Debounce the search
    this.searchTimeout = setTimeout(() => {
      this.performFilter();
    }, this.searchDelay);
  }

  handleCategoryClick(button) {
    const categoryId = button.dataset.categoryId || '';
    const categorySlug = button.dataset.categorySlug || '';

    // If "All" button clicked, clear all selections
    if (categoryId === '' && categorySlug === '') {
      this.state.categoryIds = [];
      this.state.categorySlugs = [];
    } else {
      // Toggle category selection
      const idIndex = this.state.categoryIds.indexOf(categoryId);

      if (idIndex > -1) {
        // Remove category if already selected
        this.state.categoryIds.splice(idIndex, 1);
        this.state.categorySlugs.splice(idIndex, 1);
      } else {
        // Add category if not selected
        this.state.categoryIds.push(categoryId);
        this.state.categorySlugs.push(categorySlug);
      }
    }

    // Reset to page 1 when changing filters
    this.state.page = 1;

    // Update UI
    this.updateActiveCategoryButtons();

    // Show grid loading state (but keep buttons interactive for multi-select)
    this.setLoadingState(true, 'grid');

    // Perform filter
    this.performFilter();
  }

  handlePaginationClick(link) {
    // Extract page number from URL
    const url = new URL(link.href);
    const pageParam = url.searchParams.get('paged') || url.pathname.match(/\/page\/(\d+)/);
    const page = pageParam ? (Array.isArray(pageParam) ? parseInt(pageParam[1]) : parseInt(pageParam)) : 1;

    // Update state
    this.state.page = page;

    // Show loading state
    this.setLoadingState(true, 'grid');

    // Perform filter with new page
    this.performFilter();
  }

  updateActiveCategoryButtons() {
    // Remove active class from all buttons first
    this.categoryButtons.forEach(btn => {
      btn.classList.remove('badge-active');
      btn.classList.add('badge-outline');
    });

    // If no categories selected, activate "All" button
    if (this.state.categoryIds.length === 0) {
      const allButton = document.querySelector('[data-category-id=""]');
      if (allButton) {
        allButton.classList.add('badge-active');
        allButton.classList.remove('badge-outline');
      }
    } else {
      // Activate all selected category buttons
      this.state.categoryIds.forEach(categoryId => {
        const button = document.querySelector(`[data-category-id="${categoryId}"]`);
        if (button) {
          button.classList.add('badge-active');
          button.classList.remove('badge-outline');
        }
      });
    }
  }

  async performFilter() {
    try {
      console.log('Performing filter:', this.state);

      // Build request data
      const formData = new FormData();
      formData.append('action', 'archive_filter_search');
      formData.append('nonce', window.sageData.nonce);
      formData.append('search', this.state.search);
      formData.append('post_type', this.state.postType);
      formData.append('category_ids', JSON.stringify(this.state.categoryIds)); // Send as JSON array
      formData.append('paged', this.state.page); // Current page number

      // Add taxonomy info if available
      if (this.state.taxonomy) {
        formData.append('taxonomy', this.state.taxonomy);
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
      console.log('Filter response:', data);

      if (data.success) {
        this.updateGrid(data.data.html);
        this.updateUrl();
      } else {
        console.error('Filter failed:', data.data);
        this.showError(data.data.message || 'Filtering failed. Please try again.');
      }
    } catch (error) {
      console.error('Filter error:', error);
      this.showError('An error occurred. Please try again.');
    } finally {
      // Clear both search and grid loading states
      this.setLoadingState(false, 'search');
      this.setLoadingState(false, 'grid');
    }
  }

  updateGrid(html) {
    console.log('Updating grid with new content');

    if (this.postsGrid) {
      // Fade out
      this.postsGrid.style.opacity = '0.5';
      this.postsGrid.style.transition = 'opacity 150ms ease-in-out';

      // Update content after a brief delay for smooth transition
      setTimeout(() => {
        this.postsGrid.innerHTML = html;
        this.postsGrid.style.opacity = '1';
        console.log('Grid updated successfully');

        // Scroll to top of grid smoothly
        this.postsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 150);
    } else {
      console.error('Posts/Cases grid element not found!');
    }
  }

  updateUrl() {
    // Update URL without page reload
    const url = new URL(window.location);

    // Update search parameter
    if (this.state.search && this.state.search.trim() !== '') {
      url.searchParams.set('s', this.state.search);
    } else {
      url.searchParams.delete('s');
    }

    // Update category parameter (use comma-separated slugs for multiple categories)
    if (this.state.categorySlugs.length > 0) {
      url.searchParams.set('category', this.state.categorySlugs.join(','));
    } else {
      url.searchParams.delete('category');
    }

    // Push state to browser history
    window.history.pushState({}, '', url);
  }

  setLoadingState(isLoading, target = 'search') {
    // Search loading state
    if (target === 'search' || target === 'all') {
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

    // Grid loading state (for category and general filtering)
    if (target === 'grid' || target === 'all') {
      if (this.postsGrid) {
        if (isLoading) {
          this.postsGrid.classList.add('filtering');
        } else {
          this.postsGrid.classList.remove('filtering');
        }
      }
    }
  }

  showError(message) {
    // Simple error display - you can enhance this with a toast notification
    console.error(message);

    // You could create a toast element here
    // For now, just log to console
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
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new ArchiveFilters();
});

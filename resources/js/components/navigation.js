/**
 * Navigation functionality for dropdown menus and mobile menu
 * Place this file in resources/js/navigation.js
 */

class Navigation {
  constructor() {
    this.dropdownTimeouts = {};
    this.openDropdown = null;
    this.mobileMenu = null;
    this.mobileMenuButton = null;
    this.mobileMenuClose = null;

    this.init();
  }

  init() {
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.setup());
    } else {
      this.setup();
    }
  }

  setup() {
    this.initializeMobileMenu();
    this.setupDropdownHovers();
    this.bindEvents();
  }

  initializeMobileMenu() {
    this.mobileMenuButton = document.getElementById('mobile-menu-button');
    this.mobileMenuClose = document.getElementById('mobile-menu-close');
    this.mobileMenu = document.getElementById('mobile-menu');

    if (this.mobileMenuButton) {
      this.mobileMenuButton.addEventListener('click', () =>
        this.toggleMobileMenu()
      );
    }

    if (this.mobileMenuClose) {
      this.mobileMenuClose.addEventListener('click', () =>
        this.toggleMobileMenu()
      );
    }
  }

  toggleMobileMenu() {
    if (!this.mobileMenu) return;

    this.mobileMenu.classList.toggle('hidden');
    const isOpen = !this.mobileMenu.classList.contains('hidden');
    this.mobileMenuButton.setAttribute('aria-expanded', isOpen);
  }

  showDropdown(dropdownId) {
    // Clear any pending hide timeout for this dropdown
    if (this.dropdownTimeouts[dropdownId]) {
      clearTimeout(this.dropdownTimeouts[dropdownId]);
      delete this.dropdownTimeouts[dropdownId];
    }

    // Hide any other open dropdown
    if (this.openDropdown && this.openDropdown !== dropdownId) {
      const otherDropdown = document.getElementById(this.openDropdown);
      if (otherDropdown) {
        otherDropdown.classList.add('hidden');
      }
    }

    const dropdown = document.getElementById(dropdownId);
    if (dropdown) {
      dropdown.classList.remove('hidden');
      this.openDropdown = dropdownId;
    }
  }

  hideDropdown(dropdownId) {
    this.dropdownTimeouts[dropdownId] = setTimeout(() => {
      const dropdown = document.getElementById(dropdownId);
      if (dropdown) {
        dropdown.classList.add('hidden');
        if (this.openDropdown === dropdownId) {
          this.openDropdown = null;
        }
      }
      delete this.dropdownTimeouts[dropdownId];
    }, 300);
  }

  toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    if (!dropdown) return;

    if (dropdown.classList.contains('hidden')) {
      this.showDropdown(dropdownId);
    } else {
      this.hideDropdown(dropdownId);
    }
  }

  toggleMobileAccordion(accordionId) {
    const accordion = document.getElementById(accordionId);
    const icon = document.getElementById(accordionId + '-icon');

    if (accordion && icon) {
      const isHidden = accordion.classList.contains('hidden');
      accordion.classList.toggle('hidden');
      icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }
  }

  setupDropdownHovers() {
    const dropdownContainers = document.querySelectorAll('nav .relative');

    dropdownContainers.forEach((container) => {
      const button = container.querySelector('button[data-dropdown]');
      const dropdown = container.querySelector('.dropdown-menu');

      if (button && dropdown) {
        const dropdownId = dropdown.id;

        // Mouse enter on container
        container.addEventListener('mouseenter', () => {
          this.showDropdown(dropdownId);
        });

        // Mouse leave on container
        container.addEventListener('mouseleave', () => {
          this.hideDropdown(dropdownId);
        });

        // Keep dropdown open when hovering over it
        dropdown.addEventListener('mouseenter', () => {
          if (this.dropdownTimeouts[dropdownId]) {
            clearTimeout(this.dropdownTimeouts[dropdownId]);
            delete this.dropdownTimeouts[dropdownId];
          }
        });

        dropdown.addEventListener('mouseleave', () => {
          this.hideDropdown(dropdownId);
        });

        // Click to toggle (for touch devices)
        button.addEventListener('click', (e) => {
          e.preventDefault();
          this.toggleDropdown(dropdownId);
        });
      }
    });
  }

  closeAllDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach((dropdown) => {
      dropdown.classList.add('hidden');
    });
    this.openDropdown = null;

    // Clear all timeouts
    Object.keys(this.dropdownTimeouts).forEach((key) => {
      clearTimeout(this.dropdownTimeouts[key]);
      delete this.dropdownTimeouts[key];
    });
  }

  bindEvents() {
    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
      if (!event.target.closest('nav .relative')) {
        this.closeAllDropdowns();
      }

      // Close mobile menu when clicking outside
      if (this.mobileMenu && !this.mobileMenu.classList.contains('hidden')) {
        if (
          !this.mobileMenu.contains(event.target) &&
          !this.mobileMenuButton.contains(event.target)
        ) {
          this.mobileMenu.classList.add('hidden');
          this.mobileMenuButton.setAttribute('aria-expanded', 'false');
        }
      }
    });

    // Close on escape key
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        this.closeAllDropdowns();

        // Close mobile menu
        if (this.mobileMenu && !this.mobileMenu.classList.contains('hidden')) {
          this.mobileMenu.classList.add('hidden');
          this.mobileMenuButton.setAttribute('aria-expanded', 'false');
        }
      }
    });
  }
}

// Make functions available globally for inline handlers (if needed)
let navigationInstance;

document.addEventListener('DOMContentLoaded', () => {
  navigationInstance = new Navigation();

  // Expose methods globally for backward compatibility
  window.showDropdown = (dropdownId) =>
    navigationInstance.showDropdown(dropdownId);
  window.hideDropdown = (dropdownId) =>
    navigationInstance.hideDropdown(dropdownId);
  window.toggleDropdown = (dropdownId) =>
    navigationInstance.toggleDropdown(dropdownId);
  window.toggleMobileAccordion = (accordionId) =>
    navigationInstance.toggleMobileAccordion(accordionId);
});

// Export for module usage
export default Navigation;

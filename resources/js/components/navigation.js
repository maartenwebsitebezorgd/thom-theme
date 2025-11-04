/**
 * Navigation functionality for dropdown menus using Popover API
 */

class Navigation {
  constructor() {
    this.dropdownTimeouts = {};
    this.hoverDelay = 150; // ms delay before opening/closing

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
    this.setupDropdownHovers();
    this.bindEvents();
  }

  showPopover(popoverId) {
    // Clear any pending hide timeout for this popover
    if (this.dropdownTimeouts[popoverId]) {
      clearTimeout(this.dropdownTimeouts[popoverId]);
      delete this.dropdownTimeouts[popoverId];
    }

    const popover = document.getElementById(popoverId);
    if (popover && !popover.matches(':popover-open')) {
      popover.showPopover();
    }
  }

  hidePopover(popoverId, immediate = false) {
    const delay = immediate ? 0 : this.hoverDelay;

    // Clear any existing timeout
    if (this.dropdownTimeouts[popoverId]) {
      clearTimeout(this.dropdownTimeouts[popoverId]);
    }

    this.dropdownTimeouts[popoverId] = setTimeout(() => {
      const popover = document.getElementById(popoverId);
      if (popover && popover.matches(':popover-open')) {
        popover.hidePopover();
      }
      delete this.dropdownTimeouts[popoverId];
    }, delay);
  }

  setupDropdownHovers() {
    // Find all dropdown trigger containers
    const dropdownTriggers = document.querySelectorAll('[data-dropdown-trigger]');

    dropdownTriggers.forEach((trigger) => {
      const popoverId = trigger.getAttribute('data-dropdown-trigger');
      const button = trigger.querySelector(`[data-popover-button="${popoverId}"]`);
      const popover = document.getElementById(popoverId);

      if (!button || !popover) return;

      // Prevent default click behavior to avoid conflicts
      button.addEventListener('click', (e) => {
        e.preventDefault();
      });

      // Mouse enter on trigger container
      trigger.addEventListener('mouseenter', () => {
        this.showPopover(popoverId);
      });

      // Mouse leave on trigger container
      trigger.addEventListener('mouseleave', () => {
        this.hidePopover(popoverId);
      });

      // Keep popover open when hovering over it
      popover.addEventListener('mouseenter', () => {
        if (this.dropdownTimeouts[popoverId]) {
          clearTimeout(this.dropdownTimeouts[popoverId]);
          delete this.dropdownTimeouts[popoverId];
        }
      });

      // Close popover when mouse leaves it
      popover.addEventListener('mouseleave', () => {
        this.hidePopover(popoverId);
      });
    });
  }

  closeAllPopovers() {
    // Clear all timeouts
    Object.keys(this.dropdownTimeouts).forEach((key) => {
      clearTimeout(this.dropdownTimeouts[key]);
      delete this.dropdownTimeouts[key];
    });

    // Close all open popovers
    const openPopovers = document.querySelectorAll('[popover]:popover-open');
    openPopovers.forEach((popover) => {
      if (popover.id.startsWith('desktop-menu-')) {
        popover.hidePopover();
      }
    });
  }

  bindEvents() {
    // Close dropdowns on escape key
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        this.closeAllPopovers();
      }
    });

    // Optional: Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
      const isInsideDropdown = event.target.closest('[data-dropdown-trigger]') ||
                               event.target.closest('[popover]');

      if (!isInsideDropdown) {
        this.closeAllPopovers();
      }
    });
  }
}

// Initialize navigation
let navigationInstance;

document.addEventListener('DOMContentLoaded', () => {
  navigationInstance = new Navigation();
});

// Export for module usage
export default Navigation;

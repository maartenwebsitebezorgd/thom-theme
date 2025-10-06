import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Initialize all Swiper instances
document.addEventListener('DOMContentLoaded', () => {
  const swiperElements = document.querySelectorAll('[data-swiper-config]');

  swiperElements.forEach((element) => {
    try {
      const config = JSON.parse(element.getAttribute('data-swiper-config'));

      // Add modules
      config.modules = [Navigation, Pagination, Autoplay];

      // Initialize Swiper
      new Swiper(element, config);
    } catch (error) {
      console.error('Failed to initialize Swiper:', error);
    }
  });
});

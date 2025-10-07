import.meta.glob(['../images/**', '../fonts/**']);

// Import navigation functionality
import './components/navigation.js';
import './components/swiper.js';
import './components/logo-slider.js';
import articlesGridTeamCard from './components/articles-grid-team-card.js';

// Initialize articles grid team card functionality
document.addEventListener('DOMContentLoaded', () => {
  articlesGridTeamCard();
});

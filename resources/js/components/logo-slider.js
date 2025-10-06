// Logo Slider - Set scroll speed dynamically and ensure seamless loop
document.addEventListener('DOMContentLoaded', () => {
  const logoSliders = document.querySelectorAll('.logo-slider-wrapper');

  logoSliders.forEach((slider) => {
    const scrollSpeed = slider.getAttribute('data-scroll-speed') || 30;
    const track = slider.querySelector('.logo-slider-track');

    if (track) {
      // Set CSS variable for animation duration
      track.style.setProperty('--scroll-duration', `${scrollSpeed}s`);

      // Add animate class after a small delay to ensure proper rendering
      requestAnimationFrame(() => {
        track.classList.add('animate');
      });
    }
  });
});

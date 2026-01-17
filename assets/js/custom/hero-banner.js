/**
 * Hero Banner Animations
 */

document.addEventListener('DOMContentLoaded', () => {
  initHeroBanners();
});

function initHeroBanners() {
  const heroBanners = document.querySelectorAll('.hero-banner-header');
  
  if (!heroBanners.length) return;

  heroBanners.forEach((header) => {
    animateHeroHeader(header);
  });
}

function animateHeroHeader(header) {
  console.log('Animating header:', header); 
  
  gsap.from(header, {
    scrollTrigger: {
      trigger: header,
      start: 'top 80%',
      toggleActions: 'play none none reverse',
      markers: true, 
    },
    duration: 1,
    y: 50,
    opacity: 0,
    ease: 'power3.out'
  });
}

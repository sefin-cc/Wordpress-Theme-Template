  
document.addEventListener('DOMContentLoaded', () => { 
    if (!window.gsap) {
        console.warn('GSAP not loaded');
        return;
    }

    // Register ScrollTrigger if available
    if (window.ScrollTrigger) {
        gsap.registerPlugin(ScrollTrigger);
    }
});
console.log('Theme scripts loaded');


import './custom/hero-banner.js';


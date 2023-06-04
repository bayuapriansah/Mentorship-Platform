// Import Swiper and styles
import Swiper, { Navigation } from 'swiper';
import 'swiper/swiper-bundle.css';

// Install modules
Swiper.use([Navigation]);

// Initialize Swiper
document.addEventListener("DOMContentLoaded", function() {
    const swiper = new Swiper('.swiper-container', {
        // Default parameters
        slidesPerView: 1,
        spaceBetween: 30, // You can adjust this value to create space between slides
        navigation: {
            nextEl: '#swiper-button-next',
            prevEl: '#swiper-button-prev',
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
              slidesPerView: 1,
              spaceBetween: 10
            },
            // when window width is >= 480px
            480: {
              slidesPerView: 2,
              spaceBetween: 20
            },
            // when window width is >= 640px
            640: {
              slidesPerView: 3,
              spaceBetween: 30
            }
        }
    });
});

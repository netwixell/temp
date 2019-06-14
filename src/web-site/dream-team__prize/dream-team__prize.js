// IMPORTANT! Import only from dist because of an issue with the UglifyJS: https://github.com/nolimits4web/Swiper/issues/2263
import Swiper from 'swiper/dist/js/swiper.js';

new Swiper('.prize__swiper-container', {
  speed: 1000,
  centeredSlides: true,
  slidesPerView: 'auto',
  effect: 'coverflow',
  grabCursor: true,
  coverflowEffect: {
    rotate: 0,
    stretch: 90
  },
  roundLengths: true, // чуть помогает с размытым текстом на Винде
  navigation: {
    nextEl: '.prize__button--next',
    prevEl: '.prize__button--prev',
  },
  breakpoints: {
    767: {
      speed: 250,
      spaceBetween: 25,
      effect: 'slide'
    }
  }
});

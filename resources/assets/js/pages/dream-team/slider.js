var index__slider = new Swiper('.prize__swiper-container', {
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

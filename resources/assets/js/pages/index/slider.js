var index__slider = new Swiper('.tickets__swiper-container', {
  speed: 1000,
  centeredSlides: true,
  slidesPerView: 'auto',
  initialSlide: 2,
  effect: 'coverflow',
  coverflowEffect: {
    rotate: 0,
    stretch: 90
  },
  roundLengths: true, // чуть помогает с размытым текстом на Винде
  slideToClickedSlide: true,
  navigation: {
    nextEl: '.tickets__button--next',
    prevEl: '.tickets__button--prev',
  },
  breakpoints: {
    767: {
      speed: 250,
      spaceBetween: 25,
      initialSlide: 0,
      effect: 'slide'
    }
  }
});

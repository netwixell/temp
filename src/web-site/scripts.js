import "@babel/polyfill";

import * as helpers from '../common/js/helpers';

import 'lazysizes/plugins/unveilhooks/ls.unveilhooks';
import 'lazysizes';

import * as Photoswipe from 'photoswipe';
import * as PhotoswipeUI_Default from 'photoswipe/dist/photoswipe-ui-default';

import SmoothScroll from 'smooth-scroll';
import AOS from 'aos';

import './header/header';
import './alert/alert';
import './button-load-all/button-load-all';
import './button-menu/button-menu';
import './form-molfar/form-molfar';

import autosize from 'autosize';
import './hero/hero';

// Глобальное подключение функций из helpers.js
window.helpers = helpers;

setTimeout(function(){

  new SmoothScroll('a[href*="#"]', {
    ignore: '[data-scroll-ignore]',
    offset: 60
  });


},500);

document.addEventListener('lazyloaded', function (e) {
  e.target.parentNode.classList.add('image-loaded');
  e.target.parentNode.classList.remove('loading');
});

AOS.init({
  // Global settings
  disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
  startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
  initClassName: 'aos-init', // class applied after initialization
  animatedClassName: 'aos-animate', // class applied on animation
  useClassNames: false, // if true, will add content of `data-aos` as classes on scroll

  // Settings that can be overriden on per-element basis, by `data-aos-*` attributes:
  offset: 120, // offset (in px) from the original trigger point
  delay: 0, // values from 0 to 3000, with step 50ms
  duration: 400, // values from 0 to 3000, with step 50ms
  easing: 'ease-out', // default easing for AOS animations
  once: false, // whether animation should happen only once - while scrolling down
  mirror: false, // whether elements should animate out while scrolling past them
  anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
});

autosize(document.getElementById('textarea'));

window.Photoswipe = Photoswipe;
window.PhotoswipeUI_Default = PhotoswipeUI_Default;

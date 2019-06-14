(function (btn) {
  if (!btn) { return; }

  var cls_active = 'to-top--active',
    cls_header = '.header';

  var scroll = new SmoothScroll();

  var header_height = document.querySelector(cls_header).offsetHeight,
    window_height = window.innerHeight;

  var options = {
    header: cls_header,
    offset: header_height,
    speed: 500,
    // easing: 'easeOutCubic'
  };

  var scrollFunction = function () {

    var prev_scroll_top = 0,
      lift_up = 0,
      lift_down = 0,
      step = 10;

    return function () {

      var curr_scroll_top = document.body.scrollTop || document.documentElement.scrollTop,
        diff_scroll_top = prev_scroll_top - curr_scroll_top;

      if (lift_up > step && curr_scroll_top > window_height) {

        btn.classList.add(cls_active);

      }
      else if (lift_down > step || curr_scroll_top < window_height) {

        btn.classList.remove(cls_active);

      }

      if (diff_scroll_top > 0) {
        lift_up++;
        lift_down = 0;
      }
      else {
        lift_down++;
        lift_up = 0;
      }


      prev_scroll_top = curr_scroll_top;

    };

  }();

  window.addEventListener('scroll', scrollFunction);


  btn.addEventListener('click', function () {
    scroll.animateScroll(0, null, options);
  });

  // убирает мигание при загрузке
  setTimeout(function(){

    btn.style = 'visibility:visible';

  }, 250);


})(document.querySelector('.to-top'));

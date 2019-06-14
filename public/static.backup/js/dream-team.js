(function (form) {
    if (!form) {
      return;
    }

  var r_name = /^\D{3,}$/;
  var r_except_nums = /\D/g;

  var inp_phone = form.elements.phone;

  if (inp_phone) {
    mask = new IMask(inp_phone, phoneMask);
  }

  var validation = new Validation(form, {
    parent_selector: '.form__line',
    cls_warning: 'form__line--warning',
    cls_danger: 'form__line--danger',
    cls_hint: 'form__line--hint',
    cls_mistake: 'form__mistake'
  });


  function sendData(form, onDone, onFail) {
    var XHR = new XMLHttpRequest();

    var btn_submit = form.querySelector('[type="submit"]');

    btn_submit.disabled = true;

    // Bind the FormData object and the form element
    var FD = new FormData(form);

    // Define what happens on successful data submission
    XHR.addEventListener("load", function (event) {

      btn_submit.disabled = false;

      var data = JSON.parse(XHR.responseText);
      if (XHR.readyState == 4 && XHR.status == "200") {
        onDone(form, data);
      } else {
        if (onFail) {
          onFail(form, data);
        }
      }

    });

    // Define what happens in case of error
    XHR.addEventListener("error", function (event) {
      if (onFail) {
        onFail(form);
      }
    });

    // Set up our request
    XHR.open("POST", form.action, true);

    //Send the proper header information along with the request
    // XHR.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    XHR.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    // The data sent is what the user provided in the form
    XHR.send(FD);
  }

  function onDone(form, result) {

    if (result['alert-type'] && result['alert-type'] == 'success') {
      form.classList.add('form--success');
      form.reset();
      setTimeout(function(){
        form.classList.remove('form--success');
      },3000);
    }

  }

  function onFail(form, result) {

    var reset = function () {
      this.setCustomValidity('');
      this.removeEventListener('input', reset);
    };

    if (result) {
      var errors = result.errors;
      if (errors) {

        for (var field in errors) {
          if (errors.hasOwnProperty(field)) {
            validation.flash(field, errors[field].pop());
          }
        }

      }
    }

  }

  // ...and take over its submit event.
  form.addEventListener("submit", function (event) {
    event.preventDefault();

      var form = this;

      var formated_phone;

      if (inp_phone) {
        formated_phone = inp_phone.value;

        // inp_phone.value = formated_phone.replace(r_except_nums, '');
        inp_phone.value = mask.unmaskedValue;

      }

      sendData(form, onDone, onFail);

      inp_phone.value = formated_phone;


    return false;
  });


})(document.forms.registration);

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

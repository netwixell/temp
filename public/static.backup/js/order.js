(function(form){
  if (!form) {
    return;
  }

  var r_except_nums = /\D/g;
  var is_enabled = true;
  var cls_step_active = 'steps__step--active',
    cls_step_current = 'steps__step--current';

  var inp_phone = form.elements.phone;

  if (inp_phone) {
    mask = new IMask(inp_phone, phoneMask);
  }

   function nextStep() {
     var current_step, next_step;

     current_step = document.querySelector('.' + cls_step_current);
     current_step.classList.remove(cls_step_current);
     current_step.classList.add(cls_step_active);

     next_step = current_step.nextElementSibling;
     next_step.classList.add(cls_step_current);
   }

   function validationPassed(){

    var is_primarily = true;

    return function () {
      if (is_primarily) {
        nextStep();
        is_primarily = false;
      }
    };

   }


  var validation = new Validation(form, {
    parent_selector: '.form__line',
    cls_warning: 'form__line--warning',
    cls_danger: 'form__line--danger',
    cls_hint: 'form__line--hint',
    cls_mistake: 'form__mistake',
    requiredPassed: validationPassed()
  });



  //init: bind event oninput to inputs
  (function(){
    var elements=form.elements, count=elements.length, x=0;
    var is_primarily=true;

    function onInput(){
      var is_valid = form.checkValidity(),
        active_steps, active_step;

      if(is_valid && is_primarily){
        nextStep();
        is_primarily=false;
      }

    }
    // for(;x<count; x++){
    //   form.elements[x].addEventListener("input", onInput);
    // }

  })();


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
        onDone(form,data);
      } else {
        if (onFail) {
          onFail(form,data);
        }
      }

    });

    // Define what happens in case of error
    XHR.addEventListener("error", function (event) {
      if(onFail){
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

  function onDone(form,result){
    if (result['alert-type'] && result['alert-type'] == 'success') {

      nextStep();

      window.location.hash = '#success';
      // window.scrollTo(0, 0);

      var scroll = new SmoothScroll();
      scroll.animateScroll(0);
    }

  }
  function onFail(form,result){

    var reset=function(){
      this.setCustomValidity('');
      this.removeEventListener('input', reset);
    };

    if (result) {
      var errors = result.errors;
      if (errors) {

        for(var field in errors){
          if(errors.hasOwnProperty(field)){
            validation.flash(field, errors[field].pop());
          }
        }

        // if("phone" in errors){
        //   validation.flash('phone', errors.phone.pop());
        // }

      }
    }
    is_enabled = true;

  }

  // ...and take over its submit event.
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    if(is_enabled){

      var form=this;

      var input_phone = form.elements.phone,
        formated_phone;

      if (input_phone) {
        formated_phone = input_phone.value;
        // input_phone.value = formated_phone.replace(r_except_nums, '');
        inp_phone.value = mask.unmaskedValue;

      }

      is_enabled=false;

      sendData(form,onDone,onFail);

      input_phone.value = formated_phone;
    }


    return false;
  });


})(document.forms.order);

tabby.init();

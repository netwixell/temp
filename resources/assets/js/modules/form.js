phoneMask = {
  mask: '+{38\\0} (00) 000 00 00'
};

var Validation = (function () {

  var input_types = ['text', 'tel', 'email'];


  function Validation(form, options) {

    this.form = form;
    this.options = options;

    this.messages = {};
    this.rules = {};

    this.count = {
      required: 0,
      total:0,
    };

    this.validatedCount = {
      required: 0,
      total:0,
    };

    this.validated_inputs = [];

    this.init();

  }

  Validation.prototype.defaults = {

    parent_selector: '*',
    cls_warning: '',
    cls_danger: '',
    cls_hint: '',
    cls_mistake: '',
    requiredPassed: null
  };

  Validation.prototype.init = function () {
    var options = this.options;

    this.options = Object.assign({}, this.defaults, options);

    this.handleInputs();

  };

  function onInvalid(validation) {

    return function (e) {

      e.preventDefault();

      validation.onInvalid(this);
    };
  }

  function onInput(validation) {

    return function (e) {

      e.preventDefault();

      validation.onInput(this);
    };
  }

  function findNextSibling(elem, filter) {

    while (elem = elem.nextSibling) {
      if (elem.nodeType === 3) continue; // text node
      if (!filter || filter(elem)) return elem;
    }

    return false;

  }

  Validation.prototype.onInvalid = function (elem) {
    var cls_mistake = this.options.cls_mistake,
      parent = elem.closest(this.options.parent_selector);

    parent.classList.add(this.options.cls_danger);

    if (!findNextSibling(elem, function (sibling) {
        return sibling.classList.contains(cls_mistake);
      })) {

      elem.insertAdjacentHTML('afterend', '<span class="' + cls_mistake + '">' + this.messages[elem.name] + '</span>');
      // elem.insertAdjacentHTML('afterend', '<span class="'+cls_mistake+'">' + elem.dataset.invalidMsg + '</span>');

    }

    this.inputInvalid(elem);


  };

  Validation.prototype.setMessage = function (field, message) {
    this.messages[field] = message;
  };
  Validation.prototype.setRule = function (field, rule) {
    this.rules[field] = rule;
  };


  Validation.prototype.inputInvalid = function (input) {
    var name = input.name,
      index;
    index = this.validated_inputs.indexOf(name);

    if (index > -1) {
      //remove input from validated list
      this.validated_inputs.splice(index, 1);

      if(input.required){
        this.validatedCount.required--;
      }

      this.validatedCount.total--;
    }
  };


  Validation.prototype.inputPassed = function (input) {
    var field = input.name;

    if (!this.validated_inputs.includes(field)) {

      this.validated_inputs.push(field);

      this.validatedCount.total++;

      if(input.required){
        this.validatedCount.required++;
      }

      if (this.validatedCount.required == this.count.required) {
        if (this.options.requiredPassed) {
          this.options.requiredPassed();
        }
      }

    }

  };

  Validation.prototype.checkRule = function(input){
    var field = input.name;

    if(field in this.rules){

      if(this.rules[field](input)){
        input.setCustomValidity('');
        return true;
      }

    }
    return false;

  };

  Validation.prototype.onInput = function (input) {

    var cls_mistake = this.options.cls_mistake,
      parent = input.closest(this.options.parent_selector);

    if (input.validity.valid || this.checkRule(input)) {

      findNextSibling(input, function (sibling) {

        if (sibling.classList.contains(cls_mistake)) {
          sibling.parentNode.removeChild(sibling);
          return true;
        }

      });

      parent.classList.remove(this.options.cls_warning, this.options.cls_danger);

      this.inputPassed(input);

    }
  };

  Validation.prototype.custom = function(field, message, rule){

    var input = this.form.elements[field];

      input.setCustomValidity(message);

      this.setMessage(field, message);
      this.setRule(field, rule);

  };

  Validation.prototype.flash = function (field, message) {

    this.custom(field, message, function () {
      return true;
    });

    this.form.checkValidity();
  };


  Validation.prototype.handleInputs = function () {
    var form = this.form,
      elements = form.elements,
      i = 0,
      len = elements.length,
      element;

    for (; i < len; i++) {
      element = elements[i];

      if ("TEXTAREA" === element.nodeName || ("INPUT" === element.nodeName && input_types.includes(element.type)) ) {

        if(element.required){
          this.count.required++;
        }

        this.count.total++;

        this.messages[element.name] = element.dataset.invalidMsg || element.validationMessage;

        element.addEventListener('invalid', onInvalid(this), true);
        element.addEventListener('input', onInput(this), true);

      }
    }

  };

  //Polyfils
  if (!Element.prototype.matches)
    Element.prototype.matches = Element.prototype.msMatchesSelector ||
    Element.prototype.webkitMatchesSelector;

  if (!Element.prototype.closest)
    Element.prototype.closest = function (s) {
      var el = this;
      if (!document.documentElement.contains(el)) return null;
      do {
        if (el.matches(s)) return el;
        el = el.parentElement || el.parentNode;
      } while (el !== null && el.nodeType === 1);
      return null;
    };
  if (typeof Object.assign != 'function') {
    // Must be writable: true, enumerable: false, configurable: true
    Object.defineProperty(Object, "assign", {
      value: function assign(target, varArgs) { // .length of function is 2
        'use strict';
        if (target == null) { // TypeError if undefined or null
          throw new TypeError('Cannot convert undefined or null to object');
        }

        var to = Object(target);

        for (var index = 1; index < arguments.length; index++) {
          var nextSource = arguments[index];

          if (nextSource != null) { // Skip over if undefined or null
            for (var nextKey in nextSource) {
              // Avoid bugs when hasOwnProperty is shadowed
              if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                to[nextKey] = nextSource[nextKey];
              }
            }
          }
        }
        return to;
      },
      writable: true,
      configurable: true
    });
  }



  return Validation;

})();


(function (form) {
    if (!form) {
      return;
    }

  var r_name = /^\D{3,}$/;
  var r_except_nums = /\D/g;

  var mask;

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


      var data = JSON.parse(XHR.responseText);

      btn_submit.disabled = false;

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

        // if ("phone" in errors) {

        //   validation.flash('phone', errors.phone.pop());

        // }

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


})(document.forms.callback);


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


export default Validation;

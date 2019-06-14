const DEFAULTS = {

  selectorParent: 'form',

  classWarning: 'warning',
  classDanger: 'danger',
  classHint: 'hint',


  classMessage: 'js-input-message',
  tagMessage: 'span',

  inputTypes: 'text,tel,email,password',

  messages: {
    valueMissing: null, // Boolean indicating the element has a required attribute, but no value.

    typeMismatch: null, // Boolean indicating the value is not in the required syntax (when type is email or url)

    tooLong: null, // Boolean indicating the value exceeds the specified maxlength attribute for HTMLInputElement or HTMLTextAreaElement objects. Note: This will never be true in Gecko, because elements' values are prevented from being longer than max attribute.
    tooShort: null, // Boolean indicating the value fails to meet the specified minlength attribute for HTMLInputElement or HTMLTextAreaElement objects.

    patternMismatch: null, // Boolean indicating the value does not match the regex pattern specified in the pattern attribute.

    rangeOverflow: null, // Boolean indicating the value is greater than the maximum specified by the max attribute.
    rangeUnderflow: null, // Boolean indicating the value is less than the minimum specified by the min attribute.

    stepMismatch: null, // Boolean indicating the value does not fit the rules determined by the step attribute (that is, it's not evenly divisible by the step value).

    badInput: null, // Boolean indicating the user has provided input that the browser is unable to convert.

  }

};

function findNextSibling(elem, filter) {

  while (elem = elem.nextSibling) {
    if (elem.nodeType === 3) continue; // text node
    if (!filter || filter(elem)) return elem;
  }

  return false;

}


export default class Validation{

  constructor(form, options){

    this.form = form;
    this.options = Object.assign({}, DEFAULTS, options);


    this.rules = {};
    this.invalidRules = {};

    this.count = {
      required: 0,
      total:0,
    };

    this.validatedCount = {
      required: 0,
      total:0,
    };

    this.validatedInputs = [];

    this._events = {};

    this.init();

  }

  static onInvalid(validation) {

    return function (e) {

      e.preventDefault();

      validation.onInvalid(this);
    };
  }

  static onInput(validation) {

    return function (e) {

      e.preventDefault();

      validation.onInput(this);
    };
  }

  init() {

    this.handlerInputs();

    this.handlerForm();

  }

  handlerForm(){

    this.form.addEventListener('submit', e => {
      e.preventDefault();

      let resultValidity = this.form.checkValidity(),
        resultRules = this.checkFormRules();

      if(resultValidity && resultRules){

        this.trigger('passed');
        this.form.dispatchEvent(new Event('fetch'));

        let buttonSubmit = this.form.querySelector('[type=submit]');

        if(buttonSubmit) buttonSubmit.disabled = true;

      }

      return false;

    });

    this.form.addEventListener('unlock', e => {

      let buttonSubmit = this.form.querySelector('[type=submit]');

      if(buttonSubmit) buttonSubmit.disabled = false;

    });

  }

  handlerInputs() {
    let form = this.form,
      elements = form.elements,
      i = 0,
      len = elements.length,
      element,
      method = this.constructor,
      inputTypes = this.options.inputTypes.split(',');

    for (; i < len; i++) {
      element = elements[i];

      if ("TEXTAREA" === element.nodeName || ("INPUT" === element.nodeName && inputTypes.includes(element.type)) ) {

        if(element.required){
          this.count.required++;
        }

        this.count.total++;



        element.addEventListener('invalid', method.onInvalid(this), true);
        element.addEventListener('input', method.onInput(this), true);

      }
    }

  }

  onInvalid(input) {
    let field = input.name,
      message = this.retrieveInvalidMessage(input),
      validationMessage = input.validationMessage;

    if(this.invalidRules[field]) return;

    this.changeInvalidRule(input, () => {

      if(validationMessage != input.validationMessage){
        message = this.retrieveInvalidMessage(input);
        validationMessage = input.validationMessage;
      }

      return (input.validity.valid) ? '' : (message || validationMessage);

    }, message);

  }

  retrieveInvalidMessage(input){
    let messages = this.options.messages;

    for(let type in messages){
      if(input.validity[type]) return messages[type];
    }

    return null;

  }

  onInput(input) {

    let field = input.name,
      invalidRule = this.invalidRules[field],
      message = '';

    if(!invalidRule) return;

    if('' !== (message = invalidRule(input, this.form))){
      return this.changeMessage(input, message);
    }

    let fieldRules = this.rules[field], rule;

    if(fieldRules && fieldRules.length){

      for(let i=0, len=fieldRules.length; i<len; i++){
        rule = fieldRules[i];

        message = rule(input, this.form);

        if('' !== message){

          this.changeInvalidRule(input, rule, message);

          break;

        }
      }

    }

    input.setCustomValidity(message);

    if('' === message){

      this.invalidRules[field] = null;

      this.removeMessage(input);

      this.inputPassed(input);

    }


  }


  showMessage(input, message=''){
    let parent = input.closest(this.options.selectorParent);

    parent.classList.add(this.options.classDanger);

    parent.insertAdjacentHTML('afterend', this.renderMessage(message));
  }

  changeMessage(input, message=''){

    this.removeMessage(input);

    this.showMessage(input, message);

  }

  removeMessage(input){

    var parent = input.closest(this.options.selectorParent);

    findNextSibling(parent, sibling => {

      if (sibling.classList.contains(this.options.classMessage)) {
        sibling.parentNode.removeChild(sibling);
        return true;
      }

    });

    parent.classList.remove(this.options.classWarning, this.options.classDanger);

  }


  addRule(field, rule) {

    if(!this.rules[field]) this.rules[field] = [];

    this.rules[field].push(rule);

    let input = this.form.elements[field];

    if(!input.willValidate && !this.invalidRules[field]){
        input.setCustomValidity(rule(input, this.form));
    }

    return this;

  }

  removeRule(field, rule) {

    let fieldRules = this.rules[field];

    if(fieldRules && fieldRules.length){

      this.rules[field] = fieldRules.filter(fn => fn !== rule);

    }

  }


  inputInvalid(input) {
    var name = input.name,
      index;
    index = this.validatedInputs.indexOf(name);

    if (index > -1) {
      //remove input from validated list
      this.validatedInputs.splice(index, 1);

      if(input.required){
        this.validatedCount.required--;
      }

      this.validatedCount.total--;
    }
  }


  inputPassed(input) {
    var field = input.name;

    if (!this.validatedInputs.includes(field)) {

      this.validatedInputs.push(field);

      this.validatedCount.total++;

      if(input.required){
        this.validatedCount.required++;
      }

      if (this.validatedCount.required == this.count.required) {
          this.trigger('allRequiredValid');
      }

    }

  }

  checkFormRules(){

    let form = this.form,
      rules = this.rules,
      rule,
      fieldRules,
      message,
      input,
      isValid = true;


    for(let field in rules){
      if(!rules.hasOwnProperty(field)) continue;

      fieldRules = rules[field];

      if(this.invalidRules[field]) {
        isValid = false;
        continue;
      }


        for(let i=0, len=fieldRules.length; i<len; i++){

          rule = fieldRules[i];

          input = form.elements[field];

          message = rule(input, this.form);

          if('' !== message){

             input.setCustomValidity(message);

              this.changeInvalidRule(input, rule, message);

              isValid = false;

              break;
          }

        }

    }

    return isValid;

  }

  changeInvalidRule(input, rule, message){

    this.invalidRules[input.name] = rule;

    this.changeMessage(input, message || rule(input, this.form));

    this.inputInvalid(input);

  }


  flash(field, message) {

    let input = this.form.elements[field];

    input.setCustomValidity(message);

    this.changeInvalidRule(input, ()=>'', message);


    // this.form.checkValidity();

    return this;
  }



  on(type, listener){

    if(!this._events[type]){
      this._events[type] = [];
    }

    this._events[type].push(listener);

    return this;

  }

  trigger(type, ...params){

    if(this._events[type]){
      let listeners = this._events[type];

      for(let listener of listeners){

        listener.apply(this, params);

      }

    }

  }

  renderMessage(message = ''){

    return `<${this.options.tagMessage} class="${this.options.classMessage}">${message}</${this.options.tagMessage}>`

  }

}








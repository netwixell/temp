// IMPORTANT! Import only from dist because of an issue with the UglifyJS: https://github.com/nolimits4web/Swiper/issues/2263
import Swiper from 'swiper/dist/js/swiper.js';

var TicketPrice=(function(){
  var r_split_1000 = /\B(?=(\d{3})+(?!\d))/g;

  function TicketPrice(form){
    this.form=form;
    this.first_payment=
    this.commission_k=
    this.payments_count = null;
    this.price_elms_cls = "js-ticket__price";
    this.buying_button_cls = "js-ticket__button--buying";
    this.installment_button_cls = "js-ticket__button--installment";
    this.installment_enabled=true;
    this.init();
  }

  TicketPrice.prototype.init=function(){
    var inputs;
    inputs = this.form.elements;

    if (
      inputs["first_payment"] && inputs["commission_k"] && inputs["payments_count"]
    ){
      this.first_payment =  parseFloat(inputs["first_payment"].value);
      this.commission_k = parseFloat(inputs["commission_k"].value);
      this.payments_count =  parseFloat(inputs["payments_count"].value);
    }
    else{
      this.installment_enabled=false;
    }

    this.togglerObserver();
    this.setTotals();
  };

  var toggler_onchange=function(ticket_price){

    return function(e){
      var checkbox=this;

      checkbox.dataset.price = (checkbox.checked) ? checkbox.dataset.priceOn : checkbox.dataset.priceOff;

      ticket_price.setTotals();
    };

  };

  TicketPrice.prototype.togglerObserver=function(){
    var x=0,
      togglers = this.form.querySelectorAll('.' + this.price_elms_cls + '[type="checkbox"]'),
      count = togglers.length,
      toggler;

    for(; x<count; x++){
      toggler = togglers[x];
      toggler.dataset.price = (toggler.checked) ? toggler.dataset.priceOn : toggler.dataset.priceOff;
      toggler.addEventListener("change", toggler_onchange(this));
    }
  };

  function price_format(number){
    var pretty_number= Math.ceil(number),

    price = pretty_number.toString().replace(r_split_1000, "&#8201;") + ' ₴';

    return price;
  }
  function calculate_installment(total_cost, first_payment, payments_count, commission_k) {
    var monthly_payment;

    monthly_payment=  ( (total_cost*commission_k) - first_payment) / payments_count;

    return monthly_payment;
  }

  TicketPrice.prototype.setTotals=function(){
    var x=0,
      price_elms = this.form.querySelectorAll('.' + this.price_elms_cls),
      count=price_elms.length,
      total_cost=0,
      installment_payment;
    for(; x<count; x++){
      total_cost += parseFloat(price_elms[x].dataset.price || 0);
    }
    this.form.querySelector('.' + this.buying_button_cls +' b').innerHTML=price_format(total_cost);

    if (this.installment_enabled){
      installment_payment = calculate_installment(total_cost,
        this.first_payment, this.payments_count, this.commission_k);

      let holder = this.form.querySelector('.' + this.installment_button_cls + ' b');
      let mask = holder.dataset.mask;

      holder.innerHTML = mask.replace(':price', price_format(installment_payment) );
    }

  };

  return TicketPrice;
})();



 new Swiper('.tickets__swiper-container', {
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

  (function () {

    var i = 0,
      len,
      toggler_elms;

    function on_change() {
      var x = 0,
        count,
        id = this.dataset.id,
        toggler_children;
      toggler_children = document.getElementsByClassName('js-toggler-' + id);
      count = toggler_children.length;
      for (; x < count; x++) {
        toggler_children[x].classList.toggle('toggler--disabled');
      }
    }

    //get toggler checkboxes with class js-toggler
    toggler_elms = document.getElementsByClassName('js-toggler');

    len = toggler_elms.length;

    for (; i < len; i++) {
      toggler_elms[i].addEventListener('change', on_change);
    }

  })();

  var x=0,
    tickets_container = document.querySelector('.tickets__list'),
   ticket_forms = tickets_container.getElementsByTagName('form'),
   count=ticket_forms.length;
   for(;x<count;x++){
     ( new TicketPrice(ticket_forms[x]) );
   }










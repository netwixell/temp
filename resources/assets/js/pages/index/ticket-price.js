
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

      this.form.querySelector('.' + this.installment_button_cls + ' b').innerHTML = price_format(installment_payment)+' / мес';
    }

  };

  return TicketPrice;
})();

// Init TicketPrice

(function(){

  var x=0,
    tickets_container = document.querySelector('.tickets__list'),
   ticket_forms = tickets_container.getElementsByTagName('form'),
   count=ticket_forms.length;
   for(;x<count;x++){
     ( new TicketPrice(ticket_forms[x]) );
   }

})();



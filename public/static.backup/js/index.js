var Particle = /** @class */ (function() {
  function Particle(x, y, angle, speed) {
    this.angle = 10;
    this.speed = speed;
    this.b = 0;
    this.x = x;
    this.y = y;
    this.angle = angle;
    this.size = Math.random() * 15 + 15;
  }
  Object.defineProperty(Particle.prototype, "speed", {
    get: function() {
      return this._speed;
    },
    set: function(newSpeed) {
      this._speed = newSpeed;
    },
    enumerable: true,
    configurable: true
  });
  Particle.prototype.linear = function(x) {
    return Math.tan((this.angle * Math.PI) / 180) * x + this.b;
  };
  return Particle;
})();
var Particles = /** @class */ (function() {
  /**
   * Create a set of particles
   * @constructor
   *
   * @param path Path to image
   * @param ctx Canvas context
   * @param count Number of particles
   * @param speed Speed of particles in px/second
   */
  function Particles(path, ctx, count, speed) {
    if (speed === void 0) {
      speed = 20;
    }
    this.ctx = ctx;
    this.last = 0;
    ctx.canvas.width = this.ctx.canvas.offsetWidth;
    ctx.canvas.height = this.ctx.canvas.offsetHeight;
    ctx.globalCompositeOperation = "destination-over";
    this.particle = new Array(count);
    for (var i = 0; i < this.particle.length; i++) {
      this.particle[i] = new Particle(
        Math.random() * ctx.canvas.width,
        Math.random() * ctx.canvas.height,
        Math.random() * 360,
        speed
      );
    }
    this.figure = new Image();
    this.figure.src = path;
    this.run = false;
  }
  Particles.prototype.draw = function(diff) {
    this.ctx.clearRect(0, 0, this.ctx.canvas.width, this.ctx.canvas.height);
    for (var i = 0; i < this.particle.length; i++) {
      if (this.particle[i].x + this.particle[i].size > this.ctx.canvas.width) {
        this.particle[i].x = this.ctx.canvas.width - this.particle[i].size;
        this.particle[i].angle *= -1;
        this.particle[i].angle += 180;
      } else if (this.particle[i].x < 0) {
        this.particle[i].x = 0;
        this.particle[i].angle *= -1;
        this.particle[i].angle += 180;
      }
      if (this.particle[i].y + this.particle[i].size > this.ctx.canvas.height) {
        this.particle[i].y = this.ctx.canvas.height - this.particle[i].size;
        this.particle[i].angle *= -1;
      } else if (this.particle[i].y < 0) {
        this.particle[i].y = 0;
        this.particle[i].angle *= -1;
      }
      var x =
        this.particle[i].speed *
        (diff / 1000) *
        Math.cos((this.particle[i].angle * Math.PI) / 180);
      var y = this.particle[i].linear(x);
      this.particle[i].x += x;
      this.particle[i].y += y;
      this.ctx.drawImage(
        this.figure,
        this.particle[i].x,
        this.particle[i].y,
        this.particle[i].size,
        this.particle[i].size
      );
    }
  };
  Particles.prototype.stop = function() {
    this.run = false;
  };
  Particles.prototype.start = function() {
    this.run = true;
    this.last = 0;
    this.animate();
  };
  Particles.prototype.animate = function(time) {
    var _this = this;
    if (time === void 0) {
      time = 0;
    }
    var timeDiff = time - this.last;
    if (this.run) {
      if (timeDiff < 1000) {
        this.draw(timeDiff);
      }
      this.last = performance.now();
      requestAnimationFrame(function(time) {
        return _this.animate(time);
      });
    } else {
      this.ctx.clearRect(0, 0, this.ctx.canvas.width, this.ctx.canvas.height);
    }
  };
  Particles.prototype.update = function() {
    this.ctx.canvas.width = this.ctx.canvas.offsetWidth;
    this.ctx.canvas.height = this.ctx.canvas.offsetHeight;
  };
  return Particles;
})();
//# sourceMappingURL=particles.js.map

let canvas1 = document.getElementById("particles1");
let canvas2 = document.getElementById("particles2");
let section = document.querySelector(".hero");

// Получаем контексты для рисования
let ctx1 = canvas1.getContext("2d");
let ctx2 = canvas2.getContext("2d");

// Адрес изображения частицы
let particle_img = section.dataset.particleImg;

let View1;
let View2;

// Контроллер частиц
function Controller() {
  this.isActive = false;
  this.init = function () {
    this.isActive = true;
    // Создаём наборы частиц (путь к картинке, контекст, кол-во частиц, скорость - пикселей за секунду)
    View1 = new Particles(particle_img, ctx1, 3, 15);
    View2 = new Particles(particle_img, ctx2, 7, 30);
    this.start();
  };
  this.start = function () {
    View1.start();
    View2.start();
  };
  this.stop = function () {
    if (this.isActive === true) {
      this.isActive = false;
      View1.stop();
      View2.stop();
    }
  };
  this.update = function () {
    View1.update();
    View2.update();
  };
}

let Ctr = new Controller();
if (document.documentElement.clientWidth >= 1025) Ctr.init();

// Обновлять область отображения canvas при изменении размера экрана
window.addEventListener("resize", function () {
  if (document.documentElement.clientWidth < 1025) {
    if (Ctr.isActive) Ctr.stop();
  } else {
    Ctr.update();
    if (!Ctr.isActive) Ctr.init();
  }
});

var rellax = new Rellax('.guests__layer', {
  center: true
});

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

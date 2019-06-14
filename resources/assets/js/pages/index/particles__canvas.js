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

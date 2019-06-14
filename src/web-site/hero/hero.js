// Hero height

(function(hero){ if(!hero){return;}

  const isMobile = (window.innerWidth <= 800 && window.innerHeight <= 600);
  // const ratio = window.devicePixelRatio || 1;

  function windowHeight(){
    return Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
  }

  // Правит не работающую как надо формулу CSS height: 100vh
  function setHeroHeight(){

    // Задание высоты hero на десктопной версии сайта
    if(!isMobile) return hero.style.minHeight = windowHeight() + 'px';

    // Задание высоты hero согласно размера экрана для мобильных
    hero.style.minHeight = screen.height + 'px';

  }

  setHeroHeight();

  // FIXME: Убрано тк видно дергание на Android
  // window.addEventListener('resize', setHeroHeight);

 })(document.getElementsByClassName('hero')[0]);

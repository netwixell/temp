(function(hero){ if(!hero){return;}

  // Правит не работающую как надо формулу CSS height: 100vh
  hero.style.minHeight = window.innerHeight + 'px';

  // window.addEventListener('resize',function(e){

  //   hero.style.minHeight = window.innerHeight + 'px';

  // });

})(document.getElementsByClassName('hero')[0]);

(function(buttonsReaction){
  if(!buttonsReaction.length) return;

  var classLikesCounter = 'likes__counter',
    classButtonActive = 'likes__item--active',
    containerTotalCounter = document.querySelector('.likes__counter-wrapper');

  function renderLikesCounter(count){

    return '<span class="'+classLikesCounter+'">'+count+'</span>';


  }

  function renderTotalCounter(count, text){
    return '<b class="likes__counter likes__counter--total">'+count+'</b><b class="likes__text">'+text+'</b>';
  }

  function changeTotal(count, text){

      containerTotalCounter.innerHTML = ( count > 0 ) ? renderTotalCounter(count, text) : '';

  }

  function onClick(e){
    e.preventDefault();
    var button = this,
      type = button.dataset.type,
      count = parseInt(button.dataset.count) || 0;

      button.disabled = true;

    getJSON('?reaction='+type, function(data){
      var likesCounter;

      button.disabled = false;

      if(data.success){

        likesCounter = button.querySelector('.'+classLikesCounter);

        if(likesCounter) likesCounter.remove();

        if(data.isActive){
          count++;
          button.classList.add(classButtonActive);
        } else {
          count--;
          button.classList.remove(classButtonActive);
        }

        button.dataset.count = count;

        changeTotal(parseInt(data.total) || 0, data.totalText);

        if(count > 0) button.insertAdjacentHTML('beforeend', renderLikesCounter(count));
      }

    });

    return false;

  }


  for(var i=0, len=buttonsReaction.length; i<len; i++){

    buttonsReaction[i].addEventListener('click', onClick, false);

  }


})(document.querySelectorAll('.likes__item'));


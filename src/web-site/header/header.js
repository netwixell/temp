(function(header){ if(!header){return;}
  var cls_header_substrate = 'header--substrate';

  function header_substrate(){

    if (header.offsetHeight > window.pageYOffset ) {

      header.classList.remove(cls_header_substrate);

    } else {

      header.classList.add(cls_header_substrate);

    }

  }

   window.addEventListener('scroll', header_substrate);

   header_substrate();


})(document.querySelector('.header'));

// import './../../common/js/infiniteScroll';

(function(container){

  if(!container) return;

  var limit = parseInt(container.dataset.limit) || 3,
    skip = limit,
    isLoad = false,
    isEndList = false;

  function render(items){

    for(var i=0, len = items.length; i < len; i++){

      container.insertAdjacentHTML('beforeend', items[i]);

    }

  }

  function handleOnScroll() {
    // http://stackoverflow.com/questions/9439725/javascript-how-to-detect-if-browser-window-is-scrolled-to-bottom
    var scrollTop = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
    var scrollHeight = (document.documentElement && document.documentElement.scrollHeight) || document.body.scrollHeight;
    var clientHeight = document.documentElement.clientHeight || window.innerHeight;
    var scrolledToBottom = Math.ceil( (scrollTop + clientHeight) * 1.15 ) >= scrollHeight - 300;

    if (scrolledToBottom) {

      if(isLoad || isEndList) return;

      isLoad = true;

      getJSON('?skip='+skip, (data)=>{

        if(data.HTMLitems && data.HTMLitems.length){
          render(data.HTMLitems);
          skip+=limit;
          // Подгрузка количества комментариев из facebook
          if ( 'undefined' !== typeof FB ) FB.XFBML.parse();

        } else isEndList = true;

        if(data.HTMLtail && skip > limit){
          isEndList = true;
          container.parentNode.insertAdjacentHTML('beforeend', data.HTMLtail);
        }

        isLoad = false;

      });
    }
  }

  window.addEventListener('scroll', handleOnScroll);


  // setup infinite scroll
  // infiniteScroll({
  //   distance: 50,
  //   callback: function(done) {
  //     // 1. fetch data from the server
  //     // 2. insert it into the document
  //     // 3. call done when we are done

  //     getJSON('?skip='+skip, function(data){

  //         if(data.HTMLitems && data.HTMLitems.length){
  //           render(data.HTMLitems);
  //           skip+=limit;
  //           // Подгрузка количества комментариев из facebook
  //           if ( 'undefined' !== typeof FB ) FB.XFBML.parse();

  //         } else isEndList = true;

  //         if(data.HTMLtail && skip > limit){
  //           isEndList = true;
  //           container.parentNode.insertAdjacentHTML('beforeend', data.HTMLtail);
  //         }

  //         if(!isEndList) done();

  //     });


  //   }
  // });



})(document.getElementById('endless-list'));

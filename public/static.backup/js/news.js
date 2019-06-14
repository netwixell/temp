
/**
 * Implement infinite scrolling
 * - Inspired by: http://ravikiranj.net/drupal/201106/code/javascript/how-implement-infinite-scrolling-using-native-javascript-and-yui3
 */

(function() {
  var isIE = /msie/gi.test(navigator.userAgent); // http://pipwerks.com/2011/05/18/sniffing-internet-explorer-via-javascript/

  this.infiniteScroll = function(options) {
    var defaults = {
      callback: function() {},
      distance: 50
    }
    // Populate defaults
    for (var key in defaults) {
      if(typeof options[key] == 'undefined') options[key] = defaults[key];
    }

    var scroller = {
      options: options,
      updateInitiated: false
    }

    window.onscroll = function(event) {
      handleScroll(scroller, event);
    }
    // For touch devices, try to detect scrolling by touching
    document.ontouchmove = function(event) {
      handleScroll(scroller, event);
    }
  }

  function getScrollPos() {
    // Handle scroll position in case of IE differently
    if (isIE) {
      return document.documentElement.scrollTop;
    } else {
      return window.pageYOffset;
    }
  }

  var prevScrollPos = getScrollPos();

  // Respond to scroll events
  function handleScroll(scroller, event) {
    if (scroller.updateInitiated) {
      return;
    }
    var scrollPos = getScrollPos();
    if (scrollPos == prevScrollPos) {
      return; // nothing to do
    }

    // Find the pageHeight and clientHeight(the no. of pixels to scroll to make the scrollbar reach max pos)
    var pageHeight = document.documentElement.scrollHeight;
    var clientHeight = document.documentElement.clientHeight;

    // Check if scroll bar position is just 50px above the max, if yes, initiate an update
    if (pageHeight - (scrollPos + clientHeight) < scroller.options.distance) {
      scroller.updateInitiated = true;

      scroller.options.callback(function() {
        scroller.updateInitiated = false;
      });
    }

    prevScrollPos = scrollPos;
  }
}());

(function(container){

  if(!container) return;

  var limit = parseInt(container.dataset.limit) || 3,
    skip = limit,
    isEndList = false;



  function render(items){

    for(var i=0, len = items.length; i < len; i++){

      container.insertAdjacentHTML('beforeend', items[i]);

    }


  }


  // setup infinite scroll
  infiniteScroll({
    distance: 50,
    callback: function(done) {
      // 1. fetch data from the server
      // 2. insert it into the document
      // 3. call done when we are done

      getJSON('?skip='+skip, function(data){

          if(data.HTMLitems && data.HTMLitems.length){
            render(data.HTMLitems);
            skip+=limit;
          } else isEndList = true;

          if(data.HTMLtail && skip > limit){
            isEndList = true;
            container.parentNode.insertAdjacentHTML('beforeend', data.HTMLtail);
          }

          if(!isEndList) done();

      });


    }
  });



})(document.getElementById('endless-list'));

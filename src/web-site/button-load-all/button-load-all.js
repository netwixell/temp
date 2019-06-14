(function(buttons){
  var x = 0,
    count = buttons.length,
    button,
    is_mobile = false;

  var width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

  function onClick(e){

    loadAll(this);

    return false;
  }

  if(width < 768){ // for mobile devices

    for(; x<count; x++){
      button = buttons[x];
      button.addEventListener('click', onClick);
    }

  }
  else{
    for (; x < count; x++) {
      button = buttons[x];
      loadAll(button);
    }
  }
  function queue(concurrency) {
    var running = 0;
    var taskQueue = [];

    var runTask = function(task){
      running++;
      task(function(){
        running--;
        if (taskQueue.length > 0) {
          runTask(taskQueue.shift());
        }
      });
    };

    var enqueueTask = function(task) {
      taskQueue.push(task);
    };

    return {
      push: function(task){
       return running < concurrency ? runTask(task) : enqueueTask(task);
      }
    };
  }

  function insertItem(container, item){

    return function(done){

      setTimeout(function () {

        container.insertAdjacentHTML('beforeend', item);

        done();

      }, 500);

    };

  }

  function loadAll(button){

    var url = button.dataset.url || '',
      selector = button.dataset.container,
      insert_method = button.dataset.insertMethod || 'append',
      taskRunner;

    getJSON(url, function(data){

      var container = document.querySelector(selector);

      var items = data.html, i=0, len = items.length;

      if('append' === insert_method){
        for(; i<len; i++){
          container.insertAdjacentHTML('beforeend', items[i]);

        }

        // container.insertAdjacentHTML('beforeend', data.html);
      }
      else if ('replace' === insert_method){
        taskRunner = queue(1);
        // container.innerHTML = data.html;
        container.innerHTML = '';
        for (; i < len; i++) {
          taskRunner.push( insertItem(container, items[i]) );
          // insertItem(container, items[i]);
          // container.insertAdjacentHTML('beforeend', items[i]);

        }
      }

    });

    button.parentNode.removeChild(button);

  }

  function getJSON(url, onDone, onFail) {

      var XHR = new XMLHttpRequest();

      // Define what happens on successful data submission
      XHR.addEventListener("load", function (event) {


        var data = JSON.parse(XHR.responseText);
        if (XHR.readyState == 4 && XHR.status == "200") {
          onDone(data);
        } else {
          if (onFail) {
            onFail(data);
          }
        }

      });

      // Define what happens in case of error
      XHR.addEventListener("error", function (event) {
        if (onFail) {
          onFail();
        }
      });

      // Set up our request
      XHR.open("GET", url, true);

      //Send the proper header information along with the request
      // XHR.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      XHR.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

      // The data sent is what the user provided in the form
      XHR.send();

  }

  window.getJSON = getJSON;


})(document.querySelectorAll('.js-more'));

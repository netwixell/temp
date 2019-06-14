(function(alert_elms){

  var cls_alert_visibility = 'aos-animate',
    time_visibility = 10 * 1000; // 10 seconds

  var len = alert_elms.length, i = 0;

  function alert_hide(elem) {

    elem.classList.remove(cls_alert_visibility);

  }

  function alert_timer(elem){

    setTimeout(function(){

      alert_hide(elem);

    }, time_visibility);

  }

  function alert_onclick(e){
    e.preventDefault();

    alert_hide(this);

    this.removeEventListener('click',alert_onclick);
  }

  for(; i<len; i++){
    alert_elms[i].addEventListener('click',alert_onclick);
    alert_timer(alert_elms[i]);
  }



})(document.getElementsByClassName('alert'));

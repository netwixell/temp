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

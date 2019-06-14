(function (element) {

  if (element) {
    var maskOptions = {
      mask: '{+38\\0} (00) 000 00 00'
    };
    var mask = new IMask(element, maskOptions);
  }

})(document.getElementById('tel'));

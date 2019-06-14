const digitTest = /^\d+$/,
  keyBreaker = /([^\[\]]+)|(\[\])/g,
  plus = /\+/g,
  paramTest = /([^?#]*)(#.*)?$/,
  r_split_1000 = /\B(?=(\d{3})+(?!\d))/g;

let ukMonths = ['січня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня'];

const EmailServices = [
      {name: 'gmail.com', address: 'gmail.com'},
      {name: 'mail.ru', address: 'e.mail.ru'},
      {name: 'yandex.ru', address: 'mail.yandex.ua'},
      {name: 'yandex.ua', address: 'mail.yandex.ua'},
      {name: 'i.ua', address: 'mail.i.ua'},
      {name: 'rambler.ru', address: 'mail.rambler.ru'},
      {name: 'meta.ua', address: 'webmail.meta.ua'},
      {name: 'ukr.net', address: 'mail.ukr.net'}
];


export function deparam(params) {

  /**
   * @function deparam
   *
   * Takes a string of name value pairs and returns a Object literal that represents those params.
   *
   * @param {String} params a string like <code>"foo=bar&person[age]=3"</code>
   * @return {Object} A JavaScript Object that represents the params:
   *
   *     {
   *       foo: "bar",
   *       person: {
   *         age: "3"
   *       }
   *     }
   */

  if (!params || !paramTest.test(params)) {
    return {};
  }


  var data = {},
    pairs = params.split('&'),
    current;

  for (var i = 0; i < pairs.length; i++) {
    current = data;
    var pair = pairs[i].split('=');

    // if we find foo=1+1=2
    if (pair.length != 2) {
      pair = [pair[0], pair.slice(1).join("=")]
    }

    var key = decodeURIComponent(pair[0].replace(plus, " ")),
      value = decodeURIComponent(pair[1].replace(plus, " ")),
      parts = key.match(keyBreaker);

    for (var j = 0; j < parts.length - 1; j++) {
      var part = parts[j];
      if (!current[part]) {
        // if what we are pointing to looks like an array
        current[part] = digitTest.test(parts[j + 1]) || parts[j + 1] == "[]" ? [] : {}
      }
      current = current[part];
    }
    let lastPart = parts[parts.length - 1];
    if (lastPart == "[]") {
      current.push(value)
    } else {
      current[lastPart] = value;
    }
  }
  return data;

}


export function serialize(obj, prefix) {
  var str = [],
    p;
  for (p in obj) {
    if (obj.hasOwnProperty(p)) {
      var k = prefix ? prefix + "[" + p + "]" : p,
        v = obj[p];

      if (v !== null) {

        if (typeof v === "object") {
          let s = serialize(v, k);

          if (s) {
            str.push(s);
          }
        } else {
          str.push(encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }

      }

    }
  }
  return str.join("&");
}

/**
 * @param {Number} number
 * @param {Array} titles
 * @return {String} - one item of titles
 *
 * Russian
 * (3, ['бал', 'бала', 'балов']) → 'бала'
 * (1, ['бал', 'бала', 'балов']) → 'бал'
 * (5, ['бал', 'бала', 'балов']) → 'балов'
 *
 * English
 * (1, ['point','points']) → 'point'
 * (2, ['point','points']) → 'points'
 *
 */
export function declOfNum(number, titles) {
  if(titles.length == 2) return number == 1 ? titles[0] : titles[1];
  let cases = [2, 0, 1, 1, 1, 2];
  return titles[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];
}

/**
 * @param {String} HTML representing a single element
 * @return {Element}
 */
export function htmlToElement(html){
  var template = document.createElement('template');
  html = html.trim(); // Never return a text node of whitespace as the result
  template.innerHTML = html;
  return template.content.firstChild;
}

/**
 * @param {String} HTML representing any number of sibling elements
 * @return {NodeList}
 */
export function htmlToElements(html) {
  var template = document.createElement('template');
  template.innerHTML = html;
  return template.content.childNodes;
}


/**
 * @param {String} Date
 * @param {Integer} number of type formated date
 *        1 - 10.05.2018
 *        2 - 10 травня 2018
 * @return {String}
 */
export function localeDate(str, type=1){

  let d, result = str;

  if(1 == type){

     d = new Date(str.split('T')[0]);

     result = ("0" + d.getDate()).slice(-2) + "." + ("0" + (d.getMonth() + 1)).slice(-2) + "." + d.getFullYear();

  }
  else if(2 == type){

    d = new Date(str);

    result = `${d.getDate()} ${ukMonths[d.getMonth()]}, ${d.getFullYear()}`;

  }

  return result;
}


export function localePrice(number) {
  return prettyNumber(number)+ ' ₴';
}

/**
 * @param {Number} number - any number
 * @return {String}
 *  For example:
 *  10000 → 10 000
 *  10000.2557 → 10 000.26
 */
export function prettyNumber(number) {
  return Number( (number).toFixed(2) ).toString().replace(r_split_1000, "\u2009");
}


export function imageSource(images, sizes, path='', type='image/jpeg'){

  let html, src, srcset = [],
    i=0, len=sizes.length;

    for(; i < len; i++){

      if(images[i]){

        src = '/'+path+'/'+images[i]+' '+sizes[i];
        srcset.push(src);
      }
      else{
        break;
      }

    }

    html= `<source type="${type}" data-srcset="${srcset.join(', ')}">`;

    return html;
}

export function parseUserEmail(email) {
  if (email.length > 0 && email.search("@") > 0) {
      var host = email.split("@")[1];
      return host.length > 0 ? host.toLowerCase() : null
  }
  return null
}

export function openMailbox(email = ''){

  email = email.trim();

  var host = helpers.parseUserEmail(email);

  if (null != host) {
      var service = EmailServices.find(function(n){
          return n.name === host
      });

      service && window.open("https://".concat(service.address))
  }

}

export function isMobileDevice(){
  return (window.innerWidth < 1417);
}

export const baseUrl = location.protocol+'//'+location.host+location.pathname;


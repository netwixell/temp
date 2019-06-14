
const DEFAULTS = {
  link: null,
  duration: 3000
};


function handlerNotification(notification, options){

  options = Object.assign({}, DEFAULTS, options);

  if(options.link){

    notification.onclick = function(){
      window.open(options.link);
    }

  }

  setTimeout(notification.close.bind(notification), options.duration);

}


export default (message, options = {}) => {

  var notification;

  var customOptions = {},
    nativeOptions = {};

  Object.keys(options).forEach(key => {

    if(key in DEFAULTS) customOptions[key] = options[key];
    else nativeOptions[key] = options[key];

  });

  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }

  // Let's check whether notification permissions have already been granted
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    notification = new Notification(message, nativeOptions);

    handlerNotification(notification, customOptions);
  }

  // Otherwise, we need to ask the user for permission
  else if (Notification.permission !== "denied") {

    Notification.requestPermission().then(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
        notification = new Notification(message, nativeOptions);

        handlerNotification(notification, customOptions);
      }
    });
  }


}

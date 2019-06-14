import Echo from "laravel-echo";
import notify from './../../common/js/notify';
window.io = require('socket.io-client');

const duration = 3000;

function handleNotification(message){

  if(!message.route) return false;

  let link = document.querySelector('a[data-route="'+message.route+'"]');

  let parent = link.parentNode;

  if(parent && parent.classList.contains('active') ){
    if (document.hasFocus()) return location.reload();
    else setTimeout(()=>location.reload(), duration);
  }

  notify(message.message, {
    duration,
    link: message.link,
    icon:'/admin-panel/img/notification/molfar.png',
  });

  if(!link.style.color) link.style.color = '#f39c12';

}

let host =  document.querySelector('input[name="laravel_echo_server_url"]').value;

// Have this in case you stop running your laravel echo server
if (typeof io !== 'undefined') {

  let echo = new Echo({
    broadcaster: 'socket.io',
    host,
  });

  let userId = document.querySelector('input[name="user_id"]').value || 1;

  window.Echo = echo;

  window.userId = userId;

  echo.private('App.User.'+userId).notification(handleNotification);
}


(function(link){ if(!link){return;}


function closeAnnouncement(){

  document.querySelector('.announcement').style.visibility = 'hidden';

}

function showAnnouncement() {

  document.querySelector('.announcement').style.visibility = 'visible';

}

if (typeof (Storage) !== "undefined") {

  if (!localStorage.getItem('announcement_closed') ){
    showAnnouncement();
  }

}

link.addEventListener('click',function(e){
  e.preventDefault();

  closeAnnouncement();

  if (typeof (Storage) !== "undefined") {

    localStorage.setItem('announcement_closed', true);

  }

  return false;
});


})(document.getElementById('announcement-lnk'));

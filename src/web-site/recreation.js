import Rellax from 'rellax';

let rellax;

function parallax() {

  if (1024 >= window.innerWidth) {
    if (rellax) {
      rellax.destroy();
      rellax = null;
    }
    return false;
  }

  if (rellax) {
    // Destroy and create again parallax with previous settings
    rellax.refresh();
  } else {
    rellax = new Rellax('.activities-parallax__layer', {
      center: true
    });
  }

}

parallax();

window.addEventListener('resize', parallax);

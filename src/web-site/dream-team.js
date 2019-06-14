import './dream-team__prize/dream-team__prize'
import './form-dt/form-dt'

import PhotoSwipe from './photoswipe/photoswipe';

new PhotoSwipe({
  classButton: 'js-button-gallery',
  classGallery: 'js-gallery',
  photoSwipe: {shareEl: false, history:false}
});

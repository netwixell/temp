// ! module moved to scripts.js
// import * as Photoswipe from 'photoswipe'
// import * as PhotoswipeUI_Default from 'photoswipe/dist/photoswipe-ui-default'

const DEFAULTS = {
  classButton: '',
  classGallery: '',
  photoSwipe: null
};

/**
 * Открытие галереи при нажатии на кнопку
  @class PhotoSwipe
  @classdesc Обработка HTML-разметки галерии и открытие PhotoSwipe при нажатии на кнопку

  @param {Object} options - Опции класса
  @param {String} options.classButton - Имя CSS-класса кнопки для открытия галерии
  @param {String} options.classGallery - Имя CSS-класса с разметкой изображений галерии
  @param {Object} options.photoSwipe - параметры Photo Swipe

  Пример разметки:

  <a class="js-button-gallery" href="">Галерея</a>
  <div class="js-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" style="display:none">
    <figure itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
      <a href="image-1.jpg" itemprop="contentUrl" data-srcset="/300x100/image-1.jpg 300w, /600x200/image-1.jpg 600w, /900x300/image-1.jpg 900w">
        <figcaption itemprop="caption description">Описание изображения 1</figcaption>
      </a>
    </figure>
    <figure itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
        <a href="image-2.jpg" itemprop="contentUrl" data-srcset="/300x100/image-2.jpg 300w, /600x200/image-2.jpg 600w, /900x300/image-2.jpg 900w">
          <figcaption itemprop="caption description">Описание изображения 2</figcaption>
        </a>
    </figure>
  </div>
*/
export default class PhotoSwipe{

  constructor(options){
    this.options = {...DEFAULTS, ...options};
    this.init();
  }

  init(){

    this.handlerButtons();

  }

  handlerButtons(){
    let buttons = document.getElementsByClassName(this.options.classButton);

    for(let button of buttons){
      this.handlerButton(button);
    }

  }

  handlerButton(button){
    button.addEventListener('click', (e)=>{
      e.preventDefault();
      let parent = button.parentNode, gallery;

      gallery = parent.getElementsByClassName(this.options.classGallery)[0];

      if(!gallery) return Error('Gallery not found');

      this.parseThumbnailElements(gallery);

      return false;
    });
  }

  parseThumbnailElements(gallery){

    let items = [], item, src, srcset,
      links = gallery.getElementsByTagName('a');

    let self = this.constructor;

    for(let link of links){

      srcset = link.dataset.srcset;

      if(srcset) item = self.parseSrcset(srcset);
      else {
        src = link.getAttribute('href');
        item = {
          src: src,
          ...self.getSize(src)
        };
      }

      let figcaption = link.getElementsByTagName('figcaption')[0];

      if(figcaption) item.title = figcaption.innerHTML;

      items.push(item);
    }

    self.openGallery(items, this.options.photoSwipe);

  }

  static getSize(url){
    let matched = url.match(/(\d+)x(\d+)/);

    if(!matched) return Error('Size not found');

    return {
      w: parseInt(matched[1]),
      h: parseInt(matched[2])
    };

  }

  static parseSrcset(srcset){
    let item = {
      sizes: [],
    }, srcParts;

    srcset = srcset.split(',');

    for(let src of srcset){

      src = src.trim();

      srcParts = src.split(/\s+/);

      if(srcParts.length){

        item.sizes.push({
          src: srcParts[0],
          ...this.getSize(srcParts[0])
        });

      }
    }

    return item;
  }

  static openGallery(items, options){

    let pswpElement = document.getElementsByClassName('pswp')[0];

    // initialise as usual
    let gallery = new Photoswipe( pswpElement, PhotoswipeUI_Default, items, options);


    // create variable that will store real size of viewport
    let realViewportWidth,
    firstResize = true;

    // beforeResize event fires each time size of gallery viewport updates
    gallery.listen('beforeResize', function() {
      // gallery.viewportSize.x - width of PhotoSwipe viewport
      // gallery.viewportSize.y - height of PhotoSwipe viewport
      // window.devicePixelRatio - ratio between physical pixels and device independent pixels (Number)
      //                          1 (regular display), 2 (@2x, retina) ...

      // calculate real pixels when size changes
      realViewportWidth = gallery.viewportSize.x * window.devicePixelRatio;

      // Code below is needed if you want image to switch dynamically on window.resize

      // Invalidate items only when source is changed and when it's not the first update
      if(!firstResize) {
          // invalidateCurrItems sets a flag on slides that are in DOM,
          // which will force update of content (image) on window.resize.
          gallery.invalidateCurrItems();
      }

      if(firstResize) firstResize = false;

    });


    // gettingData event fires each time PhotoSwipe retrieves image source & size
    gallery.listen('gettingData', function(index, item) {

      // Set image source & size based on real viewport width
      if(item.sizes && item.sizes.length){

        let size = item.sizes.reduce(function(prev, curr) {
          return (Math.abs(curr.w - realViewportWidth) < Math.abs(prev.w - realViewportWidth) ? curr : prev);
        });

        item.src = size.src;
        item.w = size.w;
        item.h = size.h;

      }

    });

    gallery.init();

  }

}


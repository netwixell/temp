import React, {Component} from 'react';

import PhotoSwipe from '../photoswipe/photoswipe';

class VoteGallery extends Component {
  constructor(props){
    super(props);

    this.state = {
      items: []
    }
  }

  componentDidMount(){
    var responsive = this.props.responsive, r,
      item,
      items = [],
      i = 1,
      len = (responsive) ? responsive.length : 0;

    if(len <= 1) return;

    for(; i<len; i++){
      r = responsive[i];
      item = null;
      if(r.srcset) item = PhotoSwipe.parseSrcset(r.srcset);
      else if(r.src){
        item = {
          src: r.src,
          ...PhotoSwipe.getSize(r.src)
        };
      }
      if(item) item.title = this.props.caption;

      items.push(item);
    }

    this.setState({ items })

  }

  shouldComponentUpdate(nextProps, nextState) {
    return false;
  }

  open(e){
    e.preventDefault();

    if(!this.state.items.length) return false;

    PhotoSwipe.openGallery(this.state.items, {shareEl: false, history:false});
  }

  render(){

    var photo = (this.props.responsive && this.props.responsive[0]) ? {src:this.props.responsive[0].src, srcset:this.props.responsive[0].srcset, } : {src:'', srcset:''};
    return (
      <a className="card__img-wrapper loading" data-scroll-ignore href="" onClick={e => this.open(e)}>
        <img
          className="card__img lazyload"
          data-srcset={photo.srcset}
          data-src={photo.src}
          alt={this.props.children}
          src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="/>
      </a>
    );

  }

}

export default VoteGallery;

import React from 'react';

const Commercial = (props) => (

  <figure className="commercial">
    <div className="commercial__container container">
      <div className="commercial__wrapper container">
        <div className="commercial__inner commercial__inner--text">
          <p className="commercial__text"><b className="commercial__title">{props.title}</b></p>
          <p className="commercial__text">{props.children}</p>
          <p className="commercial__text">
            <a className="commercial__link" href={props.link_url} target="_blank" rel="noopener">{(props.link_title && props.link_title != '') ? props.link_title : props.link_url}</a>
          </p>
        </div>

        <div className="commercial__inner">
          <div className="commercial__img-wrapper loading">
            <img className="commercial__img lazyload" data-srcset={props.srcset} data-src={props.src} src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt={props.title} />
          </div>
        </div>
      </div>
    </div>
    <figcaption className="commercial__caption container"><em>{props.caption}</em></figcaption>
  </figure>
);

export default Commercial;

<section class="about">
  <div class="about__container container">
    <h2 class="about__title">@lang('dream-team-page.about__title')</h2>
    <div class="about__video-wrapper">
      <div class="about__video loading">
        <iframe class="lazyload" data-src="https://www.youtube.com/embed/IvNO8B_mFIA?rel=0&showinfo=0" width="560" height="315" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
    </div>
    <div class="about__description-wrapper">
      <p class="about__description about__description--text">@lang('dream-team-page.about__description')</p>
      <p class="about__description about__description--big"><b>100 000 {{declOfNum(100000, explode(',', __('format.hryvnia')))}}</b></p>
    </div>
  </div>
</section>

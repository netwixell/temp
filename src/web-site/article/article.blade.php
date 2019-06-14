
<article class="article">
  @if(isset($item->image))
  <div class="article__parallax">
    <div class="article__img-wrapper article__img-wrapper--outer">
      <img class="article__img"
          srcset="{{getThumbnail($item->image,600)}} 600w, {{getThumbnail($item->image,900)}} 900w, {{getThumbnail($item->image,1200)}} 1200w, {{getThumbnail($item->image,1500)}} 1500w, {{getThumbnail($item->image,1800)}} 1800w"
          src="{{getThumbnail($item->image,600)}}"
          alt="{{$item->getTranslatedAttribute('title')}}">
    </div>
  </div>
  @endif
  <div class="container article__container">
    <div class="article__inner article__inner--content">
      <h1 class="article__title article__title--h1">{{$item->getTranslatedAttribute('title')}}</h1>
      <time class="article__published" datetime="{{$item->created_at}}">{{locale_date($item->created_at, '%d %s, %d')}}</time>
      <div class="article__about">
        {!! $content !!}
      </div>
      <ul class="likely">
        <li class="facebook" tabindex="0" role="link" aria-label="Share on Facebook">@lang('posts.share_facebook')</li>
        <li class="twitter" tabindex="0" role="link" aria-label="Tweet on Twitter">@lang('posts.share_twitter')</li>
        <li class="telegram" tabindex="0" role="link" aria-label="Send on Telegram">@lang('posts.share_telegram')</li>
      </ul>
    </div>
    <div class="article__inner article__inner--likes likes">
      <p class="likes__counter-wrapper">
        @if($item->reactions_count && $item->reactions_count > 0)
        <b class="likes__counter likes__counter--total">{{$item->reactions_count}}</b><b class="likes__text">{{declOfNum($item->reactions_count, explode("," , __('post_reactions.reactions')))}}</b>
        @endif
      </p>
      <ul class="likes__list">
        @foreach($reactionTypes as $reactionType)
        <?php $reactiontype = strtolower($reactionType); ?>
        <li class="likes__item-wrapper">
        <button class="likes__item likes__item--{{$reactiontype}} @if(in_array($reactionType, $userReactions)){{'likes__item--active'}}@endif" data-type="{{$reactionType}}" data-count="{{$reactionsCount[ $reactionType ] or 0}}">
            <span class="likes__text">{{__('post_reactions.'.$reactionType)}}</span>
            @if(isset($reactionsCount[ $reactionType ]))<span class="likes__counter likes__counter--{{$reactiontype}}">{{$reactionsCount[ $reactionType ]}}</span>@endif
          </button>
        </li>
        @endforeach
      </ul>
    </div>
    <div class="article__inner article__inner--comments" id="comments">
      <div class="fb-comments" data-href="{{url()->current()}}" data-numposts="5"></div>
    </div>
  </div>
</article>

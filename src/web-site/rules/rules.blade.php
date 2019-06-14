<section class="rules">
  <div class="rules__container container">
    <h1 class="rules__title rules__title--h1">@lang('dream-team-page.rules__title')</h1>
    <aside class="rules__contents contents">
      <ol class="contents__list">
        @foreach($blocks as $block)
        <li class="contents__item contents__item--outer">
        <a class="contents__link contents__link--title" href="#block-{{$block->id}}">{{ str_before($block->getTranslatedAttribute('title'), '|')}}</a>
          <ol class="contents__list contents__list--inner">
            @foreach($block->children as $childBlock)
            @if($childBlock->type !== $childBlock::TYPE_CAPTION)<li class="contents__item"><a class="contents__link" href="#block-{{$childBlock->id}}">{{$childBlock->getTranslatedAttribute('title')}}</a></li>@endif
            @endforeach
          </ol>
        </li>
        @endforeach
      </ol>
    </aside>
    @foreach($blocks as $blockLevel2)
      <div class="rules__wrapper">
        <h2 class="rules__title rules__title--h2" id="block-{{$blockLevel2->id}}">{{str_after($blockLevel2->getTranslatedAttribute('title'), '|')}}</h2>
        {!!$blockLevel2->getTranslatedAttribute('html')!!}
        @foreach($blockLevel2->children as $blockLevel3)
        @if($blockLevel3->children_count > 0)<div class="rules__inner">@endif
          @if($blockLevel3->type !== $blockLevel3::TYPE_CAPTION)<h3 class="rules__title rules__title--h3" id="block-{{$blockLevel3->id}}">{{$blockLevel3->getTranslatedAttribute('title')}}</h3>@endif
          {!!$blockLevel3->getTranslatedAttribute('html')!!}
          @foreach($blockLevel3->children as $block)
            @if($block->type == $block::TYPE_RIGHT_COLUMN)<div class="rules__requirements">{!!$block->getTranslatedAttribute('html')!!}</div>
            @else{!!$block->getTranslatedAttribute('html')!!}@endif
          @endforeach
        @if($blockLevel3->children_count > 0)</div>@endif
        @endforeach
      </div>
    @endforeach
  </div>
</section>

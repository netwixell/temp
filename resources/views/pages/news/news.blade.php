<section class="news">
  <div class="container news__container">
    <div class="news__wrapper">
      <h1 class="news__title">Новости</h1>
      @if(count($items) > 0)
      <div class="news__inner" id="endless-list" data-limit="{{$limit}}">
        @foreach($items as $item)
          @include('components.news-item', ['item'=>$item])
          @if($loop->index == 1 && isset($advertisement))@include('modules.commercial', ['advertisement'=>$advertisement])@endif
        @endforeach
      </div>
      @else
        @include('components.news-empty')
      @endif
    </div>
  </div>
</section>

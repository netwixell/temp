<section class="schedule">
  <div class="schedule__container container">
    <h1 class="schedule__title">Программа</h1>
    <ol class="daylist tabs schedule__daylist" data-tabs>
      @foreach($schedule->keys() as $tab_date)
        <?php $date_num=strtotime($tab_date); ?>
        @if($loop->first)
        <li class="daylist__day-wrapper active">
          <a class="daylist__day active" href="#tab{{$loop->iteration}}" data-tab data-scroll-ignore title="{{locale_dow(date('w',$date_num))}}">
            <time datetime="{{$tab_date}}">{{date('d.m',$date_num)}}</time>
          </a>
        </li>
        @else
        <li class="daylist__day-wrapper">
          <a class="daylist__day" href="#tab{{$loop->iteration}}" data-tab data-scroll-ignore title="{{locale_dow(date('w',$date_num))}}">
            <time datetime="{{$tab_date}}">{{date('d.m',$date_num)}}</time>
          </a>
        </li>
        @endif
      @endforeach
    </ol>
    <div class="schedule__wrapper" data-tabs-content>
      @foreach($schedule as $tab_date=>$flows)
      <div class="schedule__inner tabs-pane @if($loop->first){{'active'}}@endif" id="tab{{$loop->iteration}}" data-tabs-pane>

        <ul class="flowlist schedule__flowlist">
          @foreach($flows->keys() as $tab_flow)
          @if(!empty($tab_flow))
          <li class="flowlist__flow-wrapper">
            <a class="flowlist__flow" href="#tab{{$loop->parent->iteration.'-'.$loop->iteration}}">
                <span>{{$tab_flow}}</span>
            </a>
          </li>
          @endif
          @endforeach
        </ul>
        <ol class="schedule__list">
          <li>
            @foreach($flows as $flow_name=>$items)
              <ol class="eventlist schedule__eventlist" @if(!empty($flow_name))id="tab{{$loop->parent->iteration.'-'.$loop->iteration}}"@endif>
                @if(!empty($flow_name))
                <h2 class="eventlist__title">{{$flow_name}}</h2>
                @endif
                @foreach($items as $item)
                <li class="event eventlist__event">
                  <ol class="event__timelist">
                    <li>
                      <time class="event__time event__time--start">@if(isset($item->start_time)){{date('H:i',strtotime($item->start_time))}}@endif</time>
                    </li>
                    <li>
                      <time class="event__time event__time--end">@if(isset($item->end_time)){{date('H:i',strtotime($item->end_time))}}@endif</time>
                    </li>
                  </ol>
                  <div class="event__about">
                    <div class="event__text-wrapper">
                      <h3 class="event__title">{{$item->title}}</h3>
                      @if(isset($item->options))
                        <?php $options=json_decode($item->options); ?>
                        @foreach($options as $option)
                        <span class="event__badge">{{__('schedule.'.$option)}}</span>
                        @endforeach
                      @endif
                      @if(!empty($item->description))<div class="event__description">{!!$item->description!!}</div>@endif
                      @if(isset($item->persons))
                      <strong class="event__lector">@foreach($item->persons as $person){{$person->name}}<?php if($loop->remaining>0) echo ', ';?>@endforeach</strong>
                      @endif
                    </div>
                    @if(isset($item->partners))
                    <div class="event__meta-wrapper">
                      <div class="event__logo">
                      @foreach($item->partners as $partner)<img class="event__img" src="/storage/{{get_file_url($partner->image)}}" width="120" alt="{{$partner->name}}">@endforeach
                      </div>
                    </div>
                    @endif
                  </div>
                </li>
                @endforeach
              </ol>
            @endforeach
          </li>
        </ol>
      </div>
      @endforeach
    </div>
  </div>
</section>

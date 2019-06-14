@if($teams->count() > 0)
<?php
$onlinePollIsOpen = isset($onlinePoll) && $onlinePoll->isOpen;
$onlinePollIsOver = isset($onlinePoll) && $onlinePoll->isOver;
?>
<section class="registred" id="registred">
  <div class="registred__container container">
    <h2 class="registred__title">@lang('dream-team-page.registred__title')</h2>
    <ol class="registred__list team-list">
      @foreach($teams as $team)
      <?php
        $photos = $team->responsive;
      ?>
      <li class="team-list__item @if('PAID'!==$team->status){{'team-list__item--inactive'}}@endif">
        <table class="team-list__team-table team-table">
          <tbody class="team-table__body">
            <tr class="team-table__title">
              <th>{{$team->getTranslatedAttribute('name')}}</th>
            </tr>
            <tr class="team-table__address">
              <td>{{$team->location}}</td>
            </tr>
            @if('PAID' === $team->status)
              @if(isset($team->badge))
              <tr class="team-table__badge @if('FINALIST' !== $team->badge){{'team-table__badge--winner'}}@endif">
                <td>{{__('teams.'.$team->badge)}}</td>
              </tr>
              @endif
              @if(is_array($photos) && count($photos) > 1)
              <tr class="team-table__photo">
                <td>
                  @if($onlinePollIsOpen || $onlinePollIsOver)
                  <a href="" class="js-button-gallery">@lang('dream-team-page.team-table__photo')</a>
                  <div class="js-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" style="display:none">
                  @foreach(array_slice($photos, 1) as $photo)
                    <figure itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                      <a href="{{$photo->src}}" itemprop="contentUrl" data-srcset="{{$photo->srcset}}">
                      <figcaption itemprop="caption description">{{$team->caption}}</figcaption>
                      </a>
                    </figure>
                  @endforeach
                  </div>
                  @endif
                </td>
              </tr>
              @endif
              @if($onlinePollIsOver)
              <tr class="team-table__results">
              <td><a href="{{$team->voteResultsUrl}}">@lang('dream-team-page.team-table__results')</a></td>
              </tr>
              @endif
            @endif
          </tbody>
        </table>
      </li>
      @endforeach
    </ol>
    @if($onlinePollIsOpen)
    <a class="registred__button button button--unfilled-blue" href="/dream-team/vote"><span>@lang('dream-team-page.registred__button')</span></a>
    @endif
  </div>
</section>
@endif

@if($event->teams->count() > 0)
<section class="registred" id="registred">
  <div class="registred__container container">
    <h2 class="registred__title">Команды</h2>
    <ol class="registred__list team-list">
      @foreach($event->teams as $team)
      <?php
        $photos = json_decode($team->photos);
      ?>
      <li class="team-list__item @if('PAID'!==$team->status){{'team-list__item--inactive'}}@endif">
        <table class="team-list__team-table team-table">
          <tbody class="team-table__body">
            <tr class="team-table__title">
              <th>{{$team->name}}</th>
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
              @if(is_array($photos) && count($photos) > 0)
              <tr class="team-table__photo">
                <td><a href="">Фото</a></td>
              </tr>
              @endif
            @endif
          </tbody>
        </table>
      </li>
      @endforeach
    </ol>
    {{-- <a class="registred__button button button--unfilled-blue" href=""><span>К голосованию</span></a> --}}
  </div>
</section>
@endif

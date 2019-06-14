@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" action="@if(isset($dataTypeContent->id)){{ route('voyager.tickets.update', $dataTypeContent->id) }}@else{{ route('voyager.tickets.store') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            @php
                $original_price = is_null($dataTypeContent->getOriginal('price')) ? 0 : $dataTypeContent->getOriginal('price');
                $locale_original_price = price_uah($original_price);

                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                $exclude = ['slug', 'event_id', 'flow', 'price', 'qty', 'created_by', 'updated_by', 'deleted_at', 'created_at','updated_at','ticket_belongsto_event_relationship', 'ticket_hasmany_early_bird_relationship'];
            @endphp

            <div class="row">
                <div class="col-md-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Свойства билета</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @foreach($dataTypeRows as $row)
                                @if(!in_array($row->field, $exclude))
                                    @php
                                        $options = json_decode($row->details);
                                        $display_options = isset($options->display) ? $options->display : NULL;
                                    @endphp
                                    @if ($options && isset($options->formfields_custom))
                                        @include('voyager::formfields.custom.' . $options->formfields_custom)
                                    @else
                                        <div class="form-group @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            <label for="name">{{ $row->display_name }}</label>
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if($row->type == 'relationship')
                                                @include('voyager::formfields.relationship')
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @if(isset($dataTypeContent->id))
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Опции билета</h3>
                            <div class="panel-actions">
                                <a href="{{route('voyager.ticket-options.create',['ticket_id'=>$dataTypeContent->id])}}" class="panel-action btn btn-sm btn-info">
                                     <i class="voyager-plus"></i> <span class="hidden-xs hidden-sm">Добавить опцию</span>
                                </a>
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                          <div class="dd">
                            <ol class="dd-list" id="options_list">
                              <?php
                              $options=$dataTypeContent->options()->withPivot('group')->get();
                              ?>
                                @foreach($options as $option)
                                <?php $id=$dataTypeContent->id.'-'.$option->id ?>
                                <li class="dd-item" data-id="{{$id}}">
                                    <div class="pull-right item_actions">
                                        <a class="btn btn-sm btn-danger pull-right delete" data-id="{{$id}}" href="{{route("voyager.ticket-options.destroy",['id'=>$id])}}">
                                            <i class="voyager-trash"></i>  <span class="hidden-xs hidden-sm">Удалить</span>
                                        </a>
                                    </div>
                                    <div class="dd-handle">
                                      <p>{{$option->title}}.&nbsp;
                                        @isset($option->pivot->group)<small>Группа {{$option->pivot->group}}</small>@endisset
                                      </p>
                                    </div>
                                </li>
                                @endforeach
                            </ol>
                          </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ранние пташки</h3>
                            <div class="panel-actions">
                                <a href="{{route('voyager.early-birds.create',['ticket_id'=>$dataTypeContent->id])}}" class="panel-action btn btn-sm btn-info">
                                     <i class="voyager-plus"></i> <span class="hidden-xs hidden-sm">Добавить</span>
                                </a>
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <?php
                        $early_birds = $dataTypeContent->early_birds;
                        ?>
                        @if($early_birds->count() > 0)
                        <table class="table table-borderless table-hover">
                          <thead>
                            <tr>
                              <th>Дата начала</th>
                              <th>Дата окончания</th>
                              <th style="width:160px">Цена (от → до)</th>
                              <th>Ежемесячное повышение</th>
                              <th style="width:150px">Действия</th>
                            </tr>
                          </thead>
                          <tbody id="early_birds_list">
                            @foreach($early_birds as $early_bird)
                            <tr>
                              <th scope="row" style="">
                                {{$early_bird->date_from->format('j.m.Y')}}
                              </th>
                              <td style="">
                                {{$early_bird->date_to->format('j.m.Y')}}
                              </td>
                              <td style="font-weight: 600;">
                                {{price_uah($early_bird->price)}} → {{$locale_original_price}}
                              </td>
                              <td>
                                @if($early_bird->monthly_increase)
                                <?php $early_bird_details = earlyBirdDetails($early_bird, $original_price); ?>
                                <span class="label label-success">↑ {{price_uah($early_bird_details['monthly_increase'])}}</span>
                                @endif
                              </td>
                              <td>
                              <a class="btn btn-sm btn-primary pull-right edit" data-id="{{$early_bird->id}}" href="{{route('voyager.early-birds.edit',$early_bird->id)}}"><i class="voyager-edit"></i></a>
                              <a class="btn btn-sm btn-danger pull-right delete" data-id="{{$early_bird->id}}" href="{{route('voyager.early-birds.destroy',$early_bird->id)}}"><i class="voyager-trash"></i></a>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                      @endif
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Заказы</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                          <div class="dd">
                            @php
                               $orders=$dataTypeContent->orders()->orderBy('status','asc')->latest()->simplePaginate(10);
                            @endphp
                            <ol class="dd-list" id="options_list">
                                @foreach($orders as $order)
                                <li class="dd-item" data-id="{{$order->id}}">
                                    <div class="pull-right item_actions">
                                        <a class="btn btn-sm btn-primary pull-right edit" data-id="{{$order->id}}" href="{{route("voyager.orders.edit",$order->id)}}">
                                            <i class="voyager-edit"></i>  <span class="hidden-xs hidden-sm">Перейти</span>
                                        </a>
                                    </div>
                                    <div class="dd-handle">
                                      <p>@include('admin-panel.order-status.order-status', ['status' => $order->status])&nbsp;№{{$order->id}}.&nbsp;{{$order->name}}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ol>
                            <div class="pull-right">
                              {{$orders->links()}}
                            </div>
                          </div>
                        </div>
                    </div>
                    @endif

                </div>
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Билет</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="event_id">Событие</label>
                                <select class="form-control select2" name="event_id">
                                  @php
                                    $model = app('App\Event');
                                    $query = $model::all();
                                  @endphp
                                  @foreach($query as $relationshipData)
                                    <option value="{{ $relationshipData->id }}" @if($dataTypeContent->event_id == $relationshipData->id){{ 'selected="selected"' }}@endif>{{ $relationshipData->title }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="flow">Поток</label>
                                @include('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'flow',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'flow')
                                ])
                                <input type="text" class="form-control" id="flow" name="flow"
                                    placeholder="Поток"
                                    value="@if(isset($dataTypeContent->flow)){{ $dataTypeContent->flow }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="price">Цена</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price"
                                    placeholder="Цена"
                                    value="{{ $original_price }}">
                                @if(isset($dataTypeContent->id))
                                  <?php $price = $dataTypeContent->price; ?>
                                  @if($original_price!=$price)
                                    <small class="text-primary">Текущая цена: {{price_uah($price)}}</small>
                                  @endif
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="qty">Количество</label>
                                <input type="number" step="1" class="form-control" id="qty" name="qty"
                                    placeholder="Количество"
                                    value="@if(isset($dataTypeContent->qty)){{ $dataTypeContent->qty }}@endif">
                                  @if(isset($dataTypeContent->id))
                                    <?php $remain = $dataTypeContent->remain; ?>
                                    @if( $remain < $dataTypeContent->qty )
                                      <small class="text-primary">Осталось: {{$remain}}</small>
                                    @endif
                                  @endif
                            </div>
                            <div class="form-group">
                                <label for="slug">{{ __('voyager::post.slug') }}</label>
                                @include('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'slug',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'slug')
                                ])
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="slug"
                                    {{!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}}
                                    value="@if(isset($dataTypeContent->slug)){{ $dataTypeContent->slug }}@endif">
                            </div>
                        </div>
                    </div>

                    <!-- ### Log CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> Журнал</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <dl>
                              @isset($dataTypeContent->updated_by)
                              <dd>Изменено</dd>
                              <dt>{{$dataTypeContent->updated_at}}, <a href="{{route('voyager.users.show',$dataTypeContent->updated_by)}}">{{$dataTypeContent->updatedByUser->name}}</a></dt>
                              <hr>
                              @endisset
                              @isset($dataTypeContent->created_by)
                              <dd>Создано</dd>
                              <dt>{{$dataTypeContent->created_at}}, <a href="{{route('voyager.users.show',$dataTypeContent->created_by)}}">{{$dataTypeContent->createdByUser->name}}</a></dt>
                              @endisset
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($dataTypeContent->id)){{ __('voyager::post.update') }}@else <i class="icon wb-plus-circle"></i> {{ __('voyager::post.new') }} @endif
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>


 @if(isset($dataTypeContent->id))
  <div class="modal modal-danger fade" tabindex="-1" id="delete_early_bird_modal" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                              aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="voyager-trash"></i> Вы действительно желаете удалить раннюю пташку?</h4>
              </div>
              <div class="modal-footer">
                  <form action="{{ route('voyager.early-birds.index') }}" id="delete_early_bird_form" method="POST">
                      {{ method_field("DELETE") }}
                      {{ csrf_field() }}

                      <input type="submit" class="btn btn-danger pull-right delete-confirm"
                              value="Удалить">
                  </form>
                  <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
    <div class="modal modal-danger fade" tabindex="-1" id="delete_option_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> Вы действительно желаете удалить опцию?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('voyager.ticket-options.index') }}" id="delete_option_form" method="POST">
                            {{ method_field("DELETE") }}
                            {{ csrf_field() }}

                            <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                    value="Удалить опцию">
                        </form>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
  @endif


@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('#slug').slugify();
            $('.toggleswitch').bootstrapToggle();

            $('#options_list .delete').on('click', function (e) {
                $('#delete_option_form')[0].action = $(this).prop('href');
                $('#delete_option_modal').modal('show');
                e.preventDefault();
                return false;
            });

            $('#early_birds_list .delete').on('click', function (e) {
                $('#delete_early_bird_form')[0].action = $(this).prop('href');
                $('#delete_early_bird_modal').modal('show');
                e.preventDefault();
                return false;
            });

        @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
        @endif
        });
    </script>
@stop

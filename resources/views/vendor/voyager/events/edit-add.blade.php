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
        <form class="form-edit-add" role="form" action="@if(isset($dataTypeContent->id)){{ route('voyager.events.update', $dataTypeContent->id) }}@else{{ route('voyager.events.store') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
            <div class="row">
                <div class="col-md-12">
                  @isset($dataTypeContent->id)
                  <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Программа</h3>
                            <div class="panel-actions">

                                <a href="{{route('voyager.schedule.create',['event_id'=>$dataTypeContent->id])}}" class="panel-action btn btn-sm btn-info">
                                     <i class="voyager-list-add"></i> <span class="hidden-xs hidden-sm">Добавить </span>
                                </a>
                            </div>
                        </div>
                  <table class="table table-borderless table-hover">
                    <thead>
                      <tr>
                        <th style="width:130px">Время</th>
                        <th></th>
                        <th style="width:180px">Спикеры</th>
                        <th style="width:180px">Партнеры</th>
                        <th style="width:140px">Действия</th>
                      </tr>
                    </thead>
                    <tbody id="schedule_list">
                    @foreach($schedule as $group_date=>$flows)
                    <tr>
                      <th colspan="5" scope="row" class="text-center">
                      <h4>{{date('d.m.Y',strtotime($group_date))}}</h4>
                      </th>
                    </tr>
                      @foreach($flows as $flow_name=>$items)
                        @if(!empty($flow_name))
                        <tr>
                        <th colspan="5" scope="row"><h5>{{$flow_name}}</h5></th>
                        </tr>
                        @endif
                        @foreach($items as $item)
                          <tr>
                            <th scope="row" style="font-weight: 600;">
                              @if(isset($item->start_time)){{date('H:i',strtotime($item->start_time))}}@endif @if(isset($item->end_time))– {{date('H:i',strtotime($item->end_time))}}@endif
                            </th>
                          <td>
                          @if(isset($item->options))
                            <?php $options=json_decode($item->options); ?>
                            @foreach($options as $option)
                            <span class="label label-info">{{__('schedule.'.$option)}}</span>
                            @endforeach
                          @endif
                          <h5>{{$item->title}}</h5>
                          @if(!empty($item->description))<div style="height:80px; overflow-y:auto; text-overflow:ellipsis"><p>{!!$item->description!!}</p></div>@endif
                          </td>
                          <td>
                            @if(isset($item->persons))
                              @foreach($item->persons as $person)
                                <p>{{$person->name}}</p>
                              @endforeach
                            @endif
                          </td>
                          <td>
                            @if(isset($item->partners))
                              @foreach($item->partners as $partner)
                                <p>{{$partner->name}}</p>
                              @endforeach
                            @endif
                          </td>
                          <td>
                          <a class="btn btn-sm btn-primary pull-right edit" data-id="{{$item->id}}" href="{{route('voyager.schedule.edit',$item->id)}}">
                                <i class="voyager-edit"></i>
                            </a>
                          <a class="btn btn-sm btn-danger pull-right delete" data-id="{{$item->id}}" href="{{route('voyager.schedule.destroy',$item->id)}}">
                              <i class="voyager-trash"></i>
                            </a>
                          </td>
                        </tr>
                        @endforeach
                      @endforeach
                    @endforeach
                    </tbody>
                  </table>
                    </div>


                    <!-- ### Event PERSONS ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Персоны</h3>
                            <div class="panel-actions">
                                <a href="{{route('voyager.event-persons.create',['event_id'=>$dataTypeContent->id])}}" class="panel-action btn btn-sm btn-info">
                                     <i class="voyager-list-add"></i> <span class="hidden-xs hidden-sm">Добавить </span>
                                </a>
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <table class="table table-borderless table-hover">
                          <thead>
                            <tr>
                              <th style="width:40px">№</th>
                              <th style="width:190px">Имя</th>
                              <th style="width:160px">Занимаемая позиция</th>
                              <th>Описание</th>
                              <th style="width:140px">Действия</th>
                            </tr>
                          </thead>
                          <tbody id="persons_list">
                          @foreach($event_persons as $flow_name=>$persons)
                          <tr>
                            <th colspan="5" scope="row" class="text-center">
                              <h5>@if(empty($flow_name)){{'Без потока'}}@else{{$flow_name}}@endif</h5>
                            </th>
                          </tr>
                            @foreach($persons as $person)
                            <tr>
                              <th scope="row" style="font-weight: 600;">
                                {{$person->order}}
                              </th>
                              <td style="font-weight: 600;">
                                {{$person->person->name}}
                              </td>
                              <td>
                                {{__('event_persons.'.$person->position)}}
                              </td>
                              <td>
                                <p>{{$person->caption}}</p>
                              </td>
                              <td>
                              <a class="btn btn-sm btn-primary pull-right edit" data-id="{{$person->id}}" href="{{route('voyager.event-persons.edit',$person->id)}}"><i class="voyager-edit"></i></a>
                              <a class="btn btn-sm btn-danger pull-right delete" data-id="{{$person->id}}" href="{{route('voyager.event-persons.destroy',$person->id)}}"><i class="voyager-trash"></i></a>
                              </td>
                            </tr>
                            @endforeach
                          @endforeach
                          </tbody>
                        </table>
                    </div>


                    @endisset
                    <!-- ### Event DETAILS ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Событие</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down @if(isset($dataTypeContent->id)) panel-collapsed @endif" data-toggle="panel-collapse" aria-hidden="true"></a>
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body" @if(isset($dataTypeContent->id))style="display:none"@endif>

                          @php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $exclude = ['slug'];
                            @endphp

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
                            <div class="form-group">
                                <label for="slug">{{ __('voyager::post.slug') }}</label>
                                @include('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'slug',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'slug')
                                ])
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="slug"
                                    data-slug-origin="name"
                                    @if(isset($dataTypeContent->slug)){{'readonly'}}@endif
                                    value="@if(isset($dataTypeContent->slug)){{ $dataTypeContent->slug }}@endif">
                            </div>

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
    <div class="modal modal-danger fade" tabindex="-1" id="delete_schedule_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> Вы действительно желаете удалить пункт программы?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('voyager.schedule.index') }}" id="delete_schedule_form" method="POST">
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
      <div class="modal modal-danger fade" tabindex="-1" id="delete_person_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> Вы действительно желаете удалить персону?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('voyager.event-persons.index') }}" id="delete_person_form" method="POST">
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
@endif

@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

        $('#schedule_list .delete').on('click', function (e) {
                $('#delete_schedule_form')[0].action = $(this).prop('href');
                $('#delete_schedule_modal').modal('show');
                e.preventDefault();
                return false;
            });
        $('#persons_list .delete').on('click', function (e) {
                $('#delete_person_form')[0].action = $(this).prop('href');
                $('#delete_person_modal').modal('show');
                e.preventDefault();
                return false;
            });

        @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
        @endif
        });
    </script>
@stop

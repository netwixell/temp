@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', is_null($dataTypeContent->getKey()) ? 'Персона' : 'Изменение персоны' )

@section('page_header')

@stop

@section('content')
  <div class="page-content edit-add container-fluid">
    <!-- form start -->
    <form role="form"
            class="form-edit-add"
            action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
            method="POST" enctype="multipart/form-data">
    <!-- PUT Method if we are editing -->
    @if(!is_null($dataTypeContent->getKey()))
        {{ method_field("PUT") }}
    @endif
    <!-- CSRF TOKEN -->
    {{ csrf_field() }}

      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-bordered panel-transparent">
            <div class="panel-heading">
                <h3 class="panel-title">Персона</h3>
                <div class="panel-actions" style="right:5px">
                  @include('voyager::multilingual.language-selector')
                </div>
            </div>
            <div class="panel-body">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Adding / Editing -->
                @php
                    $dataTypeRows = $dataType->{(!is_null($dataTypeContent->getKey()) ? 'editRows' : 'addRows' )};

                    $exclude = ['image','created_at'];
                @endphp
                {{-- <div class="form-group">
                  <label for="name">Событие</label>
                  <p>
                  <a href="{{route('voyager.events.edit',$dataTypeContent->event_id)}}">{{$dataTypeContent->event->name}}</a>
                  </p>
                  <input type="hidden" name="event_id" value="{{$dataTypeContent->event_id}}">
                </div> --}}

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
            </div><!-- panel-body -->
          </div>{{--panel--}}
          <!-- ### CONTACTS ### -->
          @if(isset($dataTypeContent->id))
          <div class="panel">
              <div class="panel-heading">
                  <h3 class="panel-title">Контакты</h3>
                  <div class="panel-actions">
                      <a href="{{route('voyager.person-contacts.create',['person_id'=>$dataTypeContent->id])}}" class="panel-action btn btn-sm btn-info">
                            <i class="voyager-list-add"></i> <span class="hidden-xs hidden-sm">Добавить контакт</span>
                      </a>
                      <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                  </div>
              </div>
              <div class="panel-body">
                  <div class="dd">
                      <ol class="dd-list" id="contacts_list">
                          @foreach($dataTypeContent->contacts as $contact)
                          <li class="dd-item">
                            <div class="pull-right item_actions">
                                <a class="btn btn-sm btn-danger pull-right delete" data-id="{{$contact->id}}" href="{{route("voyager.person-contacts.destroy",['id'=>$contact->id])}}">
                                    <i class="voyager-trash"></i>
                                </a>
                                <a class="btn btn-sm btn-primary pull-right edit" data-id="{{$contact->id}}" href="{{route("voyager.person-contacts.edit",$contact->id)}}">
                                    <i class="voyager-edit"></i>
                                </a>
                            </div>
                            <div class="dd-handle">
                            <span>{{__('person_contacts.'.$contact->type)}}: <a href="{{$contact->value}}" target="_blank" rel="noopener">{{$contact->value}}</a></span>
                            </div>
                          </li>
                          @endforeach
                      </ol>
                    </div>
              </div>
          </div><!-- .panel -->
          @endif
        </div>
        <div class="col-md-4">
          <!-- ### IMAGE ### -->
          <div class="panel panel-bordered panel-info">
              <div class="panel-heading">
                  <h3 class="panel-title"><i class="icon wb-image"></i> Фотография</h3>
                  <div class="panel-actions">
                      <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                  </div>
              </div>
              <div class="panel-body">
                  @if(isset($dataTypeContent->image))
                      <p><img src="/storage/{{$dataTypeContent->image}}" style="width:100%" /></p>
                  @endif
                  <p><input type="file" name="image"></p>
              </div>
          </div>
        </div>{{-- .col-md-4 --}}
      </div>
      {{-- .row --}}
      <button type="submit" class="btn btn-primary save pull-right">{{ __('voyager::generic.save') }}</button>
    </form>
  </div>
  @if(isset($dataTypeContent->id))
    <div class="modal modal-danger fade" tabindex="-1" id="delete_contact_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> Вы действительно желаете удалить контакт персоны?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('voyager.person-contacts.index') }}" id="delete_contact_form" method="POST">
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
            $('.toggleswitch').bootstrapToggle();

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif

            $('[data-toggle="tooltip"]').tooltip();


            $('#contacts_list .delete').on('click', function (e) {
                $('#delete_contact_form')[0].action = $(this).prop('href');
                $('#delete_contact_modal').modal('show');
                e.preventDefault();
                return false;
            });
        });
    </script>
@stop

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', is_null($dataTypeContent->getKey()) ? 'Команда' : 'Изменение команды' )

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
                <h3 class="panel-title">Команда
                @if(isset($dataTypeContent->id))
                <small>{{$dataTypeContent->event->name}}</small>
                @endif
                </h3>
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

                    $exclude = ['event_id','contact_name','phone','email', 'status', 'badge', 'notice', 'created_at', 'updated_at'];

                    if($dataTypeContent->id){
                      $exclude[]= 'team_belongsto_event_relationship';
                    }
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

                <div class="form-group" >
                  <label for="notice">Заметка</label>
                  <a href="#" id="show_notice"><i class="voyager-eye"></i> Показать</a>
                  <div class="hidden" id="notice_elm">
                    <textarea class="form-control richTextBox" name="notice" id="richtextnotice">{{$dataTypeContent->notice}}</textarea>
                  </div>
                </div>
            </div><!-- panel-body -->
          </div>{{--panel--}}
        </div>

        <div class="col-md-4">
          @if(isset($dataTypeContent->id))
          <!-- ### Contacts ### -->
          <div class="panel panel-bordered panel-info">
              <div class="panel-heading">
                  <h3 class="panel-title"><i class="icon wb-image"></i> Контакты</h3>
                  <div class="panel-actions">
                      <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                  </div>
              </div>
              <div class="panel-body">
                 <div class="form-group">
                    <dl>
                      <dt>Телефон</dt>
                      <dd><a href="tel:+{{$dataTypeContent->phone}}">{{phone_format($dataTypeContent->phone)}}</a>, {{$dataTypeContent->contact_name}}</dd>
                    </dl>
                    <dl>
                      <dt>Почта</dt>
                      <dd><a href="mailto:{{$dataTypeContent->email}}">{{$dataTypeContent->email}}</a></dd>
                    </dl>
                    <input type="hidden" name="contact_name" value="{{$dataTypeContent->contact_name}}">
                    <input type="hidden" name="phone" value="{{$dataTypeContent->phone}}">
                    <input type="hidden" name="email" value="{{$dataTypeContent->email}}">
                  </div>
              </div>
          </div>
          @endif
          <!-- ### Data ### -->
          <div class="panel panel-bordered panel-info">
              <div class="panel-body">
                  <div class="form-group">
                    <label for="status">Статус</label>
                    <select class="form-control" name="status">
                        <option value="NEW"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'NEW') selected="selected"@endif>Новая</option>
                        <option value="ACCEPTED"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'ACCEPTED') selected="selected"@endif>Ждет оплаты</option>
                        <option value="PAID"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PAID') selected="selected"@endif>Активна</option>
                        <option value="EXPELLED"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'EXPELLED') selected="selected"@endif>Исключена</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="badge">Бейдж</label>
                    <select class="form-control" name="badge">
                        <option value="">Не задано</option>
                        @foreach($dataTypeContent::$badges as $badge)
                        <option value="{{$badge}}"@if(isset($dataTypeContent->badge) && $dataTypeContent->badge == $badge) selected="selected"@endif>{{__('teams.'.$badge)}}</option>
                        @endforeach
                    </select>
                  </div>
              </div>
          </div>
        </div>{{-- .col-md-4 --}}

      </div>
      {{-- .row --}}
      <button type="submit" class="btn btn-primary save pull-right">{{ __('voyager::generic.save') }}</button>
    </form>

     <iframe id="form_target" name="form_target" style="display:none"></iframe>
      <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
              enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
          <input name="image" id="upload_file" type="file"
                    onchange="$('#my_form').submit();this.value='';">
          <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
          {{ csrf_field() }}
      </form>
  </div>


<div class="modal fade modal-danger" id="confirm_delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
            </div>

            <div class="modal-body">
                <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete File Modal -->


@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', function (e) {
                e.preventDefault();
                $image = $(this).siblings('img');

                params = {
                    slug:   '{{ $dataType->slug }}',
                    image:  $image.data('image'),
                    id:     $image.data('id'),
                    field:  $image.parent().data('field-name'),
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text($image.data('image'));
                $('#confirm_delete_modal').modal('show');
            });

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $image.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing image.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });


            $('#show_notice').click(function(e){
              e.preventDefault();
              $('#notice_elm').toggleClass('hidden');
              return false;
            });

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif

            $('[data-toggle="tooltip"]').tooltip();

        });
    </script>
@stop

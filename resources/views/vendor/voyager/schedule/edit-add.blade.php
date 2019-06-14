@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', is_null($dataTypeContent->getKey()) ? 'Пункт программы' : 'Изменение пункта программы' )

@section('page_header')

@stop

@section('content')

    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-8">

                <div class="panel panel-bordered panel-transparent">

                  <div class="panel-heading">
                      <h3 class="panel-title">Пункт программы</h3>
                      <div class="panel-actions" style="right:5px">
                        @include('voyager::multilingual.language-selector')
                      </div>
                  </div>
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

                                $exclude = ['description','schedule_belongsto_event_relationship'];
                            @endphp
                            <div class="form-group">
                              <label for="name">Событие</label>
                              <p>
                              <a href="{{route('voyager.events.edit',$dataTypeContent->event_id)}}">{{$dataTypeContent->event->name}}</a>
                              </p>
                              <input type="hidden" name="event_id" value="{{$dataTypeContent->event_id}}">
                            </div>

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
                              <label for="name">Описание</label>
                              <span class="language-label js-language-label"></span>
                              <a href="#" id="show_description"><i class="voyager-eye"></i> Показать</a>
                              <div class="hidden" id="description_elm">
                                <input type="hidden" data-i18n="true" name="description_i18n" id="description_i18n"
                                      value="{{ get_field_translations($dataTypeContent, 'description') }}">
                                <textarea  class="form-control richTextBox" name="description" id="richtextdescription"></textarea>
                              </div>
                           </div>



                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save pull-right">{{ __('voyager::generic.save') }}</button>
                            <div class="clearfix"></div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            //$('.toggleswitch').bootstrapToggle();

            $('#show_description').click(function(e){
              e.preventDefault();
              $('#description_elm').toggleClass('hidden');
              return false;
            })

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop

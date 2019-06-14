@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', is_null($dataTypeContent->getKey()) ? 'Контакт персоны' : 'Изменение контакта' )

@section('page_header')

@stop

@section('content')

    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-8">

                <div class="panel panel-bordered panel-transparent">

                  <div class="panel-heading">
                      <h3 class="panel-title">Контакт персоны</h3>
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

                                $exclude = ['person_id','person_contact_belongsto_person_relationship'];
                            @endphp
                            <div class="form-group">
                              <label for="name">Персона</label>
                              <p>
                              <a href="{{route('voyager.events.edit',$dataTypeContent->person_id)}}">{{$dataTypeContent->person->name}}</a>
                              </p>
                              <input type="hidden" name="person_id" value="{{$dataTypeContent->person_id}}">
                            </div>

                            <div class="form-group">
                              <label for="type">Тип</label>
                              <select class="form-control select2" name="type">
                                @foreach($dataTypeContent::$types as $type)
                                    <option value="{{ $type }}" @if($type == $dataTypeContent->type){{ 'selected="selected"' }}@endif>{{ __('person_contacts.'.$type) }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="value">Ссылка</label>
                              <input required type="url" class="form-control" name="value" placeholder="Ссылка" value="{{$dataTypeContent->value}}" list="defaultURLs">

                              <datalist id="defaultURLs">
                                <option value="https://www.facebook.com/" label="Facebook">
                                <option value="https://www.instagram.com/" label="Instagram">
                                <option value="https://twitter.com/" label="Twitter">
                                <option value="https://www.youtube.com/" label="Youtube">
                              </datalist>
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
            $('.toggleswitch').bootstrapToggle();

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop

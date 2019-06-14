@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', is_null($dataTypeContent->getKey()) ? 'Блок страницы' : 'Изменение блока' )

@section('page_header')

@stop

@section('content')
@php
  $is_admin=Auth::user()->hasRole('admin');
@endphp
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-8">

                <div class="panel panel-bordered panel-transparent">

                  <div class="panel-heading">
                      <h3 class="panel-title">Блок страницы</h3>
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

                                $exclude = ['title','md'];
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
                                        <div class="form-group @if($row->type == 'hidden' || !$is_admin) hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
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
                            <label for="name">Заголовок</label>
                            <span class="language-label js-language-label"></span>
                            <input type="hidden" data-i18n="true" name="title_i18n" id="title_i18n" value="{{ get_field_translations($dataTypeContent, 'title') }}">
                            <input required type="text" class="form-control" name="title" value="{{$dataTypeContent->title}}">
                          </div>
                          <div class="form-group">
                            <label for="md">Содержимое <span class="language-label js-language-label"></span></label>
                            @include('voyager::multilingual.input-hidden', [
                              '_field_name'  => 'md',
                              '_field_trans' => get_field_translations($dataTypeContent, 'md')
                            ])
                            <textarea class="form-control" name="md" id="markdown">@if(isset($dataTypeContent->md)){{ old('md', $dataTypeContent->md) }}@else{{ old('md') }}@endif</textarea>
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

  var markdown = document.getElementById("markdown");

  var simplemde = new SimpleMDE({
    element: markdown,
    forceSync: true,
    spellChecker: false,
    promptURLs: false,


    toolbar: [
      {
        name: "bold",
        action: SimpleMDE.toggleBold,
        className: "fa fa-bold",
        title: "Жирный",
        default: true
      },
      {
        name: "italic",
        action: SimpleMDE.toggleItalic,
        className: "fa fa-italic",
        title: "Курсив",
        default: true
      },
      {
        name: "strikethrough",
        action: SimpleMDE.toggleStrikethrough,
        className: "fa fa-strikethrough",
        title: "Перечеркнутый"
      },
      {
        name: "heading-bigger",
        action: SimpleMDE.toggleHeadingBigger,
        className: "fa fa-header",
        title: "Подзаголовок"
      },
      "|",
      {
        name: "quote",
        action: SimpleMDE.toggleBlockquote,
        className: "fa fa-quote-left",
        title: "Цитата",
        default: true
      },
      {
        name: "unordered-list",
        action: SimpleMDE.toggleUnorderedList,
        className: "fa fa-list-ul",
        title: "Ненумерованный список",
        default: true
      },
      {
        name: "ordered-list",
        action: SimpleMDE.toggleOrderedList,
        className: "fa fa-list-ol",
        title: "Нумерованный список",
        default: true
      },
      "|",
      {
        name: "link",
        action: SimpleMDE.drawLink,
        className: "fa fa-link",
        title: "Ссылка",
        default: true
      },
      "|",
      {
        name: "preview",
        action: SimpleMDE.togglePreview,
        className: "fa fa-eye no-disable",
        title: "Toggle Preview",
        default: true
      },
      {
        name: "side-by-side",
        action: SimpleMDE.toggleSideBySide,
        className: "fa fa-columns no-disable no-mobile",
        title: "Toggle Side by Side",
        default: true
      },
      {
        name: "fullscreen",
        action: SimpleMDE.toggleFullScreen,
        className: "fa fa-arrows-alt no-disable no-mobile",
        title: "Toggle Fullscreen",
        default: true
      },
      "|",
      {
        name: "guide",
        action: "https://simplemde.com/markdown-guide",
        className: "fa fa-question-circle",
        title: "Markdown Guide",
        default: true
      },
      "|",
      {
        name: "undo",
        action: SimpleMDE.undo,
        className: "fa fa-undo no-disable",
        title: "Undo"
      },
      {
        name: "redo",
        action: SimpleMDE.redo,
        className: "fa fa-repeat no-disable",
        title: "Redo"
      }
    ]
    });


  @if ($isModelTranslatable)
  $('.side-body').multilingual({"editing": true});

  $('.language-selector:first input').change(function(e){

      var lang = this.id;

      markdown.textContent = markdown.value;

      simplemde.value(markdown.value);

  });
  @endif

  $('[data-toggle="tooltip"]').tooltip();
});
</script>
@stop

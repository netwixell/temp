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
        <form class="form-edit-add" role="form" action="@if(isset($dataTypeContent->id)){{ route('voyager.posts.update', $dataTypeContent->id) }}@else{{ route('voyager.posts.store') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> {{ __('voyager::post.title') }}
                                <span class="panel-desc"> {{ __('voyager::post.title_sub') }}</span>
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'title',
                                '_field_trans' => get_field_translations($dataTypeContent, 'title')
                            ])
                            <input type="text" class="form-control" id="title" name="title" placeholder="{{ __('voyager::generic.title') }}" value="@if(isset($dataTypeContent->title)){{ $dataTypeContent->title }}@endif">
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Новость</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        @php
                            // $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                            // $row = $dataTypeRows->where('field', 'body')->first();
                        @endphp

                        <div class="panel-body">
                            {{-- <span class="language-label js-language-label"></span> --}}
                        {{-- <label for="body">Где взять ссылку на изображение? <a href="{{route('voyager.media.index')}}">Галерея</a> → Загрузка → Скопировать ссылку из свойств файла</label> --}}
                            {{-- {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!} --}}
                            {{-- <input type="hidden" data-i18n="true" name="body_i18n" id="body_i18n"
                                      value="{{ get_field_translations($dataTypeContent, 'body') }}"> --}}
                            @include('voyager::multilingual.input-hidden', [
                              '_field_name'  => 'body',
                              '_field_trans' => get_field_translations($dataTypeContent, 'body')
                            ])
                            <textarea class="form-control" name="body" id="markdownbody">@if(isset($dataTypeContent->body)){{ old('body', $dataTypeContent->body) }}@else{{ old('body') }}@endif</textarea>

                        </div>
                    </div><!-- .panel -->


                    {{-- <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Детали</h3>
                            <div class="panel-actions">
                              <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $exclude = ['title', 'excerpt', 'slug', 'views', 'status', 'author_id', 'featured', 'image', 'meta_description', 'meta_keywords', 'seo_title'];
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
                        </div>
                    </div> --}}

                </div>
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> {{ __('voyager::post.details') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="slug">{{ __('voyager::post.slug') }}</label>
                                @include('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'slug',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'slug')
                                ])
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder=""
                                    {{!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}}
                                    value="@if(isset($dataTypeContent->slug)){{ $dataTypeContent->slug }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="status">{{ __('voyager::post.status') }}</label>
                                <select class="form-control" name="status">
                                    <option value="PUBLISHED"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PUBLISHED') selected="selected"@endif>{{ __('voyager::post.status_published') }}</option>
                                    <option value="DRAFT"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'DRAFT') selected="selected"@endif>{{ __('voyager::post.status_draft') }}</option>
                                    <option value="PENDING"@if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PENDING') selected="selected"@endif>{{ __('voyager::post.status_pending') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> {{ __('voyager::post.image') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(isset($dataTypeContent->image))
                                <img src="{{ filter_var($dataTypeContent->image, FILTER_VALIDATE_URL) ? $dataTypeContent->image : Voyager::image( $dataTypeContent->image ) }}" style="width:100%" />
                            @endif
                            <input type="file" name="image">
                        </div>
                    </div>

                    <!-- ### SEO CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> {{ __('voyager::post.seo_content') }}</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="meta_description">{{ __('voyager::post.meta_description') }}</label>
                                @include('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'meta_description',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'meta_description')
                                ])
                                <textarea class="form-control" name="meta_description">@if(isset($dataTypeContent->meta_description)){{ $dataTypeContent->meta_description }}@endif</textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">{{ __('voyager::post.meta_keywords') }}</label>
                                @include('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'meta_keywords',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'meta_keywords')
                                ])
                                <textarea class="form-control" name="meta_keywords">@if(isset($dataTypeContent->meta_keywords)){{ $dataTypeContent->meta_keywords }}@endif</textarea>
                            </div>
                            <div class="form-group">
                                <label for="seo_title">{{ __('voyager::post.seo_title') }}</label>
                                @include('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'seo_title',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'seo_title')
                                ])
                                <input type="text" class="form-control" name="seo_title" placeholder="SEO Title" value="@if(isset($dataTypeContent->seo_title)){{ $dataTypeContent->seo_title }}@endif">
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
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

            var simplemde = new SimpleMDE({
              element: document.getElementById("markdownbody"),
              forceSync: true,
              insertTexts: {
                horizontalRule: ["", "\n\n-----\n\n"],
                image: ["![Вставьте подпись к картинке сюда](Загрузите картинку в Галерею, скопируйте («Click Here» в свойствах файла) и вставьте ссылку сюда, вместо этого текста", ")"],
                link: ["[", "](http://)"],
                table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
              },
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
                  name: "heading-2",
                  action: SimpleMDE.toggleHeading2,
                  className: "fa fa-header fa-header-x fa-header-2",
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
                // {
                //   name: "clean-block",
                //   action: SimpleMDE.cleanBlock,
                //   className: "fa fa-eraser fa-clean-block",
                //   title: "Clean block"
                // },
                "|",
                {
                  name: "link",
                  action: SimpleMDE.drawLink,
                  className: "fa fa-link",
                  title: "Ссылка",
                  default: true
                },
                {
                  name: "image",
                  action: SimpleMDE.drawImage,
                  className: "fa fa-picture-o",
                  title: "Загрузите картинку в Галерею, скопируйте («Click Here» в свойствах файла) и вставьте ссылку",
                  default: true
                },
                // {
                //   name: "table",
                //   action: SimpleMDE.drawTable,
                //   className: "fa fa-table",
                //   title: "Insert Table"
                // },
                // {
                //   name: "horizontal-rule",
                //   action: SimpleMDE.drawHorizontalRule,
                //   className: "fa fa-minus",
                //   title: "Insert Horizontal Line"
                // },
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


              // {
              //   name: "custom",
              //   action: function customFunction(editor){

              //     // Add your own code
              //   },
              //   className: "fa fa-star",
              //   title: "Custom Button",
              // },
              // "|", // Separator
            ],
              spellChecker: false,
              promptURLs: false,
              });

        @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
        @endif
        });
    </script>
@stop

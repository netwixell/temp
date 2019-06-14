@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', is_null($dataTypeContent->getKey()) ? 'Добавить к счету' : 'Изменение позиции счета' )

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ (is_null($dataTypeContent->getKey()) ? 'Добавить к счету' : 'Изменение позиции счета') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-4">

                <div class="panel panel-bordered">
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
                            {{-- @php
                                $dataTypeRows = $dataType->{(!is_null($dataTypeContent->getKey()) ? 'editRows' : 'addRows' )};
                            @endphp --}}

                                <input type="hidden" name="order_id" value="{{$dataTypeContent->order_id}}"/>
                                <input type="hidden" name="priceable_type" value="{{$dataTypeContent->priceable_type}}"/>

                                <div class="form-group">
                                <label for="priceable_id">Элемент заказа</label>
                                  @if($options->count()>0)
                                  <select class="form-control" name="priceable_id">
                                    @foreach($options as $option)
                                      <option value="{{$option->id}}"
                                      @if($dataTypeContent->priceable_id == $option->id) selected="selected"@endif
                                      @if(isset($option->bill_price))data-price="{{price_uah($option->bill_price)}}"
                                      @endif>{{ $option->bill_title }} @if(isset($option->remain)) {{'x'.$option->remain}} @endif</option>
                                    @endforeach
                                  </select>
                                  @else
                                   <p>Нет в наличии</p>
                                  @endif
                                </div>
                                <div class="form-group">
                                <label for="price">Цена</label>
                                <h4 id="price">&ndash;</h4>
                                </div>

                            {{-- @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $options = json_decode($row->details);
                                    $display_options = isset($options->display) ? $options->display : NULL;
                                @endphp
                                @if ($options && isset($options->legend) && isset($options->legend->text))
                                    <legend class="text-{{$options->legend->align or 'center'}}" style="background-color: {{$options->legend->bgcolor or '#f0f0f0'}};padding: 5px;">{{$options->legend->text}}</legend>
                                @endif
                                @if ($options && isset($options->formfields_custom))
                                    @include('voyager::formfields.custom.' . $options->formfields_custom)
                                @else
                                    <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width or 12 }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
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
                            @endforeach --}}

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        </div>
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
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>

      function setPrice($elem,price){
        $elem.text(price || '—');
      }

        $('document').ready(function () {
            //$('.toggleswitch').bootstrapToggle();
            var $priceable_id=$('select[name="priceable_id"]'),
              $price=$('#price');

             setPrice($price, $priceable_id.find(":selected").data('price'));

            $priceable_id.change(function(){
              var price=$(this).find(":selected").data('price');
                setPrice($price,price);
            });



            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop

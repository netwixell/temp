@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', is_null($dataTypeContent->getKey()) ? 'Ранняя пташка' : 'Изменение ранней пташки' )

@section('page_header')

@stop

@section('content')

    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-8">

                <div class="panel panel-bordered panel-transparent">

                  <div class="panel-heading">
                      <h3 class="panel-title">Ранняя пташка</h3>
                  </div>
                    <!-- form start -->
                    <form role="form"
                          name="earlyBird"
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
                                $original_price_ = $dataTypeContent->ticket->getOriginal('price');

                                $original_price = is_null($original_price_) ? 0 : $original_price_;
                                $locale_original_price = price_uah($original_price);

                                $dataTypeRows = $dataType->{(!is_null($dataTypeContent->getKey()) ? 'editRows' : 'addRows' )};

                                $exclude = ['price','early_bird_belongsto_ticket_relationship'];
                            @endphp
                            <div class="form-group">
                              <label for="name">Билет</label>
                              <p>
                              <a href="{{route('voyager.tickets.edit',$dataTypeContent->ticket_id)}}">{{$dataTypeContent->ticket->title}}</a>
                              </p>
                              <input type="hidden" name="ticket_id" value="{{$dataTypeContent->ticket_id}}">
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

                            <div class="form-group">
                                <label for="price">Цена</label>
                                <div class="input-group">
                                    <span class="input-group-addon">₴</span>
                                    <input type="number" step="1" class="form-control"
                                      id="price" name="price"
                                      max="{{($original_price-1)}}"
                                      data-max-price="{{$original_price}}"
                                      value="{{$dataTypeContent->price}}"
                                      >
                                    <span class="input-group-addon"> → {{$locale_original_price}}</span>
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
          var form = document.forms.earlyBird,
            $checkbox = $(form.elements.monthly_increase),
            $inputPrice = $(form.elements.price),

            $inputDateFrom = $(form.elements.date_from),
            $inputDateTo = $(form.elements.date_to);

            function showMonthlyIncrease(){

              var diffInMonths, countIncreases, monthlyIncrease;

                if(!$checkbox.prop('checked')) return false;

                var price = Number( $inputPrice.val() );
                var maxPrice = Number( $inputPrice.data('max-price') );
                var dateFrom = $inputDateFrom.val();
                var dateTo = $inputDateTo.val();

                if(!dateFrom || !dateTo || !price || !maxPrice || dateFrom === '' || dateTo === '') return false;

                dateFrom = new Date(dateFrom).getTime();
                dateTo = new Date(dateTo).getTime();

                if(dateTo < dateFrom || maxPrice < price) return false;

                diffInMonths =(dateTo - dateFrom) / 1000;
                diffInMonths /= (60 * 60 * 24 * 7 * 4);

                countIncreases = Math.abs(Math.round(diffInMonths));

                monthlyIncrease = Math.round((maxPrice - price) / countIncreases );

                // $checkbox.data('on', 'Размер повышения: '+monthlyIncrease);

                $checkbox.bootstrapToggle('destroy');

                $checkbox.bootstrapToggle({
                  on:'↑ '+monthlyIncrease+' ₴ x '+ countIncreases,
                  off: 'Нет',
                  onstyle: 'success'
                });

                // console.log(countIncreases , monthlyIncrease);
            }

            $checkbox.bootstrapToggle();

            showMonthlyIncrease();

            $checkbox
              .add($inputPrice)
              .add($inputDateFrom)
              .add($inputDateTo)
              .on('change', showMonthlyIncrease);


            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop

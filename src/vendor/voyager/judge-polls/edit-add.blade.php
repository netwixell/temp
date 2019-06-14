@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', 'Судейское голосование')

@section('page_header')

@stop

@section('content')

    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered panel-transparent">

                  <div class="panel-heading">
                    <h3 class="panel-title">{{$poll->name}}
                    <span class="panel-desc">{{$poll->begin_at->format('d.m.Y')}} - {{$poll->end_at->format('d.m.Y')}}</span>
                    </h3>
                  </div>
                    <!-- form start -->
                    <form role="form"
                            class="poll-form"
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

                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th class="text-center col-md-4">Команда</th>
                                @foreach($criteria as $criterion)
                                <th class="text-center col-md-2">{{__('judge_votes.'.$criterion)}}</th>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($teams as $team)
                              <tr>
                                <th scope="row" style="font-weight: 600;">{{$team->name}}</th>
                                @foreach($criteria as $criterion)
                                <td align="center">
                                  <input type="number" min="1" max="10" step="1" class="form-control" name="score[{{$team->id}}][{{$criterion}}]" value="" required>
                                </td>
                                @endforeach
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div><!-- panel-body-->

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


            $('.poll-form input[type="number"]')
            .on('change', function(e){
              var $input = $(this);

              localStorage.setItem($input.prop('name'), $input.val());

            })
            .on('keyup', function(e){
              var $input = $(this);
              var val = parseInt( $input.val() );
              if(val < 1 || val > 10) {
                $(this).val( Math.min(Math.max(val, 1), 10) );
              }

            })
            .each(function(){
              var $input = $(this);
              var memory = localStorage.getItem($input.prop('name'));
              if(memory){
                $input.val(memory);
              }
            });

            $('.poll-form').on('submit', function(){
              $(this).find('input[type="number"]').each(function(){
                var $input = $(this);
                if($input.val()){
                  localStorage.removeItem($input.prop('name'));
                }

              })
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop

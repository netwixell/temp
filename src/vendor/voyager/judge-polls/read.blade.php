@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->display_name_singular)

@section('page_header')
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <h1 class="panel-title">{{$dataTypeContent->poll->name}}
              <span class="panel-desc">{{$dataTypeContent->poll->begin_at->format('d.m.Y')}} - {{$dataTypeContent->poll->end_at->format('d.m.Y')}}</span>
              <span class="panel-desc">{{$dataTypeContent->user->name}}. Поток: {{$dataTypeContent->flow->name}}</span>
              <div class="panel-actions">
                @can('delete', $dataTypeContent)
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
                @endcan
                <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
                    <span class="glyphicon glyphicon-list"></span>&nbsp;
                    {{ __('voyager::generic.return_to_list') }}
                </a>
              </div>
              </h1>
            </div>
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
                @foreach($scoreList as $teamName => $scores)
                <tr>
                  <th scope="row" style="font-weight: 600;">{{$teamName}}</th>
                  <?php $scoresByCriteria = $scores->pluck('score', 'criterion')->toArray(); ?>
                  @foreach($criteria as $criterion)
                  <td align="center">
                    {{ $scoresByCriteria[$criterion] ?: '-' }}
                  </td>
                  @endforeach
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->display_name_singular) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->display_name_singular) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    @if ($isModelTranslatable)
    <script>
        $(document).ready(function () {
            $('.side-body').multilingual();
        });
    </script>
    <script src="{{ voyager_asset('js/multilingual.js') }}"></script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) { // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');
            console.log(form.action);

            $('#delete_modal').modal('show');
        });

    </script>
@stop

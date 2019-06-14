@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">

      <div class="row">
          <div class="col-md-12" style="margin-bottom:0px">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">Заказы</h3>
                <div class="panel-actions">
                  <span class="badge">{{($totalCount - $canceledCount)}} ({{$totalCount}})</span>
                </div>
              </div>
              <div class="row">
               <div class="col-md-4">
                 <div class="col-md-offset-1">
                  <h4>Приобретенные билеты</h4>
                  <div>
                    <h4>
                    @foreach($countByTickets as $item)
                      <span class="badge badge-info" style="border-radius:2px">{{$item->flow}}&nbsp;&ndash;&nbsp;{{$item->count.'/'.$item->qty}}</span>
                    @endforeach
                    </h4>
                  </div>
                 </div>
               </div>
               <div class="col-md-4">
                <div class="col-md-offset-1">
                  <h4>Выплачено</h4>
                  <h3 class="text-info">{{price_uah( $calculation['total_paidout'] )}}</h3>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="col-md-offset-1">
                  <h4>Долг по рассрочке</h4>
                  <h3 class="text-info">{{price_uah( (float)$calculation['installment_cost'] - (float)$calculation['installment_paidout'] )}}</h3>
                 </div>
               </div>
              </div>
            </div>
          </div>
      </div>

        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input" style="text-overflow:none">
                                    <select id="search_key" name="key">
                                        @php
                                        $search_fields=[
                                          ['name'=>'№ Заказа    ','key'=>'number'],
                                          ['name'=>'Телефон     ','key'=>'phone'],
                                          ['name'=>'Имя         ','key'=>'name'],
                                          ['name'=>'Город       ','key'=>'city'],
                                          ['name'=>'Стоимость    ','key'=>'total_price'],
                                          ['name'=>'E-mail     ','key'=>'email'],
                                          ['name'=>'Билет      ','key'=>'ticket_id'],
                                          ['name'=>'Продавец   ','key'=>'seller_id'],
                                        ];
                                        @endphp
                                        @foreach($search_fields as $field)
                                                <option value="{{ $field['key'] }}" @if($search->key == $field['key']){{ 'selected' }}@endif>{{$field['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="s" value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        @foreach($dataType->browseRows as $row)
                                        <th>
                                            @if ($isServerSide)
                                                <a href="{{ $row->sortByUrl() }}">
                                            @endif
                                            {{ $row->display_name }}
                                            @if ($isServerSide)
                                                @if ($row->isCurrentSortField())
                                                    @if (!isset($_GET['sort_order']) || $_GET['sort_order'] == 'asc')
                                                        <i class="voyager-angle-up pull-right"></i>
                                                    @else
                                                        <i class="voyager-angle-down pull-right"></i>
                                                    @endif
                                                @endif
                                                </a>
                                            @endif
                                        </th>
                                        @endforeach
                                        <th class="actions"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $label_types=[
                                    'CASH'=>'label-default',
                                    'INSTALLMENTS'=>'label-primary'
                                  ];

                                  $unreads = DB::table('userables')->select('userable_id')->where('user_id', Auth::id())->where('userable_type', 'order')->pluck('userable_id');

                                  $unreadIds = $unreads->toArray();
                                  ?>
                                    @foreach($dataTypeContent as $data)
                                    <tr @if(in_array($data->id, $unreadIds))class="warning" data-id="{{$data->id}}"@endif>
                                        @foreach($dataType->browseRows as $row)
                                            <td>
                                                <?php $options = json_decode($row->details); ?>

                                                @if($row->type == 'image')
                                                    <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                {{-- @elseif($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship', ['view' => 'browse']) --}}
                                                @elseif($row->type == 'select_multiple')
                                                    @if(property_exists($options, 'relationship'))

                                                        @foreach($data->{$row->field} as $item)
                                                            @if($item->{$row->field . '_page_slug'})
                                                            <a href="{{ $item->{$row->field . '_page_slug'} }}">{{ $item->{$row->field} }}</a>@if(!$loop->last), @endif
                                                            @else
                                                            {{ $item->{$row->field} }}
                                                            @endif
                                                        @endforeach

                                                        {{-- $data->{$row->field}->implode($options->relationship->label, ', ') --}}
                                                    @elseif(property_exists($options, 'options'))
                                                        @foreach($data->{$row->field} as $item)
                                                         {{ $options->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                        @endforeach
                                                    @endif

                                                @elseif($row->type == 'select_dropdown' && property_exists($options, 'options'))
                                                    @if($data->{$row->field . '_page_slug'})
                                                        <a href="{{ $data->{$row->field . '_page_slug'} }}">{!! $options->options->{$data->{$row->field}} !!}</a>
                                                    {{-- Custom status --}}
                                                    @elseif($row->field=='status')
                                                      @include('voyager::components.order-status',['data'=>$data])
                                                     {{-- end custom status --}}
                                                    @else
                                                        {!! $options->options->{$data->{$row->field}} !!}
                                                    @endif
                                                @elseif($row->type == 'select_dropdown' && $data->{$row->field . '_page_slug'})
                                                    <a href="{{ $data->{$row->field . '_page_slug'} }}">{{ $data->{$row->field} }}</a>
                                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                {{ $options && property_exists($options, 'format') ? \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($options->format) : $data->{$row->field} }}
                                                @elseif($row->type == 'checkbox')
                                                    @if($options && property_exists($options, 'on') && property_exists($options, 'off'))
                                                        @if($data->{$row->field})
                                                        <span class="label label-info">{{ $options->on }}</span>
                                                        @else
                                                        <span class="label label-primary">{{ $options->off }}</span>
                                                        @endif
                                                    @else
                                                    {{ $data->{$row->field} }}
                                                    @endif
                                                @elseif($row->type == 'color')
                                                    <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                @elseif($row->type == 'text')
                                                    @if($row->field == 'promocode')
                                                      @isset($data->seller)
                                                      <p>{{$data->promocode}}</p>
                                                      <a href="{{route('voyager.orders.index',['key' =>'seller_id', 's'=> $data->seller_id ] )}}">{{$data->seller->name}}</a>
                                                      @endisset
                                                    @else
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div class="readmore">{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                    @endif
                                                @elseif($row->type == 'text_area')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    {{ mb_strlen( $data->{$row->field} ) > 100 ? mb_substr($data->{$row->field}, 0, 100) . ' ...' : $data->{$row->field} }}
                                                @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    @if(json_decode($data->{$row->field}))
                                                        @foreach(json_decode($data->{$row->field}) as $file)
                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                {{ $file->original_name ?: '' }}
                                                            </a>
                                                            <br/>
                                                        @endforeach
                                                    @else
                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                            Download
                                                        </a>
                                                    @endif
                                                @elseif($row->type == 'rich_text_box')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div class="readmore">{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                @elseif($row->type == 'coordinates')
                                                    @include('voyager::partials.coordinates-static-image')
                                                @elseif($row->type == 'multiple_images')
                                                    @php $images = json_decode($data->{$row->field}); @endphp
                                                    @if($images)
                                                        @php $images = array_slice($images, 0, 3); @endphp
                                                        @foreach($images as $image)
                                                            <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @if($row->field=='id')
                                                      <div style="width:150px">
                                                        <h5><b>№{{ pretty_order_number($data->number) }}</b>, от <span>{{$data->name}}</span></h5>
                                                        <a href="tel:{{$data->phone}}" style="white-space:nowrap">{{phone_format($data->phone)}}</a>
                                                      </div>
                                                    @elseif($row->field=='total_price')
                                                      <p>
                                                      <h4 >{{ price_uah($data->{$row->field}) }}</h4>
                                                      <?php
                                                        $selected_key = (isset($data->payment_type) && !is_null(old('payment_type', $data->payment_type))) ? old('payment_type', $data->payment_type): old('payment_type');
                                                      ?>
                                                      @if($selected_key=='INSTALLMENTS')
                                                      <span class="label {{isset($label_types[$selected_key])?$label_types[$selected_key]:'label-default'}}">{{ __('orders.'.$selected_key) }}</span>
                                                      @endif
                                                      </p>

                                                    @elseif($row->field=='ticket_id')
                                                      @if(isset( $data->ticket) )
                                                      <a href="{{route('voyager.orders.index', ['key' =>'ticket_id', 's'=> $data->{$row->field} ]  )}}">{{$data->ticket->title}}</a>
                                                      @else
                                                      <span>Билет не найден</span>
                                                      @endif
                                                    @else
                                                      @include('voyager::multilingual.input-hidden-bread-browse')
                                                      <span>{{ $data->{$row->field} }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="no-sort no-click text-right" id="bread-actions">
                                            <a href="{{route('voyager.orders.edit',$data->id)}}" title="Перейти" class="btn btn-sm btn-info pull-right edit">
                                              <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm"></span>
                                            </a>
                                            {{-- <a href="{{route('voyager.orders.index',['bill_by_order'=>$data->id])}}" data-name="cards" class="btn btn-warning btn-sm show-bill">
                                              <i class="voyager-list"></i> Счет
                                            </a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                    's' => $search->value,
                                    'filter' => $search->filter,
                                    'key' => $search->key,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder
                                ])->links() }}
                            </div>
                        @endif
                    </div>
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
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Single bill modal --}}
    <div class="modal modal-warning fade" tabindex="-1" id="bill_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-list"></i> Счет</h4>
                </div>
                <div class="modal-body">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Custom status field form --}}

    {{-- Single update status modal --}}
    <div class="modal modal-warning fade" tabindex="-1" id="update_status_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="update_form" onsubmit="return blockSubmit(this);" method="POST">
                {{ method_field("PUT") }}
                {{ csrf_field() }}
                <input type="hidden" name="status" value="">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Причина отказа?</h4>
                </div>
                <div class="modal-body">
                  <textarea class="form-control" maxlength="65535" rows="5" placeholder="Оставьте комментарий с причиной отмены заказа..." name="notes" required></textarea>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btn_submit" class="btn btn-warning pull-right" value="Отправить">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>

              </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Custom status field form. --}}

@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
<link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script src="/admin/js/order-status.js"></script>
    <script>
      function blockSubmit(form) // Submit button clicked
      {
        form.btn_submit.disabled = true;
        return true;
      }

        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => [],
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [['searchable' =>  false, 'targets' => -1 ]],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
            });
        });

        //Custom update status

       $('.order-status').orderStatus({
         afterChange: function(result){

          if(result.order_id) $('tr[data-id='+result.order_id+']').removeClass('warning');

           var form = document.getElementById('update_form');
           form.btn_submit.disabled = false;
         }
       });
        //.

        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        })
        .on('click','.show-bill',function(e){
          e.preventDefault();
          var $btn = $(this).button('loading');
          var $modal=$('#bill_modal');

          $.ajax({
            url: $btn.attr('href'),
            type: 'GET',
          }).done(function(result){
            if(result.html){
              $modal.find('.modal-body').html(result.html);
              $modal.modal('show');
            }
            $btn.button('reset');
          });

          return false;
        });
    </script>
@stop

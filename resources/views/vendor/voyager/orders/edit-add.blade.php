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
        Заказ №{{pretty_order_number($dataTypeContent->number)}}
    </h1>
@stop

@section('content')
    <?php
    $is_new = ($dataTypeContent->status == $dataTypeContent::STATUS_NEW);
    $bill = $dataTypeContent->bill;
    ?>
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" name="order" action="@if(isset($dataTypeContent->id)){{ route('voyager.orders.update', $dataTypeContent->id) }}@else{{ route('voyager.orders.store') }}@endif" method="POST" enctype="multipart/form-data">
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
                               Детали оплаты
                            </h3>
                            <div class="panel-actions">

                            </div>
                        </div>
                        <div class="panel-body">

                        <?php $selected_value = (isset($dataTypeContent->payment_type) && !empty(old('payment_type', $dataTypeContent->payment_type))) ? old(
                                      'payment_type',
                                      $dataTypeContent->payment_type) : old('payment_type');

                         $payment_cash = $dataTypeContent::PAYMENT_CASH;
                         $payment_installments = $dataTypeContent::PAYMENT_INSTALLMENTS;
                         $default = $payment_cash;
                         $ticket_cost=$dataTypeContent->ticket_cost;
                         $total_price=$dataTypeContent->total_price;
                         $paid_out=$dataTypeContent->payments->sum('amount');

                         $total_price_uah = price_uah( $total_price );
                         $paid_out_uah= price_uah($paid_out);
                         ?>
                          <div class="row">
                            <div class="col-md-8">
                              <div class="form-group">
                                  @if($is_new)
                                  <ul class="radio">
                                    @if(isset($dataTypeContent::$payment_types))
                                            <li>
                                              <input type="radio" id="option-payment-type-cash"
                                                      name="payment_type"
                                                      value="{{  $payment_cash }}" @if($default ==  $payment_cash && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value ==  $payment_cash){{ 'checked' }}@endif>
                                                <label for="option-payment-type-cash">{{ __('orders.'. $payment_cash) }}</label>
                                                <div class="check"></div>
                                            </li>
                                            @php
                                              $model = app('App\Installment');
                                              $installment = $model::available()->first();
                                            @endphp

                                            @isset($installment)

                                              @php
                                                $installment_plan=installment_plan(
                                                              now(),
                                                              $installment->expires_at,
                                                              $total_price,
                                                              $installment->commission,
                                                              $installment->first_payment
                                                            );
                                              @endphp
                                              <li>
                                                  <input type="radio" id="option-payment-type-installments"
                                                        name="payment_type"
                                                        value="{{ $payment_installments }}" @if($default == $payment_installments && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value == $payment_installments){{ 'checked' }}@endif>
                                                  <label for="option-payment-type-installments">{{ __('orders.'.$payment_installments) }}</label>
                                                  <div class="check"></div>

                                                  <div class="col-md-offset-1" id="installment_plans" @if($selected_value != $payment_installments)style="display:none"@endif>
                                                      <input type="hidden" name="installment_id" id="option-installment-{{$installment->id}}" value="{{$installment->id}}">

                                                      <table class="table" style="color:#000; border:none">
                                                          <tr>
                                                              <td>Дата завершения оплаты</td>
                                                              <td>{{$installment->expires_at->format('j.m.Y')}}</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Количество платежей</td>
                                                            <td>{{$installment_plan['payments_count']}}</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Нулевой платеж</td>
                                                            <td>{{price_uah($installment_plan['first_payment'])}}</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Ежемесячный платеж</td>
                                                            <td>{{price_uah( $installment_plan['monthly_payment'] )}}</td>
                                                          </tr>
                                                      </table>
                                                  </div>
                                              </li>
                                            @endisset
                                    @endif
                                </ul>
                                @elseif(isset($dataTypeContent->confirmed_at)) {{-- order is confirmed --}}
                                  <p>Тип оплаты &ndash; {{__('orders.'.$selected_value)}}</p>
                                  @if($selected_value==$payment_installments)
                                    <?php
                                      // installment_plan($begin_date,$end_date,$total_price,$commission,$first_payment)
                                      $installment=$dataTypeContent->installment;
                                      $installment_plan=installment_plan(
                                                        $dataTypeContent->confirmed_at,
                                                        $installment->expires_at,
                                                        $total_price,
                                                        $installment->commission,
                                                        $installment->first_payment
                                                      );
                                    ?>
                                    <table class="table" style="color:#000; border:none">
                                      <tr>
                                        <td>Количество платежей</td>
                                        <td>{{$installment_plan['payments_count']}}</td>
                                      </tr>
                                      <tr>
                                        <td>Нулевой платеж</td>
                                        <td>{{price_uah($installment_plan['first_payment'])}}</td>
                                      </tr>
                                      <tr>
                                        <td>Ежемесячный платеж</td>
                                        <td>{{price_uah($installment_plan['monthly_payment'])}}</td>
                                      </tr>
                                    </table>
                                  @endif
                                @endif
                              </div>

                            </div>
                            <div class="col-md-4">
                              <table class="table" style="color:#000; border:none">
                                <tfoot>
                                  <tr>
                                  <th style="padding-left:0px;font-weight:600">Полная стоимость</th>
                                  <th style="font-weight:600">{{$total_price_uah}}</th>
                                  </tr>
                                </tfoot>
                                @foreach($bill as $option)
                                <tr>
                                  <td style="padding-left:0px">{{$option->priceable->bill_title}}</td>
                                  <td>@if($option->price > 0){{price_uah($option->price)}}@else — @endif</td>
                                </tr>
                                @endforeach
                              </table>

                              <p style="color:#000;">
                                <small>Реквизиты оплаты</small><br>
                                {{$dataTypeContent->card->name}}<br>
                                <span style="color:#000; font-weight:600">{{card_format($dataTypeContent->card->card_number)}}</h5>
                              </p>
                            </div>
                          </div>

                        </div>
                    </div>

                    <!-- ### Bill ### -->
                    @if($is_new)
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Счет <small>{{ $total_price_uah }} </small></h3>
                            <div class="panel-actions">
                                <a href="{{route('voyager.bills.create',['order_id'=>$dataTypeContent->id,'priceable_type'=>'ticket'])}}" class="panel-action btn btn-sm btn-warning">
                                     <i class="voyager-list-add"></i> <span class="hidden-xs hidden-sm">Добавить билет</span>
                                </a>
                                <a href="{{route('voyager.bills.create',['order_id'=>$dataTypeContent->id,'priceable_type'=>'option'])}}" class="panel-action btn btn-sm btn-info">
                                     <i class="voyager-list-add"></i> <span class="hidden-xs hidden-sm">Добавить опцию</span>
                                </a>
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        @php
                            $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                            $row = $dataTypeRows->where('field', 'body')->first();
                        @endphp

                        <div class="panel-body">
                            <div class="dd">
                                <ol class="dd-list" id="bill_list">
                                    @foreach($bill as $option)
                                    <li class="dd-item" data-id="{{$option->id}}">
                                        <div class="pull-right item_actions">
                                            <a class="btn btn-sm btn-danger pull-right delete" data-id="{{$option->id}}" href="{{route("voyager.bills.destroy",['id'=>$option->id])}}">
                                                <i class="voyager-trash"></i>  <span class="hidden-xs hidden-sm">Удалить</span>
                                            </a>
                                            @if($option->priceable_type!='discount')
                                            <a class="btn btn-sm btn-primary pull-right edit" data-id="{{$option->id}}" href="{{route("voyager.bills.edit",$option->id)}}">
                                                <i class="voyager-edit"></i>  <span class="hidden-xs hidden-sm">Редактировать</span>
                                            </a>
                                            @endif
                                        </div>
                                        <div class="dd-handle">
                                        <span>@if($option->price>0){{price_uah($option->price)}}@endif {{$option->priceable->bill_title}}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ol>
                              </div>
                        </div>
                    </div><!-- .panel -->
                    @endif
                    <!-- ### PAYMENTS ### -->
                    @if(isset($transactions))
                      <?php
                      $is_installment = ($dataTypeContent->payment_type == $payment_installments);
                      $transactions_count = count($transactions);
                      $payments_count = $dataTypeContent->payments->count();
                      ?>
                      <div class="panel">
                          <div class="panel-heading">
                              <h3 class="panel-title">Платежи
                              @if($is_installment)
                              <?php
                              $remain = $installment_plan['total_repaid'] - $paid_out;
                              $remain_uah = price_uah($remain);

                              // dd($installment_plan);
                               ?>
                              <small>Количество: {{ $payments_count }}/{{$transactions_count}}, Выплачено: {{$paid_out_uah}}, Осталось: {{$remain_uah}}</small>
                              @endif
                              </h3>
                              <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                              </div>
                          </div>
                          <?php $status_classes = ['','','text-warning','text-danger','text-success'] ?>
                          <table class="table table-condensed" id="pay_list">
                              <thead> <tr> <th width="130">Дата платежа</th> <th width="80">Сумма</th> <th>Статус</th> <th>Комментарий</th>  </tr> </thead>
                              <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                  <th scope="row"><p class="{{$status_classes[$transaction->status]}}" style="font-weight: 600;">{{$transaction->date->format('d.m.Y')}}</p></th>
                                  <td><p style="font-weight: 600;">{{price_uah($transaction->amount)}}</p></td>
                                  <td>
                                    @if($transaction->status>0)
                                      @if($transaction->status<4)
                                      <button type="button" class="btn btn-inverse pay_btn" @if($transaction->number == 1 || $transaction->number == $transactions_count)data-freeze="true"@endif data-amount="{{$transaction->amount}}" data-number="{{$transaction->number}}">Оплатить</button>
                                      @else
                                      <button type="button" class="btn btn-success" disabled><i class="glyphicon glyphicon-ok"></i> Оплачено</button>
                                      @endif
                                    @endif
                                  </td>
                                  <td>@if(!empty($transaction->notice))<p>{{$transaction->notice}}</p>@endif</td>
                                </tr>
                                @endforeach
                              </tbody>
                              @if($is_installment && $payments_count > 0 && $remain > $installment_plan['monthly_payment'])
                              <tfoot>
                                <tr>
                                  <td colspan="4">
                                  <button type="button" class="btn btn-inverse pay_btn" data-freeze="true" data-amount="{{$remain}}" data-number="{{$transaction->number+1}}">Выплатить всё {{$remain_uah}}</button>
                                  </td>
                                </tr>
                              </tfoot>
                              @endif
                          </table>
                      </div>
                    @endif
                </div>
                <div class="col-md-4">

                    <!-- ### Save ### -->
                    @if($is_new)
                    <div class="panel">
                      <div class="panel-body">
                        <button type="submit" style="margin-top:0px;" class="btn btn-block btn-primary">Сохранить изменения</button>
                      </div>
                    </div>
                    @endif

                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Статус</h3>
                            <div class="panel-actions">
                                {{-- <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a> --}}
                                @include('voyager::components.order-status',['data'=>$dataTypeContent,'cls_menu'=>'dropdown-menu-right'])
                                <input type="hidden" name="status" value="{{$dataTypeContent->status}}">
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php $disabled_on_off=($is_new)?'':'readonly' ?>
                            <div class="form-group">
                              <label for="name">Имя</label>
                              <input type="text" class="form-control" name="name" value="{{$dataTypeContent->name}}" {{$disabled_on_off}}/>
                            </div>
                            <div class="form-group">
                              <label for="phone">Телефон</label>
                              <input type="text" class="form-control" name="phone" value="{{$dataTypeContent->phone}}" {{$disabled_on_off}}/>
                            </div>
                            <div class="form-group">
                              <label for="email">Почта</label>
                              <input type="text" class="form-control" name="email" value="{{$dataTypeContent->email}}" {{$disabled_on_off}}/>
                            </div>
                            <div class="form-group">
                              <label for="city">Город</label>
                              <input type="text" class="form-control" name="city" value="{{$dataTypeContent->city}}" {{$disabled_on_off}}/>
                            </div>
                            @if(!empty($dataTypeContent->promocode))
                            <div class="form-group">
                              <label for="promocode">Промокод</label>
                              <p>{{$dataTypeContent->promocode}}</p>
                            </div>
                            @endif
                            @isset($dataTypeContent->seller_id)
                            <div class="form-group">
                              <label for="seller_id">Продавец:</label>
                              <a href="{{route('voyager.sellers.edit',$dataTypeContent->seller_id )}}">{{$dataTypeContent->seller->name}}</a>
                            </div>
                            @endisset
                            @if(!empty($dataTypeContent->comment))
                          <div class="form-group">
                            <dl>
                              <dt><p>Комментарий к заказу:</p></dt>
                              <dd>
                                <p style="color:#000">{{$dataTypeContent->comment}}</p>
                              </dd>
                            </dl>
                          </div>
                          @endif
                          <div class="form-group">
                              <label for="action">Действия с заказом</label>
                              <div>
                                <button class="btn btn-warning" type="button" id="add_note_btn">
                                  <i class="voyager-logbook"></i>
                                  Заметка
                                </button>
                                <button class="btn btn-inverse" type="button" id="send_pdf_btn">
                                  <i class="voyager-ticket"></i>
                                  Отправить PDF
                                </button>
                              </div>
                          </div>
                        </div>
                    </div>
                     <!-- ### Log CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> Журнал</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <?php $log_size=$dataTypeContent->log->count(); ?>
                        <div @if($log_size==0)style="display:none"@endif>
                          <ul class="list-group" id="log-list">
                            @include('voyager::components.log-list',['items'=>$dataTypeContent->log])
                          </ul>
                          @if($log_size>=3)
                          <button type="button" class="btn center-block btn-inverse" id="load_more_btn">Загрузить еще...</button>
                          @endif
                        </div>
                        <div class="panel-footer">
                          <ul class="list-group">
                            @isset($dataTypeContent->updated_by)
                            <li class="list-group-item">Обновлено: <a href="{{route('voyager.users.show',$dataTypeContent->updated_by)}}">{{$dataTypeContent->updatedByUser->name}}</a>, <small>{{$dataTypeContent->updated_at}}</small></li>
                            @endisset
                            @isset($dataTypeContent->created_by)
                            <li class="list-group-item">Создано: <a href="{{route('voyager.users.show',$dataTypeContent->created_by)}}">{{$dataTypeContent->createdByUser->name}}</a>, <small>{{$dataTypeContent->created_at}}</small></li>
                            @endisset
                          </ul>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
    @if(isset($dataTypeContent->id))
    <div class="modal modal-danger fade" tabindex="-1" id="delete_bill_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> Вы действительно желаете удалить сооставляющую заказа?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('voyager.bills.index') }}" id="delete_bill_form" method="POST">
                            {{ method_field("DELETE") }}
                            {{ csrf_field() }}

                            <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                    value="Удалить составляющую">
                        </form>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      {{-- Single update status modal --}}
      <div class="modal modal-warning fade" tabindex="-1" id="update_status_modal" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="update_form" onsubmit="return checkForm(this);" method="POST">
                  {{ method_field("PUT") }}
                  {{ csrf_field() }}
                  <input type="hidden" name="status" value="">

                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                  aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Причина отказа?</h4>
                  </div>
                  <div class="modal-body">
                    <textarea class="form-control" rows="5" maxlength="65535" placeholder="Оставьте комментарий с причиной отмены заказа..." name="notes" required></textarea>
                  </div>
                  <div class="modal-footer">
                      <input type="submit" name="myButton" class="btn btn-warning pull-right" value="Отправить">
                      <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                  </div>

                </form>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      {{-- Single add note modal --}}
      <div class="modal modal-warning fade" tabindex="-1" id="add_note_modal" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('voyager.orders.store') }}?note" onsubmit="return checkForm(this);" id="add_note_form" method="POST">
                  {{ csrf_field() }}
                  <input type="hidden" name="order_id" value="{{$dataTypeContent->id}}">

                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                  aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Заметка</h4>
                  </div>
                  <div class="modal-body">
                    <textarea class="form-control" rows="5" maxlength="65535" placeholder="Ваша заметка к заказу..." name="notes" autofocus required></textarea>
                  </div>
                  <div class="modal-footer">
                      <input type="submit" name="myButton" class="btn btn-warning pull-right" value="Отправить">
                      <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                  </div>

                </form>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      {{-- Single add payment modal --}}
      @if(isset($transactions))
      <div class="modal modal-success fade" tabindex="-1" id="pay_modal" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('voyager.payments.store') }}" id="pay_form" onsubmit="return checkForm(this);" method="POST">
                  {{ csrf_field() }}
                  <input type="hidden" name="order_id" value="{{$dataTypeContent->id}}">

                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                  aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" data-default="Заказ №{{$dataTypeContent->number}}">Платеж №2</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="">Сумма</label>
                      <?php $max_amount = ($is_installment) ? ($installment_plan['total_repaid'] - $paid_out) : $total_price; ?>
                      <input type="number" class="form-control" name="amount" min="1" max="{{$max_amount}}" value=""/>
                    </div>
                    <div class="form-group">
                      <label for="phone">Комментарий</label>
                      <textarea class="form-control" rows="5" maxlength="65535" placeholder="Комментарий к платежу..." name="notice" autofocus></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <input type="submit" name="myButton" class="btn btn-success pull-right" value="Внести платеж">
                      <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                  </div>

                </form>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      @endif

      @endif

@stop

@section('javascript')
    <script src="/admin/js/order-status.js"></script>
    <script src="/admin/js/payment.js"></script>
    <script>
      // Warn before leaving the page
      var order_changed=false;

      function leaving_warn(){
          event.returnValue = "\o/";
              return "Изменения не были сохранены. Желаете покинуть страницу?";
        }

      (function(){

        var form=document.forms.order,
        form_elms, x=0, count;


        function onChange(){
          var form_elms=form.elements, x=0, count=form_elms.length;

          order_changed = true;

          window.addEventListener("beforeunload", leaving_warn);

          for(; x<count; x++){
            form_elms[x].removeEventListener("change",onChange);
          }
        }

        if(form){
          form_elms= form.elements;
          count=form_elms.length;

          for(; x<count; x++){
            form_elms[x].addEventListener("change",onChange);
          }
          form.addEventListener('submit',function(){
            window.removeEventListener("beforeunload", leaving_warn);
          });
        }

      })();

      function checkForm(form) // Submit button clicked
      {
        //
        // check form input values
        //
        form.myButton.disabled = true;
        return true;
      }

        $('document').ready(function () {

          $('.toggleswitch').bootstrapToggle();

            $('input[type=radio][name=payment_type]').change(function(){

              var $installment_plans=$('#installment_plans');

              if(this.value=='INSTALLMENTS'){
                // $('input[name=installment_id]').first().prop('checked',true);
                $installment_plans.css('display','block');
              }
              else{
                // $('input[name=installment_id]').prop('checked',false);
                $installment_plans.css('display','none');
              }

            });

            //Custom update status
            var init_status;

            $('.order-status').orderStatus({
              beforeChange: function(new_status,status_name){
                var form= document.forms.order,
                input = form.elements.status;

                init_status = input.value;
                input.value = new_status;

                if(order_changed && init_status=='NEW'){

                  window.removeEventListener("beforeunload", leaving_warn);
                  form.submit();

                }
              },
              afterChange: function(result,prev_status){
                var $log_list = $("#log-list");

                if(init_status=='NEW'){
                  return location.reload();
                }

                if(result.log_html && result.log_html!=''){

                    $log_list.prepend(result.log_html);
                    $log_list.parent().css('display','block');
                }

              }
            });
              //.

            //Custom add note

            $('#add_note_modal').off('shown.bs.modal').on('shown.bs.modal', function () {
              $('#add_note_form textarea[name="notes"]').focus();
            });

            $('#add_note_btn').click(function(){
              $('#add_note_modal').modal('show');
            });

            $('#add_note_form').submit(function(e){
              e.preventDefault();
              var form= this, $form = $(form);
              var data = $form.serialize();

              $ajax = $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: data
              }).done(function(result){

                var key, errors, $log_list = $("#log-list");

                if (result.errors) {
                  errors = result.errors;
                  // $link.closest('.dropdown-menu').removeClass('open');
                  for (key in errors) {
                    if (errors.hasOwnProperty(key)) {
                      toastr["error"](
                        Array.isArray(errors[key]) ? errors[key][0] : errors[key]
                      );
                    }
                  }
                } else {

                  form.myButton.disabled = false;

                  form.reset();
                  $('#add_note_modal').modal('hide');
                  toastr["success"](result.message);

                  $log_list.prepend(result.html);
                  $log_list.parent().css('display','block');
                }

              });

              return false;
            });

            $('#send_pdf_btn').click(function(){
              var is_loading=false;

              return function(e){

                var $btn=$(this);

                if(!is_loading){

                  $.ajax(
                  {
                      url: '?send_pdf',
                      type: "get",
                      beforeSend: function()
                      {
                        is_loading=true;
                        $btn.button('loading');
                      }
                  })
                  .done(function(result)
                  {
                      is_loading=false;

                      var key, errors;

                      if (result.errors) {
                        errors = result.errors;

                        for (key in errors) {
                          if (errors.hasOwnProperty(key)) {
                            toastr["error"](
                              Array.isArray(errors[key]) ? errors[key][0] : errors[key]
                            );
                          }
                        }
                      } else {
                        toastr["success"](result.message);
                        $btn.button('reset');
                      }


                  })
                  .fail(function(jqXHR, ajaxOptions, thrownError)
                  {
                        alert('server not responding...');
                  });

                }


              };
            }());

            $('#load_more_btn').click(function(){
              var page=1, is_loading=false;
              return function(e){
                var $btn=$(this);

                if(!is_loading){
                  page++;

                  $.ajax(
                  {
                      url: '?page=' + page,
                      type: "get",
                      beforeSend: function()
                      {
                        is_loading=true;
                          $btn.text('Загрузка...');
                          $btn.prop('disabled',true);
                      }
                  })
                  .done(function(data)
                  {
                      is_loading=false;
                      if(data.count>0){
                        $btn.prop('disabled',false);
                        $btn.text('Загрузить еще...');
                        $("#log-list").append(data.html);
                      }
                      else{
                        $btn.remove();
                      }
                  })
                  .fail(function(jqXHR, ajaxOptions, thrownError)
                  {
                        alert('server not responding...');
                  });

                }

              }
            }());

            //.

            $('#pay_list .pay_btn').on('click', function(e){

              new Payment(this.dataset.number, this.dataset.amount, this.dataset.freeze);

              // $('#pay_modal').modal('show');

            });

            $('#bill_list .delete').on('click', function (e) {
                $('#delete_bill_form')[0].action = $(this).prop('href');
                $('#delete_bill_modal').modal('show');
                e.preventDefault();
                return false;
            });
        });
    </script>
@stop

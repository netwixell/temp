<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;

use Validator;
use App\Order;
use App\Payment;

class PaymentController extends VoyagerBaseController
{
    use BreadRelationshipParser;

    public function index(Request $request)
    {
      return back();
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $slug, $id);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {

            $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

            event(new BreadDataUpdated($dataType, $data));

            return redirect()
            ->route("voyager.orders.edit",$data->order_id)
            ->with([
                'message'    => __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);

            // return redirect()
            //     ->route("voyager.{$dataType->slug}.index")
            //     ->with([
            //         'message'    => __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
            //         'alert-type' => 'success',
            //     ]);
        }
    }

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;


        $order_id = $request->query('order_id');
        $order=\App\Order::find($order_id);
        if(!is_null($order)){
            $dataTypeContent['order_id']=$order_id;
        }

        foreach ($dataType->addRows as $key => $row) {
            $details = json_decode($row->details);
            $dataType->addRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));



        // Validate fields with ajax
        // $val = $this->validateBread($request->all(), $dataType->addRows);

        $val = $this->validatePayment($request->all());

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        $order = Order::with(['payments'=> function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($request->order_id);

        $payments = $order->payments;

        $payments_count = $payments->count();

        $is_installment = ($order->payment_type === $order::PAYMENT_INSTALLMENTS);

        if($payments_count>0){

          if($is_installment){

            $amount = (int)$request->amount;

            $installment = $order->installment;

            $installment_plan=installment_plan(
                              $order->confirmed_at,
                              $installment->expires_at,
                              $order->total_price,
                              $installment->commission,
                              $installment->first_payment
                            );

            $paid_out = (int)$order->payments->sum('amount');


            $remain = (int)($installment_plan['total_repaid'] - $paid_out);

            if( $payments_count == $installment_plan['payments_count'] ){ // last payment

              if($amount >= $remain){
                $payment = Payment::create($request->all());

                $order->status = $order::STATUS_PAID;
                $order->save();
              }
              else{
                return back()->with([
                  'message'    => 'Недостающая сумма для закрытия оплаты заказа',
                  'alert-type' => 'error',
                ]);

              }
            }
            else{ // monthly payment

                $max_monthly_amount = ($installment_plan['monthly_payment'] * 2) - 1;

                if($amount <= $max_monthly_amount && $amount < $remain){

                  $payment = Payment::create($request->all());

                  if($order->status != $order::STATUS_PENDING_PAYMENT){

                    $order->status = $order::STATUS_PENDING_PAYMENT;
                    $order->save();

                  }
                }
                else{ // monthly payment more or equal than two payments

                  $reference_amount = (int)($installment_plan['first_payment'] + ( ($payments_count - 1) * $installment_plan['monthly_payment']));

                  $debt = (int)($reference_amount - $paid_out);

                  $payment_with_debt = (int)($installment_plan['monthly_payment'] + $debt);

                  if($amount > $payment_with_debt){

                      $remain_amount = (int)($amount - $payment_with_debt);

                      $transactions_count = (int)($remain_amount / $installment_plan['monthly_payment']);

                      $last_payment = (int)(($remain_amount % $installment_plan['monthly_payment']) + $payment_with_debt);

                      $new_payments = [];


                      for($i=0; $i<$transactions_count; $i++){
                        $payment = new Payment();
                        $payment->order_id = $order->id;
                        $payment->amount = $installment_plan['monthly_payment'];
                        $payment->notice = $request->notice;

                        $new_payments[] = $payment;
                      }
                      if($last_payment > 0){
                        $payment = new Payment();
                        $payment->order_id = $order->id;
                        $payment->amount = $last_payment;
                        $payment->notice = $request->notice;

                        $new_payments[] = $payment;
                      }

                      $order->payments()->saveMany($new_payments);

                  }
                  else{
                    $payment = Payment::create($request->all());
                  }


                  if($amount >= $remain){

                    $order->status = $order::STATUS_PAID;
                    $order->save();

                  }
                  else if($order->status !== $order::STATUS_PENDING_PAYMENT){

                    $order->status = $order::STATUS_PENDING_PAYMENT;
                    $order->save();

                  }

                }

            }

          }
          else{
            return back()->with([
                'message'    => 'Заказ уже был оплачен',
                'alert-type' => 'error',
            ]);
          }

        }
        else{ // first payment

          $payment = new Payment();

          $payment->order_id = $order->id;

          if($is_installment){
            $installment = $order->installment;

            $installment_plan=installment_plan(
                              $order->confirmed_at,
                              $installment->expires_at,
                              $order->total_price,
                              $installment->commission,
                              $installment->first_payment
                            );
             $payment->amount = $installment_plan['first_payment'];

          }
          else{
            $payment->amount = $order->total_price;
          }

          $payment->notice = $request->notice;
          $payment->save();

          $order->status = ($is_installment) ? ($order::STATUS_PENDING_PAYMENT) : ($order::STATUS_PAID);

          $order->save();
        }

        return back()->with([
                'message'    => 'Платеж внесен',
                'alert-type' => 'success',
            ]);
    }

    public function validatePayment($request){

        return Validator::make($request, [
          'order_id' => 'required|exists:orders,id',
          'amount' => 'required|numeric|min:1',
          'notice' => 'max:65535',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $relationships = $this->getRelationships($dataType);

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->with($relationships)->findOrFail($id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name


        foreach ($dataType->editRows as $key => $row) {
            $details = json_decode($row->details);
            $dataType->editRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);



        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent'));
    }

    public function destroy(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('delete', app($dataType->model_name));

        // Init array of IDs
        $ids = [];
        if (empty($id)) {
            // Bulk delete, get IDs from POST
            $ids = explode(',', $request->ids);
        } else {
            // Single item delete, get ID from URL
            $ids[] = $id;
        }
        foreach ($ids as $id) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
            $this->cleanup($dataType, $data);
        }

        $displayName = count($ids) > 1 ? $dataType->display_name_plural : $dataType->display_name_singular;

        $res = $data->destroy($ids);
        $data = $res
            ? [
                'message'    => __('voyager::generic.successfully_deleted')." {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_deleting')." {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataDeleted($dataType, $data));
        }

        //return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
        return back()->with($data);
    }

}

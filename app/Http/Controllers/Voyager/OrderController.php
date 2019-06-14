<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;

use Illuminate\Validation\Rule;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;

use App\Order;
use App\OrderLog;
use App\Libs\Transaction;
use Validator;

use Illuminate\Support\Facades\Mail;


class OrderController extends VoyagerBaseController
{
    use BreadRelationshipParser;
    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse our Data Type (B)READ
    //
    //****************************************

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $searchable = $dataType->server_side ? array_keys(SchemaManager::describeTable(app($dataType->model_name)->getTable())->toArray()) : '';
        $orderBy = $request->get('order_by');
        $sortOrder = $request->get('sort_order', null);
        $paymentType = $request->get('payment_type', null);
        $status = $request->get('status', null);
        $billByOrder = $request->get('bill_by_order', null);

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {

            $model = app($dataType->model_name);

            if($billByOrder){

                $order=$model->findOrFail($billByOrder);
                $bill=$order->bill;
                // $bill=app('App\Bill')->where('order_id','=',$billByOrder)->get();
                if($bill){

                  if ($request->ajax()) {
                    return response()->json([
                        'message'    =>  trans('messages.success'),
                        'alert-type' => 'success',
                        'type' => 'ajax',
                        'html' => view('admin-panel.bill.bill',['bill'=>$bill,'total_price'=>$order->total_price])->render()
                    ]);
                  }
                }
                return abort(404);
            }

            $relationships = $this->getRelationships($dataType);


            $query = $model::select('*')->with($relationships);

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value && $search->key) {
                //$search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                if($search->key == 'number'){
                  $search_filter = '=';
                  $search_value = str_replace("-", "",  $search->value);
                }
                else{
                  $search_filter = (substr($search->key, -2) == 'id') ? '=' : 'LIKE';
                  $search_value = ($search_filter == '=') ? $search->value : '%'.$search->value.'%';
                }


                $query->where($search->key, $search_filter, $search_value);
            }

            if($paymentType){
              $query->where('payment_type', '=', $paymentType);
            }
            if($status){
              $query->where('status', '=', $status);
            }

            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'DESC';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
              // $dataTypeContent = call_user_func_array([$query->latest($model::CREATED_AT), $getter],[10]);
              //$dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
                $dataTypeContent = call_user_func([$query->orderBy('status','asc')->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);

            //Custom fields
            $countByTickets=$model->countByTickets();
            $calculation = $model -> calculation();
            $canceledCount = $model->canceled()->count();
            $totalCount = $model->count();
            //.
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        if (($isModelTranslatable = is_bread_translatable($model))) {
            $dataTypeContent->load('translations');
        }

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'sortOrder',
            'searchable',
            'isServerSide',
            'countByTickets',
            'calculation',
            'canceledCount',
            'totalCount'
        ));
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |__) |
    //               |  _  /
    //               | | \ \
    //               |_|  \_\
    //
    //  Read an item of our Data Type B(R)EAD
    //
    //****************************************

    public function show(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $relationships = $this->getRelationships($dataType);
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $dataTypeContent = call_user_func([$model->with($relationships), 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        // Replace relationships' keys for labels and create READ links if a slug is provided.
        $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'read');

        // Check permission
        $this->authorize('read', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.read';

        if (view()->exists("voyager::$slug.read")) {
            $view = "voyager::$slug.read";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    //***************************************
    //                ______
    //               |  ____|
    //               | |__
    //               |  __|
    //               | |____
    //               |______|
    //
    //  Edit an item of our Data Type BR(E)AD
    //
    //****************************************

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        //$relationships = $this->getRelationships($dataType);

        $relationships=['bill','payments'=> function ($query) {
            $query->orderBy('created_at', 'asc');
        },'card', 'log'=> function($query){
          $query->latest()->paginate(3);
        }];

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


        if ($request->ajax()) {

          if($request->exists('send_pdf')){

            Mail::to( $dataTypeContent->email )
            ->send(new \App\Mail\NewOrder($dataTypeContent));

            return response()->json([
                  'message'    => "Письмо с PDF будет отправлено в течении 15 минут.",
                  'alert-type' => 'success',
                  'type' => 'ajax'
              ]);

          }

          $view = view('voyager::components.log-list',['items'=>$dataTypeContent->log])->render();

          return response()->json([
            'count'=>$dataTypeContent->log->count(),
            'html'=>$view
            ]);
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        if( isset($dataTypeContent->confirmed_at) ){

          $transactions = $this->transactionList($dataTypeContent);

        }

        $dataTypeContent->unreadUsers()->detach(Auth::id());

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'transactions'));
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

        // Change status

        $order = Order::findOrFail($id);

        $new_status = $request->input('status');

        if($new_status !== $order->status){


          // Validate new status
          $val = $this->validateStatus($request->all(), $new_status);

          if ($val->fails()) {
             return response()->json(['errors' => $val->messages()]);
          }

          $output = [];

          $is_ajax = $request->query('ajax', false);

          if($new_status == Order::STATUS_CANCELED){
            $orderlog = $this->insertLog($order->id, $request->input('notes'));

            $view = view('voyager::components.log-list',['items'=> [$orderlog] ])->render();

            $output['log_html'] = $view;
          }
          elseif($new_status == Order::STATUS_CONFIRMED){

            $confirmed_at =  $order->freshTimestamp();
            $order->confirmed_at = $confirmed_at;

            if($order->payment_type === Order::PAYMENT_INSTALLMENTS && $order->installment->closed_at->diffInDays(now()) > 5){

                $order->payment_type = Order::PAYMENT_CASH;
                $request->merge(['payment_type' => Order::PAYMENT_CASH]);

            }

            $request->merge(['confirmed_at' => $confirmed_at]);
          }

          if($is_ajax){

              $order->status=$new_status;

              $order->save();

              $output['message'] = "Статус заказа успешно обновлен";
              $output['alert-type'] = "success";
              $output['type'] = 'ajax';
              $output['order_id'] = $order->id;
              $output['new-status'] = $new_status;
              $output['html'] = view('voyager::components.order-status',['data'=>$order])->render();

              return response()->json($output);

          }

        }

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {

          $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

          event(new BreadDataUpdated($dataType, $data));

          return redirect()
              ->route("voyager.{$dataType->slug}.index")
              ->with([
                  'message'    => __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
                  'alert-type' => 'success',
              ]);
        }

    }

    public function validateStatus($request, $new_status){

      if($new_status == Order::STATUS_CANCELED){

        return Validator::make($request, [
          'notes' => 'required|max:65535'
        ]);

      }
      else{

        return Validator::make($request, [
          'status' => ['required',Rule::in(Order::$statuses)]
        ]);

      }
    }

    public function validateNote($request){

      return Validator::make($request, [
          'order_id' => 'required',
          'notes' => 'required|max:65535'
        ]);
    }

    public function insertLog($order_id, $notes){

      $orderlog = new OrderLog();

      $orderlog->order_id = $order_id;

      $orderlog->notes = $notes;

      $orderlog->save();

      return $orderlog;

    }

    public function transactionList(Order $order){
      // $payment_installments = $order::PAYMENT_INSTALLMENTS;
      $transactions = [];

      $result = [];

      $payments = $order->payments;

      $number = 1;

      if($order->payment_type == $order::PAYMENT_INSTALLMENTS){

        $installment=$order->installment;
        $installment_plan=installment_plan(
          $order->confirmed_at,
          $installment->expires_at,
          $order->total_price,
          $installment->commission,
          $installment->first_payment
        );

        if( isset($payments[0]) ){
          $first_date = $payments[0]->created_at;
        }
        else{
          $first_date = $order->confirmed_at->copy()->addDays(5);
        }

        $first_payment_amount = $installment_plan['first_payment'];
        $transactions_count = $installment_plan['payments_count'] + 1; // includes initial payment
        $total_amount = $installment_plan['total_repaid'];
      }
      else{ // cash
        $first_date = $order->confirmed_at->copy()->addDays(5);

        $first_payment_amount = $order->total_price;
        $transactions_count = 1;
        $total_amount = $order->total_price;
      }

      $zero_transaction = new Transaction(
        $number,
        $first_date,
        $first_payment_amount
      );

      $prev_transaction = $zero_transaction;

      $transactions[] = $zero_transaction;

      $number++;

      for($n = $number; $n <= $transactions_count; $n++){

        $curr_transaction = new Transaction(
          $n,
          $prev_transaction->date->copy()->addMonth(),
          $installment_plan['monthly_payment']
        );

        $transactions[] = $curr_transaction;

        $prev_transaction = $curr_transaction;

      }


      $remain_amount = $total_amount;


      foreach($payments as $key => $payment){
        $transaction = $transactions[$key];

        $transaction->amount = $payment->amount;

        $transaction->date = $payment->created_at;

        $transaction->paidOut($payment->notice);

        $remain_amount -= $payment->amount;

        $result[] = $transaction;
      }

      $result_count = count($result);

      if($transactions_count > $result_count){

        $now = now();

        $index = $result_count;

        $current = $transactions[$index];

        if($now->lt($current->date)){

          if( $current->date->diffInDays($now) < 5 ){
            $current->overduePayment();
          }
          else{
            $current->payNow();
          }

        }
        else{
          $current->missedPayment();
        }

        $remain_count = $transactions_count - $current->number;

        if($current->number>1){
          // $transaction_amount = ceil($remain_amount / ($transactions_count - $index));
          $current_amount = $remain_amount - ( $installment_plan['monthly_payment'] * $remain_count );

          if($current_amount > 0){

            $current->amount = $current_amount;

            $transaction_amount = $installment_plan['monthly_payment'];

          }
          else{

            $transaction_amount = $remain_amount / ($transactions_count - $index);

            $current->amount = $transaction_amount;

          }

        }
        else{

          $remain_amount -= $current->amount;
          $transaction_amount = ($remain_count > 1) ? $remain_amount / $remain_count : $remain_amount;

        }

        $result[] = $current;

        $index++;

        for($x = $index; $x<$transactions_count; $x++){
          $transactions[$x]->amount = $transaction_amount;
          $result[] = $transactions[$x];
        }

      }


      return $result;
    }


    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    // Add a new item of our Data Type BRE(A)D
    //
    //****************************************

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;


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

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        $is_note = $request->exists('note');

        if($is_note){
          $val = $this->validateNote($request->all());

          if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
          }

          $order_id = $request->input('order_id');
          $notes = $request->input('notes');

          $orderlog = $this->insertLog($order_id, $notes);

          $view = view('voyager::components.log-list',['items'=> [$orderlog] ])->render();

          return response()->json([
                  'message'    => "Заметка добавлена",
                  'alert-type' => 'success',
                  'type' => 'ajax',
                  'html' => $view
              ]);

        }

        // Validate fields with ajax
        // $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->has('_validate')) {
            $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

            event(new BreadDataAdded($dataType, $data));

            if ($request->ajax()) {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                        'message'    => __('voyager::generic.successfully_added_new')." {$dataType->display_name_singular}",
                        'alert-type' => 'success',
                    ]);
        }
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |  | |
    //               | |  | |
    //               | |__| |
    //               |_____/
    //
    //         Delete an item BREA(D)
    //
    //****************************************

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

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }

    /**
     * Remove translations, images and files related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $dataType
     * @param \Illuminate\Database\Eloquent\Model $data
     *
     * @return void
     */
    protected function cleanup($dataType, $data)
    {
        // Delete Translations, if present
        if (is_bread_translatable($data)) {
            $data->deleteAttributeTranslations($data->getTranslatableAttributes());
        }

        // Delete Images
        $this->deleteBreadImages($data, $dataType->deleteRows->where('type', 'image'));

        // Delete Files
        foreach ($dataType->deleteRows->where('type', 'file') as $row) {
            foreach (json_decode($data->{$row->field}) as $file) {
                $this->deleteFileIfExists($file->download_link);
            }
        }
    }

    /**
     * Delete all images related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param \Illuminate\Database\Eloquent\Model $rows
     *
     * @return void
     */
    public function deleteBreadImages($data, $rows)
    {
        foreach ($rows as $row) {
            if ($data->{$row->field} != config('voyager.user.default_avatar')) {
                $this->deleteFileIfExists($data->{$row->field});
            }

            $options = json_decode($row->details);

            if (isset($options->thumbnails)) {
                foreach ($options->thumbnails as $thumbnail) {
                    $ext = explode('.', $data->{$row->field});
                    $extension = '.'.$ext[count($ext) - 1];

                    $path = str_replace($extension, '', $data->{$row->field});

                    $thumb_name = $thumbnail->name;

                    $this->deleteFileIfExists($path.'-'.$thumb_name.$extension);
                }
            }
        }

        if ($rows->count() > 0) {
            event(new BreadImagesDeleted($data, $rows));
        }
    }

    /**
     * Order BREAD items.
     *
     * @param string $table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        if (!isset($dataType->order_column) || !isset($dataType->order_display_column)) {
            return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => __('voyager::bread.ordering_not_set'),
                'alert-type' => 'error',
            ]);
        }

        $model = app($dataType->model_name);
        $results = $model->orderBy($dataType->order_column)->get();

        $display_column = $dataType->order_display_column;

        $view = 'voyager::bread.order';

        if (view()->exists("voyager::$slug.order")) {
            $view = "voyager::$slug.order";
        }

        return Voyager::view($view, compact(
            'dataType',
            'display_column',
            'results'
        ));
    }

    public function update_order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        $model = app($dataType->model_name);

        $order = json_decode($request->input('order'));
        $column = $dataType->order_column;
        foreach ($order as $key => $item) {
            $i = $model->findOrFail($item->id);
            $i->$column = ($key + 1);
            $i->save();
        }
    }
}

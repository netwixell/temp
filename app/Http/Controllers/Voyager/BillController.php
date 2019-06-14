<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\Relation;

use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;



class BillController extends VoyagerBaseController
{
    use BreadRelationshipParser;

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

        $priceable_type=$request->input('priceable_type');

        $priceable_id=$request->input('priceable_id');

        $priceable_class=Relation::getMorphedModel($priceable_type);

        if(!is_null($priceable_class) && !is_null($priceable_id)){
          $option=app($priceable_class)::find($priceable_id);
          if(isset($option->bill_price)){
            $request->merge(['price'=>$option->bill_price]);
          }
        }

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

        $model=app($dataType->model_name);

        // Check permission
        $this->authorize('add', $model);

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;

        $order_id = $request->query('order_id');
        $order=\App\Order::find($order_id);
        $total_price=null;
        if(!is_null($order)){
            $dataTypeContent['order_id']=$order_id;
            $total_price=$order->total_price;
        }

        $priceable_type = $request->query('priceable_type','option');
        $priceable_class=Relation::getMorphedModel($priceable_type);

        $options=[];

        if(!is_null($priceable_class)){

          if(method_exists($priceable_class, 'scopeAvailable')){
            $options=app($priceable_class)::available()->get();
          }
          else{
            $options=app($priceable_class)::all();
          }

        }

        $dataTypeContent['priceable_type']=$priceable_type;

        foreach ($dataType->addRows as $key => $row) {
            $details = json_decode($row->details);
            $dataType->addRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        //$isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('options','total_price','dataType', 'dataTypeContent'));
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $model=app($dataType->model_name);

        // Check permission
        $this->authorize('add', $model);

        $priceable_type=$request->input('priceable_type');

        $priceable_id=$request->input('priceable_id');

        $priceable_class=Relation::getMorphedModel($priceable_type);

        if(!is_null($priceable_class) && !is_null($priceable_id)){
          $option=app($priceable_class)::find($priceable_id);
          if(isset($option->bill_price)){
            $request->merge(['price'=>$option->bill_price]);
          }
        }

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

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
            ->route("voyager.orders.edit",$data->order_id)
            ->with([
                'message'    => __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);

            // return redirect()
            //     ->route("voyager.{$dataType->slug}.index")
            //     ->with([
            //             'message'    => __('voyager::generic.successfully_added_new')." {$dataType->display_name_singular}",
            //             'alert-type' => 'success',
            //         ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $relationships = $this->getRelationships($dataType);

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->with($relationships)->findOrFail($id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name

        $priceable_type = $request->query('priceable_type','option');
        $priceable_class=Relation::getMorphedModel($priceable_type);

        $options=[];

        if(!is_null($priceable_class)){

          if(method_exists($priceable_class, 'scopeAvailable')){
            $options=app($priceable_class)::available()->get();
          }
          else{
            $options=app($priceable_class)::all();
          }

        }

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

        return Voyager::view($view, compact('options','dataType', 'dataTypeContent'));
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

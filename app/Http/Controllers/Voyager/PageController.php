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

use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class PageController extends VoyagerBaseController
{
    use BreadRelationshipParser;

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

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
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
}

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

use Illuminate\Validation\Rule;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;


use Validator;

use Illuminate\Support\Facades\Mail;


class EventController extends VoyagerBaseController
{
    use BreadRelationshipParser;



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

        $relationships=['speeches','schedule'=> function ($query) {
            $query
              ->with(['flow','persons','partners'])
              ->orderBy('start_date', 'asc')
              ->orderBy('start_time', 'asc');
        },'persons'=>function($query){
          $query->with(['flow','person'])->orderBy('order','asc');
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

        $schedule = $dataTypeContent->schedule->groupBy(['start_date','flow.name']);
        // $event_persons = $dataTypeContent->persons->sortBy('flow.order');
        $event_persons = $dataTypeContent->persons->sortBy('flow.order')->groupBy('flow.name');

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable','schedule','event_persons'));
    }


}

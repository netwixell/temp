<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;

use App\Page;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public $variable1 = "I am Data";

    public function __construct() {

      $src_dir='/web-site';

      $cache_version = '0.5.3';

      $inactive_pages = Page::select('status', 'slug')->inactive()->pluck('slug')->toArray();

      // if(app()->environment('local')){
      //   $src_dir='/static';
      // }
      // else{
      //   $src_dir='/build';
      // }

       View::share ( 'inactive_pages', $inactive_pages );
       View::share ( 'src_dir', $src_dir );
       View::share ( 'cache_version', $cache_version );
      //  View::share ( 'variable4', ['name'=>'Franky','address'=>'Mars'] );
    }


}

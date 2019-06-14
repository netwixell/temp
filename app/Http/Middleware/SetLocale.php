<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('lang') && in_array( $request->query('lang') , Config::get('app.languages') ) ){
          Session::put('locale', $request->query('lang'));
        }
        if (Session::has('locale') && in_array( Session::get('locale'), Config::get('app.languages') ) && !(\Request::is('home*')) ) {
          $locale=Session::get('locale');
            App::setLocale($locale);
        }
        else { // This is optional as Laravel will automatically set the fallback language if there is none specified
          $locale=Config::get('app.fallback_locale');
            App::setLocale($locale);
        }
        // \Carbon\Carbon::setLocale($locale);

        return $next($request);
    }
}

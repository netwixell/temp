<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use \App\Callback;

class CallbackWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        $new_count = Callback::where('status', Callback::STATUS_NEW)->count();
        $count_str=($new_count>0)? "({$new_count})":"";
        //$string = trans_choice('voyager.dimmer.page', $count);
        $string="Обратная связь";
        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-telephone',
            'title'  => "{$string} {$count_str}",
            'text'   => '',
            'button' => [
                'text' => 'Просмотр',
                'link' => route('voyager.callback.index',['order_by'=>'status,created_at','sort_order'=>'asc']),
            ],
            'image' => '/',
        ]));
    }
}

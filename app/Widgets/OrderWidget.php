<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

use App\Order;

class OrderWidget extends AbstractWidget
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
        $new_count = Order::where('status', Order::STATUS_NEW)->count();
        $count_str=($new_count>0)? "({$new_count})":"";
        //$string = trans_choice('voyager.dimmer.page', $count);
        $string="Заказы";
        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-documentation',
            'title'  => "{$string} {$count_str}",
            'text'   => '',
            'button' => [
                'text' => 'Просмотр',
                'link' => route('voyager.orders.index',['order_by'=>'status,created_at','sort_order'=>'asc']),
            ],
            'image' => '/',
        ]));
    }
}

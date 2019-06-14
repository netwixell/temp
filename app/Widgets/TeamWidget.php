<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

use App\Team;

class TeamWidget extends AbstractWidget
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
        $new_count = Team::where('status', Team::STATUS_NEW)->count();
        $count_str=($new_count>0)? "({$new_count})":"";
        //$string = trans_choice('voyager.dimmer.page', $count);
        $string="Команды";
        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-group',
            'title'  => "{$string} {$count_str}",
            'text'   => '',
            'button' => [
                'text' => 'Просмотр',
                'link' => route('voyager.teams.index',['order_by'=>'status,created_at','sort_order'=>'asc']),
            ],
            'image' => '/',
        ]));
    }
}

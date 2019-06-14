<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\Event' => [
        //     'App\Listeners\EventListener',
        //     'App\Listeners\OrderStatusChangedListener',
        // ],
        'App\Events\NewOrderEvent' => [
          'App\Listeners\NewOrderListener',
        ],
        'App\Events\NewCallbackEvent' => [
          'App\Listeners\NewCallbackListener',
        ],
        'App\Events\NewTeamEvent' => [
          'App\Listeners\NewTeamListener',
        ],
        'App\Events\OrderStatusChanged' => [
            'App\Listeners\CheckTickets',

            'App\Listeners\SendNewStatusOrder',
            'App\Listeners\LogNewStatusOrder',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

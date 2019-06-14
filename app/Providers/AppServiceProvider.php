<?php

namespace App\Providers;

use App\Ticket;
use App\Observers\TicketObserver;
use App\Option;
use App\Observers\OptionObserver;
use App\Discount;
use App\Observers\DiscountObserver;
use App\Installment;
use App\Observers\InstallmentObserver;
use App\Order;
use App\Observers\OrderObserver;
use App\Payment;
use App\Observers\PaymentObserver;
use App\Card;
use App\Observers\CardObserver;
use App\Bill;
use App\Observers\BillObserver;
use App\EarlyBird;
use App\Observers\EarlyBirdObserver;
use App\OrderLog;
use App\Observers\OrderLogObserver;

use App\Team;
use App\Callback;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Ticket::observe(TicketObserver::class);
        Option::observe(OptionObserver::class);
        Discount::observe(DiscountObserver::class);
        Installment::observe(InstallmentObserver::class);
        Order::observe(OrderObserver::class);
        Payment::observe(PaymentObserver::class);
        Card::observe(CardObserver::class);
        Bill::observe(BillObserver::class);
        EarlyBird::observe(EarlyBirdObserver::class);
        OrderLog::observe(OrderLogObserver::class);


        Relation::morphMap([
          'order' => Order::class,
          'team'=> Team::class,
          'callback'=> Callback::class,
          'ticket' => Ticket::class,
          'option' => Option::class,
          'discount' => Discount::class
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

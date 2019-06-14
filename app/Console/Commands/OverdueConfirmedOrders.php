<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Order;

class OverdueConfirmedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:overdue-confirmed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check overdue confirmed orders and set status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $date = now()->subDays(5)->format('Y-m-d');

        DB::table('orders')->where('status',Order::STATUS_CONFIRMED)
        ->where('confirmed_at','<',$date)
        ->update(['status'=>Order::STATUS_OVERDUE_CONFIRMED]);
    }
}

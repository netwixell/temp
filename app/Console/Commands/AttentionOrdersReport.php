<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Order;

use App\Role;
use Notification;
use App\Notifications\AttentionOrders;

class AttentionOrdersReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:attention-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get orders that need attention and notify about them';

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
      $orders = DB::table('orders')->whereIn('status', Order::$temporary_statuses)->get();

      if($orders->count() > 0){
        $grouped_orders = $orders->groupBy('status');

        $role=Role::where('name','manager')->first();
        $users=$role->my_users()->get();
        Notification::send($users, new AttentionOrders($grouped_orders));
      }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Order;

use App\Role;

class UnreadOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:unread';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert to unread_orders table problem orders';

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

        if($orders->count() <= 0) return;

        $role=Role::where('name','manager')->first();
        $users=$role->my_users()->get();

        DB::table('userables')->where('userable_type', 'order')->whereIn('userable_id', $orders->pluck('id'))->delete();

        $data = [];

        $now = now()->toDateTimeString();

        foreach($orders as $order){

          foreach($users as $user){
            $data[] = [
              'user_id'=> $user->id,
              'userable_type'=> 'order',
              'userable_id'=> $order->id,
              'status'=> $order->status,
              'route' => 'voyager.orders.index',
              'created_at'=> $now
            ];
          }

        }

        DB::table('userables')->insert($data);

    }
}

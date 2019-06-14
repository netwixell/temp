<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Order;

class OverduePaymentOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:overdue-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find orders with status Pending Payment and less than 5 days to monthly payment and set status Overdue Payment';

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
        $now = now()->format('Y-m-d');

        // select o.* from orders as o
        // where o.status='pending_payment'
        // and datediff(
        //   now(),
        //   concat(
        //     date_format( (select created_at from payments where order_id=o.id order by created_at desc limit 1) , '%Y-%m-'),
        //     date_format( (select created_at from payments where order_id=o.id order by created_at asc limit 1) ,'%d')
        //   )
        // ) >= 27;

        DB::table('orders')
        ->where('status',Order::STATUS_PENDING_PAYMENT)
        ->whereRaw('
            DATEDIFF(?,
              DATE_ADD(
                CONCAT(
                  DATE_FORMAT((SELECT created_at FROM payments WHERE order_id=orders.id ORDER BY created_at DESC LIMIT 1), "%Y-%m-"),
                  DATE_FORMAT((SELECT created_at FROM payments WHERE order_id=orders.id ORDER BY created_at ASC LIMIT 1),"%d")
                ),
                INTERVAL 1 MONTH
              )
            )>=-4', [$now])
        ->update(['status'=>Order::STATUS_OVERDUE_PAYMENT]);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Order;

class MissedPaymentOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:missed-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find orders with status Overdue Payment and less than 1 day to monthly payment. Set status Missed Payment';

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

      DB::table('orders')
        ->where('status',Order::STATUS_OVERDUE_PAYMENT)
        ->whereRaw('
            DATEDIFF(?,
              DATE_ADD(
                CONCAT(
                  DATE_FORMAT((SELECT created_at FROM payments WHERE order_id=orders.id ORDER BY created_at DESC LIMIT 1), "%Y-%m-"),
                  DATE_FORMAT((SELECT created_at FROM payments WHERE order_id=orders.id ORDER BY created_at ASC LIMIT 1),"%d")
                ),
                INTERVAL 1 MONTH
              )
            )>-1', [$now])
        ->update(['status'=>Order::STATUS_MISSED_PAYMENT]);
    }
}

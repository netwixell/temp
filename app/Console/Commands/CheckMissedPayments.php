<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use App\Order;
use Notification;
use App\Notifications\MissedPayment;

class CheckMissedPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:missed_payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check missed payments and notification about it';

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
        //Notification::send($users, new MissedPayment($order));
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        '\App\Console\Commands\OverdueConfirmedOrders',
        '\App\Console\Commands\OverduePaymentOrders',
        '\App\Console\Commands\MissedPaymentOrders',
        '\App\Console\Commands\UnreadOrders',
        '\App\Console\Commands\GenerateSitemap',
        // '\App\Console\Commands\AttentionOrdersReport',
    ];

    protected function osProcessIsRunning($needle)
    {
        // get process status. the "-ww"-option is important to get the full output!
        exec('ps aux -ww', $process_status);

        // search $needle in process status
        $result = array_filter($process_status, function($var) use ($needle) {
            return strpos($var, $needle);
        });

        // if the result is not empty, the needle exists in running processes
        if (!empty($result)) {
            return true;
        }
        return false;
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

      $schedule->command('order:overdue-confirmed')->daily();
      $schedule->command('order:overdue-payment')->daily();
      $schedule->command('order:missed-payment')->daily();

      $schedule->command('order:unread')->daily();

      $schedule->command('sitemap:generate')->daily();


      // $schedule->command('order:attention-report')->daily();

      // $work_command = 'queue:work --sleep=3 --tries=5';
      // start the queue worker, if its not running
      // if (!$this->osProcessIsRunning($work_command)) {
      //     $schedule->command($work_command)->everyMinute()->withoutOverlapping(10);
      // }

      // $schedule->command('queue:work --sleep=3 --tries=3')
      //   ->cron('* * * * *')->name('QueueWorker')
      //   ->withoutOverlapping(10);

        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

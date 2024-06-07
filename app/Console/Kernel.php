<?php

namespace App\Console;

use App\Jobs\UpdatePrice;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->job(new UpdatePrice())->everyMinute();
        $schedule->call(function () {
            Log::info('Scheduled task executed ++++++++++++++');
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'Commands');
        require base_path('routes/console.php');
    }
}

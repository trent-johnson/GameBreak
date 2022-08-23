<?php

namespace App\Console;

use App\Jobs\CalcVoteWinners;
use App\Jobs\LockRSVPs;
use App\Jobs\SendRSVPReminders;
use App\Jobs\SendVoteWinners;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new SendRSVPReminders)->hourly();
        $schedule->job(new CalcVoteWinners)->hourlyAt(5);
        $schedule->job(new SendVoteWinners)->hourlyAt(10);
        $schedule->job(new LockRSVPs)->hourlyAt(15);
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

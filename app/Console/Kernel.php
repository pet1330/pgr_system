<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $routeMiddleware = [

    ];

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reminders:duetoday')
            ->dailyAt('08:30')->pingBefore(
                'https://hchk.io/'.env('UPCOMING_STATUS_CHECK_KEY'));

        $schedule->command('reminders:starttoday')
            ->dailyAt('08:30')->pingBefore(
                'https://hchk.io/'.env('DUE_STATUS_CHECK_KEY'));

        $schedule->command('pgr:tidy-archive')->monthlyOn(1, '05:30');

        $schedule->command('bouncer:clean')->monthlyOn(1, '05:35');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

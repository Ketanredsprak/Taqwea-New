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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('complete:class')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('cancel:class')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('subscription:expiry')
            ->dailyAt('00:10')
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('featured:expiry')
            ->dailyAt('00:10')
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('update:apple-secret')
            ->monthly()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('update:transaction-status')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('reminder:class-start')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('reminder:class-reminder-today-schedule')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('move:moveLogFiles')
            ->weekly()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('subscription:reminder')
            ->daily()
            ->onOneServer()
            ->withoutOverlapping();

        $schedule->command('expire:classrequest')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

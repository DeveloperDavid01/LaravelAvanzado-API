<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Los comandos de Artisan provistos por tu aplicación.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SendEmailVerificationReminderCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:send-reminders')->everyMinute();

        $schedule->command('inspire')
        ->evenInMaintenanceMode()
        ->sendOutputTo(storage_path('logs/inspire.log'))
        ->everyMinute();

        $schedule->call(function () {
            echo "Todo funcionando correctamente.";
        })->everyMinute();

        $schedule->command('SendEmailVerificationReminderCommand')
            ->withoutOverlapping()
            ->onOneServer()
            ->mondays();

        $schedule->command('SendEmailVerificationReminderCommand')
            ->onOneServer()
            ->daily(); 
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
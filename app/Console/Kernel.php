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
        Commands\liveLocation::class,
        Commands\RenewalReminder::class,
        Commands\enquiryCommand::class,
        Commands\DocumentRefresh::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //schedular for push notification  iib App
        $schedule->command('push-notification:push-notification')
            ->everyFifteenMinutes()->timezone('Asia/Dubai')
            ->appendOutputTo(storage_path('logs/cron.log'));
        //schedular for renewal reminder

        $schedule->command('reminder:renewal')
            ->dailyAt('10:00')->timezone('Asia/Dubai')
            // ->everyTenMinutes()
            // ->timezone('Asia/Dubai')
            ->appendOutputTo(storage_path('logs/cron.log'));
            
        $schedule->command('enquiry:refresh')
            // ->dailyAt('10:00')->timezone('Asia/Dubai')
            // ->everyFiveMinutes()->timezone('Asia/Dubai')
            ->everyFiveMinutes()->timezone('Asia/Dubai')
            ->appendOutputTo(storage_path('logs/cron.log'));

        
        $schedule->command('document:refresh')
            ->everyFiveMinutes();

        /* to send mails that acknowledges the user "documents shared" */
        $schedule->command('post:mail')
            ->dailyAt('10:00')
            // ->everyTenMinutes()
            // ->everyFiveMinutes()
            ->timezone('Asia/Dubai')
            ->appendOutputTo(storage_path('logs/cron.log'));
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

<?php

namespace App\Console;

use Picker\User\Jobs\PickUser;
use Picker\CoffeeRun\Jobs\CreateCoffeeRun;
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
        Commands\InstallCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (config('app.env') === 'local') {
            $schedule->job(new PickUser)->everyMinute();
        }

        if (config('app.env') === 'production') {
            $schedule->job(new PickUser)->weekdays()->dailyAt('08:30');
            $schedule->job(new PickUser)->weekdays()->dailyAt('13:30');
        }
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

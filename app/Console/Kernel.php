<?php

namespace App\Console;

use App;
use Carbon\Carbon;
use Picker\Schedule as CoffeeSchedule;
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
        // Excute the schedule only when the schedule exists
        if (App::environment(['local', 'production', 'staging'])) {
            $schedule->job(new PickUser)
                     ->everyMinute()
                     ->when(function() {
                         return CoffeeSchedule::query()
                             ->at(now()->format('G:i'))
                             ->days([strtolower(now()->shortEnglishDayOfWeek)])
                             ->exists();
                     });
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

<?php

namespace App\Console;

use App;
use App\Models\Schedule as CoffeeSchedule;
use App\Jobs\PickUser;
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

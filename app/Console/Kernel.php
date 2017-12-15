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
        Commands\WeatherCommand::class,
        Commands\FridayRoadshowCommand::class,
        Commands\WunderlistPostCommand::class,
        Commands\WunderlistListCommand::class,
        Commands\WunderlistListlistCommand::class,
        Commands\LtCommand::class,
        Commands\GithubIssuelistCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // for utc.
        $schedule->command('eris:friday')->weekly()->wednesdays()->at('12:00');
        $schedule->command('eris:weather')->daily()->dailyAt('21:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

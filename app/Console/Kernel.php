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
        Commands\MonitoringOgatismCommand::class,
        Commands\MonitoringMakiCommand::class,
        Commands\MonitoringMicrocosmCommand::class,
        Commands\MonitoringMoccumaCommand::class,
        Commands\PrTimesCommand::class,
        Commands\PrTimesRankingCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('eris:friday')->timezone('Asia/Tokyo')->weekly()->wednesdays()->at('21:00');
        $schedule->command('eris:weather')->timezone('Asia/Tokyo')->daily()->dailyAt('6:00');
        $schedule->command('eris:weather')->timezone('Asia/Tokyo')->daily()->dailyAt('9:00');
        $schedule->command('monitor:ogatism')->hourly();
        $schedule->command('monitor:maki')->hourly();
        $schedule->command('monitor:microcosm')->hourly();
        $schedule->command('monitor:moccuma')->hourly();
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

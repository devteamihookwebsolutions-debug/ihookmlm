<?php

namespace User\App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \User\App\Console\Commands\RankUpgradeCron::class,
        \User\App\Console\Commands\ProcessRankLevelCommission::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('rank:upgrade')
                ->hourly()
                ->withoutOverlapping(300)
                ->appendOutputTo(storage_path('logs/rank_cron.log'));
        $schedule->command('rank:level-commission')->everyFiveSeconds();

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}


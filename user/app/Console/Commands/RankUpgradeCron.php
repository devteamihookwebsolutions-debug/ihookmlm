<?php

namespace User\App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use User\App\Models\Scheduler\Rank\MRank;


class RankUpgradeCron extends Command
{
    protected $signature = 'rank:upgrade';
    protected $description = 'Upgrade member ranks and award bonuses - exactly like old ProMLM cron';

    public function handle()
    {
        $this->info('Rank upgrade cron started at ' . now());
        Log::info('Rank upgrade cron started');

        try {
            MRank::updateMembersRank();

            $this->info('Rank upgrade cron completed successfully!');
            Log::info('Rank upgrade cron completed successfully');
        } catch (\Exception $e) {
            Log::error('Rank cron failed: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }
    }
}

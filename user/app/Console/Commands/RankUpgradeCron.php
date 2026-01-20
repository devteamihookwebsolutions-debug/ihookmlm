<?php

/**
 * This class contains public functions related to RankUpgradeCron
 *
 * @package         RankUpgradeCron
 * @category        Console/commands
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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

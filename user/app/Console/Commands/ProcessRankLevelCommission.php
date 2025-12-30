<?php

namespace User\App\Console\Commands;

use Illuminate\Console\Command;
use User\App\Models\Scheduler\Rank\MRankLevelCommission;

class ProcessRankLevelCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rank:level-commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Rank Level Commission Bonus for qualified members';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        MRankLevelCommission::processLevelCommissions();
        $this->info('Rank Level Commission processed successfully.');
    }
}


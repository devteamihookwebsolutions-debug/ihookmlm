<?php

/**
 * This class contains public functions related to ProcessRankLevelCommission
 *
 * @package         ProcessRankLevelCommission
 * @category        Console/commands
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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


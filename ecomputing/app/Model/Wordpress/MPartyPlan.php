<?php

/**
 * This class contains public functions related to MPartyPlan
 *
 * @package         MPartyPlan
 * @category        Model
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
namespace Ecomputing\App\Model\Wordpress;
use Illuminate\Support\Facades\DB;

class MPartyPlan
{
    /**
     * This public function is used  to get sponsor list from mlm
     *
     */
    public function getPartyPlanDetails()
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');
        $partyId = trim(request()->input('party_id'));
        if (empty($partyId)) {
            return 0;
        }

        $partyTable = $prefix . '_party_setup';
        $membersTable = $prefix . '_members_table';

        // get member id from party setup
        $memberId = DB::table($partyTable)
            ->where('setup_party_id', $partyId)
            ->where('setup_name', 'partyuserid')
            ->value('setup_value');

        if (empty($memberId)) {
            return 0;
        }

        // get members_shop_id from members table
        $membersShopId = DB::table($membersTable)
            ->where('members_id', $memberId)
            ->value('members_shop_id');

        return $membersShopId ?? 0;
    }

}
?>

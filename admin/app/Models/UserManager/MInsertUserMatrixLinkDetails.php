<?php

/**
 * This class contains public functions related to MInsertUserMatrixLinkDetails
 *
 * @package         MInsertUserMatrixLinkDetails
 * @category        Model
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

namespace Admin\App\Models\UserManager;


use User\App\Models\MemberLinks;

use User\Models\Middleware\MPackageDetails;


class MInsertUserMatrixLinkDetails
{

   public function insertUserMatrixLinkDetails(

        $members_id,
        $members_plans,
        $members_package,
        $members_subscription_plan,
        $direct_id,
        $spilloverId,
        $entry_criteria,
         $position,
         $membersParentsStr,
            $rootValue
        // $paymenthistory_mode,
        // $spillover_id,
        // $position,
        // $methodtype,
        // $usertype,
        // $sponsor_username,
        // $root,
        // $members_parents,
        // $paymentdetails_temp_mode,   //online or offline
        // $matrix_type_id,
        // $stripe_cusid,
        // $stripe_subid,
        // $chargebee_subid,
        // $members_subscription_expirydate
    ) {

            $package = getPackageById( $members_package);
            $memberLink = new MemberLinks();
            $memberLink->members_id = $members_id;
            $memberLink->matrix_id = $members_plans;
            $memberLink->direct_id = $direct_id;
            $memberLink->spillover_id = $spilloverId ?: null;
            $memberLink->position= $position;
	        $memberLink->members_subscription_plan =  $members_package;
            $memberLink->members_subscription_date = date('Y-m-d');
            $memberLink->members_parents = $membersParentsStr;
            $memberLink->root = $rootValue;
            $memberLink->save();
    }


}
?>

<?php

/**
 * This class contains public functions related to MinsertUserMatrixLinksDetails
 *
 * @package         MinsertUserMatrixLinksDetails
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\UserManager;


use Admin\App\Models\Member\MemberLinks;

use User\Models\Middleware\MPackageDetails;
use Admin\App\Models\UserManager\MPackageExpiryDateCalculate;

class MinsertUserMatrixLinksDetails
{

public static function insertUserMatrixLinkssDetails(
    $members_id,
    $direct_id,
    $members_plans = null,
    $members_subscription_plan = null,
    $entry_criteria = null,
    $paymenthistory_mode = null,
    $spillover_id = null,
    $position = null,
    $methodtype = null,
    $usertype = null,
    $sponsor_username = null,
    $root = null,
    $members_parents = null,
    $tempmode = null,
    $matrix_type_id = null,
    $stripe_cusid = null,
    $stripe_subid = null,
    $chargebee_subid = null,
    $members_subscription_expirydate = null
)


 {

//  echo 'hai test<pre>';
//  exit();

    // Handle free / offline / online
    if ($tempmode == 'freeplan') {
//         echo 'hais this is the freeplan<pre>';
// print_r($direct_id);
//         exit();
        $paymenthistory_status = 'notpaid';
        $members_account_status = '0';
        $members_status = '0';
        $members_subscription_status = '0';
        $members_verified = '0';
    } elseif ($tempmode == 'offline') {
//           echo 'hais this is the offline<pre>';
// print_r($direct_id);
//         exit();
        $paymenthistory_status = 'notpaid';
        $members_account_status = '-1';
        $members_status = '1';
        $members_subscription_status = '-1';
        $members_verified = '1';
    } else {
//           echo 'hais this is else <pre>';
// print_r($direct_id);
//         exit();
        $paymenthistory_status = 'paid';
        $members_account_status = '1';
        $members_status = '1';
        $members_subscription_status = '1';
        $members_verified = '1';
    }
    // Default leg
    $defaultleg = ($matrix_type_id == '1' || $matrix_type_id == '2') ? '5' : '0';

    // SAVE USING ELOQUENT
    $memberLink = new MemberLinks();
    $memberLink->members_id = $members_id;
    $memberLink->matrix_id = $members_plans;
    $memberLink->spillover_id = $spillover_id;
    $memberLink->direct_id = $direct_id;
    $memberLink->root = $root;
    $memberLink->members_parents = $members_parents;
    $memberLink->members_account_status = $members_account_status;
    $memberLink->members_status = $members_status;
    $memberLink->matrix_doj = now();
    $memberLink->members_subscription_plan = $members_subscription_plan;
    $memberLink->members_subscription_date = date('Y-m-d');
    $memberLink->members_subscription_status = $members_subscription_status;
$expiry = $members_subscription_expirydate;

// echo '<pre>';
// print_r($memberLink->direct_id);exit();

// If value is empty, zero-date, or invalid → set NULL
if (
    empty($expiry) ||
    $expiry == '0000-00-00' ||
    strtotime($expiry) === false
) {
    $memberLink->members_subscription_expirydate = null;
} else {
    $memberLink->members_subscription_expirydate = date('Y-m-d', strtotime($expiry));
}

    $memberLink->moduletype = $methodtype;
    $memberLink->user_type = 1;  // admin user
    $memberLink->stripe_cusid = $stripe_cusid;
    $memberLink->stripe_subid = $stripe_subid;
    $memberLink->chargebee_subid = $chargebee_subid;
    $memberLink->position = $position;
    $memberLink->default_leg = $defaultleg;
    // dd($memberLink);
 try {
    $memberLink->save();
} catch (\Exception $e) {
    dd("Insert Error: " . $e->getMessage());
}

return $memberLink;

}



// public static function insertUserMatrixLinkssDetails( $members_id,
//     $direct_id,
//     $members_plans,  $members_subscription_plan,$entry_criteria,$paymenthistory_mode,
//     // $spillover_id,$methodtype,$tempmode
//     $position,$usertype,$sponsor_username,$root,$members_parents,$matrix_type_id,$stripe_cusid,
//     $stripe_subid,$chargebee_subid,$members_subscription_expirydate
//     )
// {
//     echo "FUNCTION REACHED <br>";
//     echo "<pre>";
//     print_r(func_get_args());
//     exit();
// }


}
?>

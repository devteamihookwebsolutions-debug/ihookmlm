<?php

namespace Admin\App\Models\UserManager;


use Admin\App\Models\Member\MemberLinks;

use User\Models\Middleware\MPackageDetails;
use Admin\App\Models\UserManager\MPackageExpiryDateCalculate;

class MinsertUserMatrixLinksDetails
{
public static function insertUserMatrixLinkDetails(
    $members_id,
    $direct_id,
    $members_plans,
    $members_subscription_plan,
    $entry_criteria,
    $paymenthistory_mode,
    $spillover_id,
    $position,
    $methodtype,
    $usertype,
    $sponsor_username,
    $root,
    $members_parents,
    $paymentdetails_temp_mode,
    $matrix_type_id,
    $stripe_cusid,
    $stripe_subid,
    $chargebee_subid,
    $members_subscription_expirydate
) {
    // Handle free / offline / online
    if ($paymentdetails_temp_mode == 'freeplan') {
        $paymenthistory_status = 'notpaid';
        $members_account_status = '0';
        $members_status = '0';
        $members_subscription_status = '0';
        $members_verified = '0';
    } elseif ($paymentdetails_temp_mode == 'offline') {
        $paymenthistory_status = 'notpaid';
        $members_account_status = '-1';
        $members_status = '1';
        $members_subscription_status = '-1';
        $members_verified = '1';
    } else {
        $paymenthistory_status = 'paid';
        $members_account_status = '1';
        $members_status = '1';
        $members_subscription_status = '1';
        $members_verified = '1';
    }

    // Subscription expiry
    // if ($members_subscription_plan > 0) {
    //     dd('function reached or not');
    //     $totaldays = MPackageExpiryDateCalculate::getPackageExpireDays($members_subscription_plan);
        
    //     $members_subscription_expirydate = date('Y-m-d', strtotime("+$totaldays days"));
    // } else {
    //     $members_subscription_expirydate = '0000-00-00';
    // }

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

}
?>

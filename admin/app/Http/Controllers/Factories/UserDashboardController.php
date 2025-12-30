<?php

/**
 * This class contains public functions related to Total Commission reports
 *
 * @package
 * @category        Controller
 * @author
 * @link
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Http\Controllers\Factories;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Factories\MUserDashboard;
use Admin\App\Models\Middleware\MAmazonCloudFront;
use Illuminate\Http\Request;

use Exception;

class UserDashboardController extends Controller
{

      public static function showUserDashboard()
{
    $show_userdashboard = MUserDashboard::showUserDashboardDetails();
    // dd($show_userdashboard);
    $output['banner_image'] = $show_userdashboard['banner_image'];
    $output['dashboard_profile_image'] = $show_userdashboard['dashboard_profile_image'];
    // $output['dashboard_wallet_image'] = $show_userdashboard['dashboard_wallet_image'];
    $output['banner_content'] = $show_userdashboard['banner_content'];
    $output['banner_imagelink'] = MAmazonCloudFront::getCloudFrontUrl($output['banner_image']);
    // dd($show_userdashboard);
    // $output['dashboard_wallet_imagelink'] = MAmazonCloudFront::getCloudFrontUrl($output['dashboard_wallet_image']);
    $output['dashboard_profile_imagelink'] = MAmazonCloudFront::getCloudFrontUrl($output['dashboard_profile_image']);
    $output['social_feed_script'] = $show_userdashboard['social_feed_script'];
    // $output['login_popup'] = $show_userdashboard['loginpopup_notification'];
    // $output['loginpopup_content'] = trim($show_userdashboard['loginpopup_content']);
    // $output['newrank_popup'] = $show_userdashboard['newrank_notification'];
    // $output['newrankpopup_content'] = trim($show_userdashboard['newrankpopup_content']);
 return view('factories/userdashboard',$output);
}

public function updateUserDashboard(Request $request)
{
    MUserDashboard::updateUserDashboard($request);

    return back()->with('success', __('User dashboard settings updated successfully.'));
}


}

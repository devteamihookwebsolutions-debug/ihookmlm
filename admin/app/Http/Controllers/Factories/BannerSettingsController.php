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
use Admin\App\Models\Factories\MBannerSettings;
use Illuminate\Http\Request;
use Admin\App\Models\Member\Banner;
use Exception;

class BannerSettingsController extends Controller
{

    // public static function showBanners()
    // {
    //     //    $output['banners'] = MBannerSettings::showBanners();

    //        return view('factories.banners');


    // }
    // BannerSettingsController.php
public function showBanners(Request $request)
{
    $action = $request->query('action', 'login');
    $banners = MBannerSettings::showBanners($action);

      return view('factories.banners', [
        'banners' => $banners,
        'action'  => $action
    ]);
}


public function showEditBanner($action, $id)
{
    // dd('request');
    try {

        // Find the banner by ID
        $banner = Banner::where('banner_id', $id)->firstOrFail();
        // dd($banner);
        // Build image URL
        $bannerImage = config('app.cdn_url') . '/' . $banner->banner_image;
        // dd($bannerImage);

        return view('factories.editbanner', [
            'banner' => $banner,
            'action' => $action,
            'banner_image' => $bannerImage,
             'errval' => $banner->toArray()
        ]);

    } catch (Exception $e) {

        return redirect()
            ->route('showbanners/login')
            ->with('error_message', $e->getMessage());
    }
}




public function validateEditBanner(Request $request, $action, $id)
{
        $banner = Banner::where('banner_id', $id)->firstOrFail();
        // dd($banner);
    MBannerSettings::updateBanner($request, $action, $id);

    return redirect()
        ->route('showbanners/login', ['action' => $action])
        ->with('success', 'Banner updated successfully.');
}

    public  function deleteBanner()
    {
        // dd('ajksfd');

      MBannerSettings::deleteBanner();

    }
}

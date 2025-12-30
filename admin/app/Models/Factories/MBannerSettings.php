<?php

namespace Admin\App\Models\Factories;
use Admin\App\Display\Factories\DBannerSettings;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\Banner;
use Illuminate\Http\Request;

class MBannerSettings
{

// MBannerSettings.php
public static function showBanners($action = 'login')
{
    if ($action === 'login') {
        $banner_type = '1';
    } elseif ($action === 'register') {
        $banner_type = '2';
    } 
// dd($banner_type);
    $banners = Banner::where('banner_type', $banner_type)
                     ->orderBy('banner_id', 'asc')
                     ->get();

// dd($banners);
    return DBannerSettings::showBanners($banners, $banner_type);
}


public static function updateBanner(Request $request, $action, $id)
{
    // dd('asfjdk');
    // 1. Get banner
    // $banner = Banner::findOrFail($id);
      $banner = Banner::where('banner_id', $id)->firstOrFail();
    //   dd($banner);
    // 2. Determine banner_type
    $banner_type = $action === 'login' ? 1 : 2;

    // 3. Determine status
    $banner_status = $request->has('banner_status') ? 1 : 2;

    // 4. Dimensions required
    $requiredWidth  = $action === 'login' ? 975 : 650;
    $requiredHeight = 940;

    // 5. Check if new image uploaded
    if ($request->hasFile('banner_image')) {

        $file = $request->file('banner_image');

        // Read image size
        list($width, $height) = getimagesize($file);

        if ($width != $requiredWidth || $height != $requiredHeight) {
            return back()->with('error_message',
                "Image dimensions must be exactly {$requiredWidth}px × {$requiredHeight}px."
            );
        }

        // Generate hashed filename
        $ext = $file->getClientOriginalExtension();
        $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $ext;

        // Folder based on action
        $folder = $action === 'login'
            ? 'uploads/login_banners/'
            : 'uploads/register_banners/';

        // Upload to S3
        $path = $file->storeAs($folder, $filename, 's3');

        // Make public URL via your CloudFront CDN
        $banner_image_path = config('app.cdn_url') . '/' . $path;
    }
    else {
        // keep old image
        $banner_image_path = $banner->banner_image;
    }

    // 6. Update banner
    $banner->update([
        'banner_image' => $banner_image_path,
        'banner_status' => $banner_status,
        'banner_type' => $banner_type

    ]);
    // dd($banner);
    return redirect()
        ->route('showbanners/login', ['action' => $action])
        ->with('success', 'Banner has been updated successfully.');
}

public static function deleteBanner()
{
 
}
}
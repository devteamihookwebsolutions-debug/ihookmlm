<?php

namespace Admin\App\Display\Factories;

use Admin\App\Models\Member\Banner;

class DBannerSettings
{
    public static function showBanners($banners, $bannerType)
    {
        $output = '';

        for ($i = 0; $i < 2; $i++) {
            $banner = $banners->get($i);

            // Create banner if missing
            if (!$banner) {
                $banner = Banner::create([
                    'banner_type'   => $bannerType,
                    'banner_status' => 1,
                    'created_on'    => now(),
                    'banner_image'  => 'default-banner.jpg',
                ]);
            }

            // Status badge
            $status = $banner->banner_status == 2
                ? '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Suspend</span>'
                : '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Active</span>';

            // Image handling
            $imagePath = $banner->banner_image ?? 'default-banner.jpg';

            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $bannerImageUrl = $imagePath;
            } else {
                // Clean old path
                $cleanPath = str_replace(
                    ['uploads/', 'login_banners/', 'register_banners/'],
                    '',
                    $imagePath
                );

                // Choose folder based on banner_type
                $folder = $bannerType == 1 ? 'login_banners' : 'register_banners';

                $bannerImageUrl = asset("uploads/$folder/$cleanPath");
            }

            // Edit link
            $action = $bannerType == 1 ? 'login' : 'register';
            $editUrl = route('editbanner', [
                'action' => $action,
                'id'     => $banner->banner_id,
            ]);

            // Row output
            $output .= '<tr>';
            $output .= '<td><img class="login-banner" alt="banner image" src="' . $bannerImageUrl . '" style="max-width: 21%; height: auto;"></td>';
            $output .= '<td>' . $status . '</td>';
            $output .= '<td>
                <a aria-label="edit" href="' . $editUrl . '" title="Edit">
                    <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                    </svg>
                </a>
            </td>';
            $output .= '</tr>';
        }

        // dd($output);
        return $output; // <-- DO NOT USE dd() here in production
    }
}

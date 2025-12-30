<?php
/**
 * This class contains public static functions related to Payment List
 *
 * @package         DPaymentList
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace Display\Profile;

use Model\Middleware\MAmazonCloudFront;

class DAvatarGallery
{
    /**
     * This public static function is used to getAvatarGallery
     * @param array $records
     * @return HTML data
    */
    public static function getAvatarGallery($records)
    {
        if (count((array)$records) > 0) {
            $output .= '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">';

            for ($i = 0; $i < count((array)$records); $i++) {
                if ($i % 3 == '0' && $i != '0') {
                    $output .= '</div><div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">';
                }
                $linkurl = $_ENV['FCPATH'] . '/myprofile/setavatar';
                $avatar_gallery_path = MAmazonCloudFront::getCloudFrontUrl($records[$i]['avatar_gallery_path']);
                $output .= '<div class="">
                <div class="">
                    <div class="relative">
                        <img alt="image" src="' . $avatar_gallery_path . '" class="w-full h-auto rounded-full">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-full">
                            <ul class="mt-info space-x-2">
                                <li>
                                    <a aria-label="link" class="btn text-white bg-transparent rounded-md px-3 py-2" href="' . $linkurl . '/' . $records[$i]['avatar_gallery_id'] . '" title="' . __('Set image') . '">
                                        <svg  xmlns="http://www.w3.org/2000/svg" width="35" height="35"  
fill="currentColor" viewBox="0 0 24 24" >
<!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
<path d="M10.5 15.5c-.26 0-.51-.1-.71-.29l-2.5-2.5L8.7 11.3l1.79 1.79 4.79-4.79 1.41 1.41-5.5 5.5c-.2.2-.45.29-.71.29Z"></path><path d="M19 21H5c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2M5 5v14h14V5z"></path>
</svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>';

            }
            return $output;
        }
    }
}
?>
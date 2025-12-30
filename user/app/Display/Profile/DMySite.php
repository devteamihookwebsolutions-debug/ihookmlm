<?php
/**
 * This class contains public static functions related to myaccount
 *
 * @package         DMySite
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

use Query\Bin_Query;
use Model\Middleware\MFormatDate;
use Model\Middleware\MMembersDetails;
use Model\Middleware\MAmazonCloudFront;
use Model\Middleware\MSiteDetails;

class DMySite
{ /**
     * This public static function is used to showHeaderMessageNotification
     * @param array  $unseenmemberscount
      * @param array  $records
     * @return HTML data
     */
    public static function getMembersSiteDetail($records)
    {
        for ($i = 0; $i < count((array)$records); $i++) {
            $re = json_decode($records[$i]['meta_data'], true);
        }
        $mobile = $re['mobile'];
        $message = $re['message'];
        $output .= '
                                          <div class="mb-5 form-group">
                                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">' . __('Phone (shown to public)') . '</label>
                                            <input type="" name="mobile"
                                            value="'.$mobile.'"  placeholder="Enter Mobile Number" class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light form-control">
                                            <input type="hidden" name="id" value="'.$user_id.'">
                                            </div>

                                         <div class="mb-5 form-group">
                                                <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Write ' . __('Write something about yourself') . '</label>
                                                <textarea id="message" name="message" rows="4" class="block shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light form-control" placeholder="Write your thoughts here..."></textarea>
                                                </div>

                                           <div class=" border-b border-neutral-300 my-5"></div>
                                            <div class="card-footer">
                                            <div class="flex justify-end">
                                                <div class="form-submit">
                                                <button type="button" class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700" onclick="window.location.reload();">' . __('Cancel') . '</button>
                                                <button type="submit" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>' . __('Save') . '</button>
                                                </div>
                                            </div>
                                            </div>
																
';
        return $output;
    }

}
?>
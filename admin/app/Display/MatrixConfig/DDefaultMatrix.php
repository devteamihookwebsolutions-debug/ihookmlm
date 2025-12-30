<?php

namespace Admin\App\Display\MatrixConfig;
use Illuminate\Http\Request;


class DDefaultMatrix{

   public static function showDefaultSponsor($records, $default_sponsor, $members_username)
{
    $output = '';

    if (count((array) $records) > 0) {
        $output .= '<div class="">
            <input aria-label="label" 
                   class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 bg-neutral-100 text-neutral-900 dark:bg-neutral-700 dark:text-white dark:border-neutral-600 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" 
                   id="searchbox"  
                   type="text"  
                   placeholder="' . __('Search User') . ' ' . strtolower(__('Name')) . '"  
                   value="' . e($members_username) . '" 
                   autocomplete="off" 
                   spellcheck="false" 
                   style="position: relative; vertical-align: top; background-color: transparent;" 
                   onkeyup="searchusers(this.value);">

            <div class="search-menu" style="z-index: 100; display: none; position: inherit; top: 0; left: 0px;">
                <div class="search-set"></div>
            </div>

            <input type="hidden" name="default_sponsor" id="default_sponsor" value="' . e($default_sponsor) . '">
        </div>';
    } else {
        $output .= '<input aria-label="label" 
                          type="email" 
                          name="default_sponsor" 
                          id="default_sponsor" 
                          class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 bg-neutral-100 text-neutral-900 dark:bg-neutral-700 dark:text-white dark:border-neutral-600 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">';

        $output .= '</div></div>
        <div class="mb-4">
            <label class="col-xl-3 col-lg-3 col-form-label">' . __('Password') . '</label>
            <div class="col-xl-9 col-lg-9">
                <input aria-label="label" 
                       type="text" 
                       name="members_password" 
                       id="members_password" 
                       class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 bg-neutral-100 text-neutral-900 dark:bg-neutral-700 dark:text-white dark:border-neutral-600 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" 
                       required>
            </div>
        </div>';
    }

    return $output;
}

}
?>
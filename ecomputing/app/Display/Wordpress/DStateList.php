<?php
/**
 * This class contains public functions related to state list
 *
 * @package         DStateList
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php

namespace Ecomputing\App\Display\Wordpress;

class DStateList
{

    public function getStateList($records)
    {
        if (count((array)$records) > 0) {
            $output .= '<div class="form-group">
                            <label class="col-md-4 control-label">State</label>
                            <div class="col-md-8" required ><select aria-label="label" id="state" class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500" name="state" required style="height: 50px;">
               <option value="0">Select state</option></div>
                        </div> ';
            for ($i = 0; $i < count((array)$records); $i++) {
                if ($Err == $records[$i]['state_id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="' . $records[$i]['state_id'] . '" ' . $selected . '>' . $records[$i]['state_name'] . '</option>';
            }
            $output .= '</select>';
        }
        echo $output;
    }
}


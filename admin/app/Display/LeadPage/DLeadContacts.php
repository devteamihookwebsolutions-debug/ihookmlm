<?php

/**
 * This class contains public functions related to DLeadContacts
 *
 * @package         DLeadContacts
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Display\LeadPage;

class DLeadContacts
{
public static function allcurrency($records, $curr)
{
    $output = ''; // Initialize the variable first
// dd($curr);
    if (count((array)$records) > 0) {
        for ($i = 0; $i < count((array)$records); $i++) {
            $selected = ($curr == $records[$i]['currency_symbol']) ? 'selected=selected' : '';
            $output .= '<option value="' . $records[$i]['currency_value'] . '" ' . $selected . '>'
                        . $records[$i]['currency_name'] . ' (' . $records[$i]['currency_symbol'] . ')</option>';
        }
    }

    // dd($output); // Optional: use this for debugging
    return $output;
}


}

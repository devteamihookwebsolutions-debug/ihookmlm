<?php

/**
 * This class contains public functions related to DMatrixTypes
 *
 * @package         DMatrixTypes
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


namespace Admin\App\Display\Middleware;

use Illuminate\Http\Request;

class DMatrixTypes
{

    /**
     * Generate the matrix type select dropdown.
     *
     * @param array $recordSet
     * @param int $matrix_type_id
     * @return string
     */
  public static function getMatrixTypes($recordSet, $count, $matrix_type_id)
{

$output = '';
$selectedMatrixTypeId = intval($matrix_type_id); // current selected value

// Determine if the select should be read-only
$isReadonly = !empty($selectedMatrixTypeId);

// Start select tag (classes kept intact)
$output = '<select id="matrix_type_id" aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="matrix_type_id" required aria-describedby="matrixtypeid-error" ' . ($isReadonly ? 'disabled' : '') . '>';
$output .= '<option value="">' . __('Select') . '</option>';

// Loop through recordSet
foreach ($recordSet as $record) {
    $selected = ($record['matrix_type_id'] == $selectedMatrixTypeId) ? ' selected="selected"' : '';
    $output .= '<option value="' . intval($record['matrix_type_id']) . '"' . $selected . '>' . ucfirst($record['matrix_type_name']) . '</option>';
}

$output .= '</select>';

// If readonly, add hidden input to submit the value
if ($isReadonly) {
    $output .= '<input type="hidden" name="matrix_type_id" value="' . intval($selectedMatrixTypeId) . '">';
}

return $output;
}


}

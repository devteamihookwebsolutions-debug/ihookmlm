<?php

/**
 * This class contains public functions related to DEpinManagement
 *
 * @package         DEpinManagement
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Display\Epin;
use Admin\App\Models\Middleware\MMatrixDetails;
use Illuminate\Support\Facades\DB;
class DSendEpins
{
public static function showEpinType($records, $recordsmatrix)
{
    $output = '';
    $selected = '';

    if (count((array)$records) > 0 || count((array)$recordsmatrix) > 0) {
  $class = 'bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2
          dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300';
       // $class ='text-red-500';

        $output .= '<select aria-label="label" name="epin_type"
         class="'.$class.'"text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" onchange="showPackageAmount(this.value)"  required aria-describedby="epintype-error">

         <option value="">' . __('Select') . '</option>';

        // MATRIX OPTIONS (objects)
        foreach ($recordsmatrix as $row) {

            $matrix_id = $row->matrix_id;   // <-- FIXED
            $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
            $matrixname = $matrixdetails['matrix_name'] ?? 'Matrix';

        }
// dd($recordsmatrix);
        // PACKAGE OPTIONS (object or array)





        foreach ($records as $rec) {

            // detect if object or array
            $package_id  = is_object($rec) ? $rec->package_id  : $rec['package_id'];
            $matrix_name = is_object($rec) ? $rec->matrix_name  : $rec['matrix_name'];
            $package_name = is_object($rec) ? $rec->package_name : $rec['package_name'];

            $selected = (isset($err_perferred_payment_id) && $err_perferred_payment_id == $package_id)
                ? 'selected="selected"' : '';

            $output .= '<option value="' . $package_id . ',1" ' . $selected . '>' .
                $matrix_name . ' - ' . $package_name . '</option>';
        }

        // dd($records);
        // EWALLET
        $output .= '<option value="100000000000001">' . __('Ewallet') . '</option>';

        $output .= '</select>';
    }
    // dd($output);
    return $output;
}

}

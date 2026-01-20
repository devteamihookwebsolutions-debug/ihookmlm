<?php

/**
 * This class contains public functions related to DMatrixBinary
 *
 * @package         DMatrixBinary
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Display\MatrixConfig;
use Illuminate\Http\Request;


class DMatrixBinary
{

    public static function getBinaryRatio($records, $name, $id, $editable)
    {
        // Use request()->query() to get 'classname' from the URL query string
        $class = request()->query('classname', 'form-control select2');

        $output = '';  // Initialize output

        if (count($records) > 0) {
            $output .= '<select aria-label="label" id="' . e($id) . '" class="' . e($class) . '" name="' . e($name) . '">';

            foreach ($records as $record) {
                $selected = ($editable == trim($record['binaryratio_id'])) ? 'selected="selected"' : '';
                $output .= '<option value="' . e($record['binaryratio_id']) . '" ' . $selected . '>' . e($record['binaryratio']) . '</option>';
            }

            $output .= '</select>';
        }

        return $output;
    }

    public static function getCarryOver($records, $name, $id, $editable)
    {
        // Get class from request or fallback
        $class = request()->query('classname', 'form-control select2');

        $output = '';

        if (count($records) > 0) {
            $output .= '<select aria-label="label" id="' . e($id) . '" class="' . e($class) . '" name="' . e($name) . '">';
            foreach ($records as $record) {
                $selected = ($editable == trim($record['carryover_id'])) ? 'selected="selected"' : '';
                $output .= '<option value="' . e($record['carryover_id']) . '" ' . $selected . '>' . e($record['carryover']) . '</option>';
            }
            $output .= '</select>';
        }

        return $output;
    }



}

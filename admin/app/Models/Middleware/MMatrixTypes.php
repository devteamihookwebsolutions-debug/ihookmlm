<?php

/**
 * This class contains public functions related to MMatrixTypes
 *
 * @package         MMatrixTypes
 * @category        Model
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
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\MatrixType;
use Admin\App\Display\Middleware\DMatrixTypes;


class MMatrixTypes
{

    public static function getMatrixTypes($matrix_type_id)
    {
        try {
            $matrixTypes = MatrixType::orderBy('matrix_type_id', 'asc')->get();


            // Assuming DMatrixTypes::getMatrixTypes() processes the result
            return DMatrixTypes::getMatrixTypes($matrixTypes->toArray(), $matrixTypes->count(), $matrix_type_id);
        } catch (\Exception $e) {
            // Return a default <select> element (not ideal – better to pass data to view or API)
            return '<div class="col-md-9">
                <select aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" required aria-describedby="matrixtypeid-error">
                    <option value="">' . __('Select') . '</option>
                </select>
            </div>';
        }
    }

    public static function getMatrixTypeDetails($where)
    {
        return MatrixType::where($where)->get();
    }

}

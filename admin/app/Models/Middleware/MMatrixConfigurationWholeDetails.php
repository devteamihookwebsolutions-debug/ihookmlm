<?php

/**
 * This class contains public functions related to MMatrixConfigurationWholeDetails
 *
 * @package         MMatrixConfigurationWholeDetails
 * @category        Model
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
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\MatrixConfiguration;
use Illuminate\Http\Request;

class MMatrixConfigurationWholeDetails
{

    public static function getMatrixConfigurationWholeDetails(string $matrixId)
    {
        $output = [];

        // Fetch matching records using Eloquent
        $records = MatrixConfiguration::where('matrix_id', $matrixId)
            ->orderBy('matrix_configuration_id', 'asc')  // Fixed typo
                    ->get();

        // Build the output array
        foreach ($records as $record) {
            $output[$record->matrix_key] = $record->matrix_value;
        }

        return $output;
    }
}

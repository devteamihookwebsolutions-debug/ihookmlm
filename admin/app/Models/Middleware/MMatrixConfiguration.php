<?php

/**
 * This class contains public functions related to MMatrixConfiguration
 *
 * @package         MMatrixConfiguration
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

class MMatrixConfiguration
{
       public static function getMatrixConfigurationDetails($matrix_id, $matrix_key)
    {
        $result = MatrixConfiguration::where('matrix_id', $matrix_id)
            ->where('matrix_key', $matrix_key)
            ->first();
            // dd($result);

        return $result?->matrix_value ?? '';
    }
        public static function getMatrixConfigurationDetail($matrix_id, $matrix_key)
    {

        return MatrixConfiguration::where('matrix_id', $matrix_id)
            ->where('matrix_key', $matrix_key)
            ->get();
    }
}

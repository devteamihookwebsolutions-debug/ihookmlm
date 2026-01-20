<?php

/**
 * This class contains public functions related to MMatrixtTypeDetails
 *
 * @package         MMatrixtTypeDetails
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

use Admin\App\Models\Member\Matrix;
use Illuminate\Database\Eloquent\Model;

class MMatrixtTypeDetails extends Model
{
    public static function getMatrixTypeDetails($matrixId = null)
    {
        if (!$matrixId) {
            return [];
        }

        $matrix = Matrix::where('matrix_id', $matrixId)->first();

        return $matrix ? $matrix->toArray() : [];
    }
}

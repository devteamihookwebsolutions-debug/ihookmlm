<?php
namespace Admin\App\Models\PaymentConquest;
use Admin\App\Models\Member\PaymentHistory;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\MatrixConfiguration;

use DateTime;

class MMembersMatrixLevelComplete
{

 public static function checkLevelComp($memberId, $matrixId)
    {
        // Get matrix type
        $matrix = Matrix::find($matrixId);
        if (!$matrix) {
            return 1; // fallback if not found
        }

        $matrixTypeId = $matrix->matrix_type_id;

        // Get configuration values
        $levelDeep = MatrixConfiguration::where('matrix_id', $matrixId)
            ->where('matrix_key', 'level_deep')
            ->value('matrix_value');

        $levelWidth = MatrixConfiguration::where('matrix_id', $matrixId)
            ->where('matrix_key', 'level_width')
            ->value('matrix_value');

        // Determine width and deep
        if ($matrixTypeId == 1) { // Binary matrix
            $width = 2;
            $deep = 9999;
        } else {
            $width = $levelWidth == 0 ? 9999 : $levelWidth;
            $deep = $levelDeep == 0 ? 9999 : $levelDeep;
        }


        // Calculate max level value
        $val = self::calculateSum($width, $deep);

        if (is_numeric($val)) {
            $totalReferral = MemberLinks::where('matrix_id', $matrixId)
                ->whereRaw("FIND_IN_SET(?, members_parents)", [$memberId])
                ->count();

            return $totalReferral < $val ? 1 : 0;
        }

        return 1;
    }

    public static function calculateSum($width, $deep)
    {
        $sum = 0;
        for ($i = 1; $i <= $deep; $i++) {
            $sum += pow($width, $i);
        }
        return $sum;
    }



}
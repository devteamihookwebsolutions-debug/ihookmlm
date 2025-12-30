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
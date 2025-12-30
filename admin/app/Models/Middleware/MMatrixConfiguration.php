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

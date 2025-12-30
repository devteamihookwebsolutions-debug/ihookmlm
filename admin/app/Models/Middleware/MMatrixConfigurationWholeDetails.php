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
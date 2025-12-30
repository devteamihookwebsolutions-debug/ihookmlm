<?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\Matrix;
use DateTime;
use Illuminate\Support\Facades\DB;   // THIS WAS MISSING

class MMatrixDetails
{

    public static function getDefaultMatrix()
    {

        $matrix = Matrix::where('matrix_status', 1)
                        ->where('matrix_default', 1)
                        ->first();
                        // dd($matrix);

        return $matrix->matrix_id;
    }


public static function getAllActiveMatrices()
{
    return DB::table('ihook_matrix_table')
        ->select('matrix_id', 'matrix_name')
        ->where('matrix_status', 1)
        ->orderBy('matrix_name')
        ->get()
        ->map(function ($item) {
            return (array) $item; // Cast stdClass → array
        })
        ->values()
        ->toArray();
}

    // OPTIONAL – if you want only matrices the member has joined
    public static function getMemberMatrices($memberId)
    {
        // dd($memberId);
        return DB::table('ihook_matrix_members_link_table AS link')
            ->join('matrix AS m', 'link.matrix_id', '=', 'm.matrix_id')
            ->where('link.members_id', $memberId)
            ->select('m.matrix_id', 'm.matrix_name')
            ->distinct()
            ->orderBy('m.matrix_name')
            ->get()
            ->toArray();
    }


    public static function getMatrixDetails($matrix_id)
    {

        $matrix = Matrix::where('matrix_id', $matrix_id)->first();
// dd($matrix);
        return  $matrix;
    }

    public function getWhereMatrixDetails(array $where)
    {
        return Matrix::where($where)->get();
    }

    public function getMatrixDetailsParam($param, $matrix_id)
    {
        return Matrix::where('matrix_id', $matrix_id)->first($param);
    }
}

<?php
namespace Admin\App\Models\Genealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;


class MGenealogy
{

 public  static function getCryptData(Request $request)
    {
        // dd('hlk');
        // Get matrix_id from request, default to 1
        $matrix_id = $request->input('matrix_id', 1);

        // Fetch the matrix record
        $matrix = Matrix::where('matrix_status', '1')
                        ->where('matrix_id', $matrix_id)
                        ->orderBy('matrix_id', 'asc')
                        ->first();

        if (!$matrix) {
            return response()->json(['error' => 'Matrix not found'], 404);
        }

        // Fetch the configuration record manually
        $config = MatrixConfiguration::where('matrix_id', $matrix->matrix_id)
                                     ->where('matrix_key', 'default_sponsor')
                                     ->first();

        if (!$config) {
            return response()->json(['error' => 'Matrix configuration not found'], 404);
        }

        // Generate encrypted URL
        $crypturl = MURLCrypt::getEncryptURL($matrix->matrix_id, $config->matrix_value);

        // Store in session
        Session::put('genealogylinkcrypt', $crypturl);

        return response()->json(['crypt_url' => $crypturl]);
    }

    public static function getActiveMatrixList($encoded_id)
{
    // Decrypt URL parameters
    $decryptUrl = MURLCrypt::getDecryptURL($encoded_id);
    $members_id = $decryptUrl[0];
    $matrix_id  = $decryptUrl[1];

    // Get active matrices
    $defaultmatrix = Matrix::where('matrix_status', 1)->get();

    return $defaultmatrix;
}



}




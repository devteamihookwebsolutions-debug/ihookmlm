<?php

/**
 * This class contains public functions related to MMatrix
 *
 * @package         MMatrix
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

namespace Admin\App\Models\MatrixConfig;
use Admin\App\Models\Member\MatrixType;

use Illuminate\Database\Eloquent\Model;

class MMatrix extends Model
{
    protected $table = 'ihook_matrix_table';
    protected $primaryKey = 'matrix_id';
    public $timestamps = false;

    protected $fillable = [
        'matrix_name',
        'matrix_type_id',
        'matrix_status',
        'matrix_default',
        'created_on',
        'created_by',
    ];


    public function matrixType()
    {
        return $this->belongsTo(MatrixType::class, 'matrix_type_id', 'matrix_type_id');
    }

    public function packages()
    {
        return $this->hasMany(MSetMatrixConfiguration::class, 'matrix_id', 'matrix_id');
    }

    public static function getMatrixDetails($matrixId)
    {
        return self::with('matrixType')->findOrFail($matrixId);
    }

    public static function showMatrix()
    {
        return self::with('matrixType')->paginate(10);
    }

    public static function getMatrixTypesWizard($matrixTypeId = null)
    {
        return MatrixType::when($matrixTypeId, function ($query, $matrixTypeId) {
            return $query->where('matrix_type_id', $matrixTypeId);
        })->get();
    }

    public static function checkMatrixName($matrixName)
    {
        return self::where('matrix_name', $matrixName)->exists();
    }

   public static function insertMatrix($data)
{
    return self::create($data);
}
}

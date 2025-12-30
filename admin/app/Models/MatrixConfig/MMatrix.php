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

<?php

namespace Admin\App\Models\MatrixConfig;

use Illuminate\Database\Eloquent\Model;

class MatrixType extends Model
{
    protected $table;
    protected $primaryKey = 'matrix_type_id';
    public $timestamps = false;
    protected $fillable = ['matrix_type_name', 'matrix_image_path'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('IHOOK_PREFIX', 'ihook_') . 'matrix_type_table';
    }

    public function matrices()
    {
        return $this->hasMany(MMatrix::class, 'matrix_type_id', 'matrix_type_id');
    }
}
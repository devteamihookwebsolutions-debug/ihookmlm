<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class MatrixConfiguration extends Model
{
    protected $table = 'ihook_matrix_configuration_table';
    protected $primaryKey = 'matrix_configuration_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'matrix_configuration_id',
        'matrix_key',
        'matrix_value',
        'matrix_id',
        'created_on',
        'created_by',
    ];
}

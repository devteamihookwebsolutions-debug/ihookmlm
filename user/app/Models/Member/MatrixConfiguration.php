<?php

namespace User\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class MatrixConfiguration extends Model
{
    protected $table = 'ihook_matrix_configuration_table'; 
    public $timestamps = false;

      
    protected $fillable = [

        'matrix_key',
        'matrix_value',
        'matrix_id',
        'created_on',
        'created_by',
        // add other fields you want mass assignable here
    ];
}
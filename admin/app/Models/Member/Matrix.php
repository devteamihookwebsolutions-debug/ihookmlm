<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    protected $table = 'ihook_matrix_table'; 
    public $timestamps = false; 
    protected $primaryKey = 'matrix_id';
}
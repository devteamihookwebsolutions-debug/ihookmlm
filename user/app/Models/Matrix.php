<?php

namespace User\App\Models;

use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    protected $table = 'ihook_matrix_table';
    protected $primaryKey = 'matrix_id';
    public $timestamps = false;



    
public function links()
    {
        return $this->hasMany(MatrixMemberLink::class, 'matrix_id', 'matrix_id');
    }
}

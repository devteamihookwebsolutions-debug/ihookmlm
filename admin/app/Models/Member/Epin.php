<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Epin extends Model
{
    
       protected $table = 'ihook_epin_table';
      
        protected $fillable = [
    'epin_member_id',
    'epin_code',
    'epin_amount',
    'epin_date',
    'epin_package',
    'epin_matrix_id',
    'epin_status',
    'epin_user_id',
    'epin_used_date',
    'payment_history_id',
];
  public $timestamps = false;
}

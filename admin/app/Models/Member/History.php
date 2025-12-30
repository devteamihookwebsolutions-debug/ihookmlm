<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    
       protected $table = 'ihook_history_table';
       protected $primaryKey = 'history_id';
       public $timestamps = false;
         protected $fillable = [
        'history_member_id',
        'history_members_ref_id',
        'history_amount',
        'history_type',
        'history_description',
        'history_datetime',
        'history_payment',
        'history_transaction_id',
        'updated_on',
    ];
}

<?php

namespace User\App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'ihook_paymenthistory_table';
    public $timestamps = false;
     protected $fillable = [
    'paymenthistory_member_id',
    'paymenthistory_amount',
    'payment_amt_exclusive',   // if exists
    'paymenthistory_mode',
    'paymenthistory_trans_id',
    'paymenthistory_date',     // if auto-filled
    'paymenthistory_type',
    'paymenthistory_status',
    'paymenthistory_plan_id',
    'matrix_id',
    ];

}

<?php

namespace Admin\App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'ihook_paymenthistory_table';
    public $timestamps = false;
    protected $primaryKey = 'paymenthistory_id';
}

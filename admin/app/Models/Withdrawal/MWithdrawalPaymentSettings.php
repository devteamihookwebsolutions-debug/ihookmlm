<?php

namespace Admin\App\Models\Withdrawal;

use Illuminate\Database\Eloquent\Model;

class MWithdrawalPaymentSettings extends Model
{
    protected $table      = 'ihook_withdrawpaymentsettings_table';
    protected $primaryKey = 'paymentsettings_id';
    public $timestamps    = false;

    protected $fillable = [
        'paymentsettings_name',
        'paymentsettings_default_name',
        'paymentsettings_accname',
        'paymentsettings_accnum',
        'paymentsettings_image_path',
        'paymentsettings_description',
        'paymentsettings_status',
        'paymentsettings_view_status',
        'paymentsettings_type',
        'paymentsettings_mode',
        'instantpayout_status',
        'payout_apivalues',
        'paymentsettings_apipwd',
        'paymentsettings_sciname',
        'paymentsettings_scipwd',
        'payment_testurl',
        'payment_liveurl',
    ];

    protected $casts = [
        'payout_apivalues' => 'array',
    ];
}

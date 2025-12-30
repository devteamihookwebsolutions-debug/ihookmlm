<?php
namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'ihook_paymentsettings_table';
    protected $primaryKey = 'paymentsettings_id';
    public $timestamps = false;

    protected $fillable = [
        'paymentsettings_accname',
        'paymentsettings_accnum',
        'paymentsettings_status',
        'instantpayout_status',
        'payout_apivalues',
        'paymentsettings_mode',
        'paymentsettings_name',
        'paymentsettings_default_name',
        'paymentsettings_image_path',
        'paymentsettings_description',
        'paymentsettings_type'
    ];
}

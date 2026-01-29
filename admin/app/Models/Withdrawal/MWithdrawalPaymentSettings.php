<?php

/**
 * This class contains public functions related to MWithdrawalPaymentSettings
 *
 * @package         MWithdrawalPaymentSettings
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Withdrawal;

use Illuminate\Database\Eloquent\Model;

class MWithdrawalPaymentSettings extends Model
{
    protected $table;
    protected $primaryKey = 'paymentsettings_id';
     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_withdrawpaymentsettings_table';
    }
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

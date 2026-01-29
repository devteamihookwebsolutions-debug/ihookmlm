<?php

/**
 * This class contains public functions related to PaymentHistory
 *
 * @package         PaymentHistory
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

namespace Admin\App\Models\MemberArea;

use Admin\App\Models\MatrixConfig\MMatrix;
use Admin\App\Models\Member\Package;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table;
    protected $primaryKey = 'paymenthistory_id';
      public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_paymenthistory_table';
    }
    public $timestamps = false;

    protected $fillable = [
        'paymenthistory_member_id','paymenthistory_amount','payment_amt_exclusive',
        'paymenthistory_mode','paymenthistory_trans_id','producthistory_totalproduct',
        'paymenthistory_date','paymenthistory_type','identify_type','paymenthistory_status',
        'paymenthistory_plan_id','matrix_id','product_id','transaction_id',
        'coinpayment_status','blockio_user_id','blockio_label','blockio_address',
        'equivalent_crypto_currency','payment_invoice_path','tax_details',
        'payment_gateway_response','payment_user_request_currency_id','course_id',
        'payment_user_request_amount','payment_onetime_fee','crypto_qty',
        'currency_id','created_on'
    ];

    protected $casts = [
        'paymenthistory_date' => 'datetime',
        'created_on'          => 'datetime',
        'tax_details'         => 'array',
        'payment_gateway_response' => 'array',
    ];

    /** Human readable payment mode */
    public function getModeLabelAttribute(): string
    {
        return match ($this->paymenthistory_mode) {
            1 => 'Crypto (BTC/ETH/USDT…)',
            2 => 'PayPal',
            3 => 'E-Wallet',
            default => 'Unknown',
        };
    }

    /** Human readable type */
    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->paymenthistory_type);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'paymenthistory_plan_id', 'package_id');
    }

    public function matrix()
    {
        return $this->belongsTo(MMatrix::class, 'matrix_id', 'matrix_id');
    }

    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->paymenthistory_amount, 2);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->paymenthistory_date?->format('d M Y') ?? '—';
    }

    public function getIsCurrentAttribute(): bool
    {
        return $this->paymenthistory_status == 1;
    }

    public function member()
    {
        return $this->belongsTo(MemberAreaSummary::class, 'paymenthistory_member_id', 'members_id');
    }
}

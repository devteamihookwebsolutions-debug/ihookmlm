<?php

/**
 * This class contains public functions related to MemberHistrory
 *
 * @package         MemberHistrory
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace User\App\Models\MemberArea;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MemberHistrory extends Model
{
    protected $table = 'ihook_history_table';
    protected $primaryKey = 'history_id';
    public $timestamps = false;

    protected $fillable = [
        'history_member_id','history_members_ref_id','history_customers_ref_id',
        'history_type','history_description','history_datetime','history_payment',
        'history_nowithdraw','history_amount','history_transaction_id','history_plan_id',
        'history_link_id','history_fund_transfer_from_to_id','history_wallet_type',
        'history_matrix_id','account_id','history_order_id','history_rank_level',
        'history_binary_commission_type','updated_on','bonusid','history_binary_pairs',
        'notification_status','party_id','gift_product_sku','gift_product_sku_order_id',
        'payquicker_request','withdrawal_coin_type','push_notification','crypto_qty',
        'currency_id'
    ];
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->history_datetime)->format('d M Y');
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->history_amount, 2);
    }

    public function getStatusAttribute()
    {
        // map the enum value to a readable label
        return match ($this->history_type) {
            'withdraw_pending' => 'Pending',
            'withdrawal'       => 'Processing',
            'withdrawcompleted'=> 'Completed',
            default            => ucfirst(str_replace('_', ' ', $this->history_type)),
        };
    }
      public function member()
    {
        return $this->belongsTo(MemberAreaSummary::class, 'history_member_id', 'members_id');
    }
}

<?php

/**
 * This class contains public functions related to MemberPersonalPurchase
 *
 * @package         MemberPersonalPurchase
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

namespace Admin\App\Models\MemberArea;

use Illuminate\Database\Eloquent\Model;

class MemberPersonalPurchase extends Model
{
    protected $table = 'ihook_order_table';
    protected $primaryKey = 'ihook_order_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'order_total',
        'created_on',
        'members_id',
    ];

    // Relationship to Member model
    public function member()
    {
        return $this->belongsTo(MemberAreaSummary::class, 'members_id', 'members_id');
    }
}

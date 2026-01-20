<?php

/**
 * This class contains public functions related to MemberLinks
 *
 * @package         MemberLinks
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

namespace Admin\App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class MemberLinks extends Model
{
   protected $table = 'ihook_matrix_members_link_table';

    protected $primaryKey = 'link_id';
    public $timestamps = false;

    public $incrementing = true;
    protected $keyType = 'int';

    // Add fillable columns that you are saving
    protected $fillable = [
        'members_id',
        'matrix_id',
        'spillover_id',
        'direct_id',
        'root',
        'members_parents',
        'members_account_status',
        'members_status',
        'matrix_doj',
        'members_subscription_plan',
        'members_subscription_date',
        'members_subscription_status',
        'members_subscription_expirydate',
        'moduletype',
        'user_type',
        'stripe_cusid',
        'stripe_subid',
        'chargebee_subid',
        'position',
        'default_leg'
    ];
}

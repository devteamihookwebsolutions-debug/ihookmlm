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

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

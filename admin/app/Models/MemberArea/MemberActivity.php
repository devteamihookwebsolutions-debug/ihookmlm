<?php

namespace Admin\App\Models\MemberArea;

use Illuminate\Database\Eloquent\Model;

class MemberActivity extends Model
{
    protected $table = 'ihook_members_log_table';
    protected $primaryKey = 'members_log_id';
    public $incrementing = true;
    
    // CORRECT: Use 'int', NOT 'bigint'
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'members_log_members_id',
        'members_log_ip_used',
        'log',
        'doname',
        'members_log_time',
        'created_at',
        'created_by',
    ];

    protected $casts = [
        'members_log_time' => 'datetime:Y-m-d H:i:s',
        'created_at'       => 'datetime',
        'members_log_id'   => 'int',
    ];

    public function member()
    {
        return $this->belongsTo(
            \Admin\App\Models\MemberArea\MemberAreaSummary::class,
            'members_log_members_id',
            'members_id'
        );
    }
}
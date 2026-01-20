<?php

/**
 * This class contains public functions related to MemberActivity
 *
 * @package         MemberActivity
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
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

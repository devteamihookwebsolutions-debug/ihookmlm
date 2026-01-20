<?php

/**
 * This class contains public functions related to MatrixMemberLink
 *
 * @package         MatrixMemberLink
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

namespace User\App\Models;

use Illuminate\Database\Eloquent\Model;

class MatrixMemberLink extends Model
{
    protected $table = 'ihook_matrix_members_link_table';
    protected $primaryKey = 'link_id';
    public $timestamps = false;

    protected $fillable = [
        'members_id', 'matrix_id', 'position', 'members_parents',
        'root', 'left_most_members_id', 'right_most_members_id'
    ];

    public function matrix()
    {
        return $this->belongsTo(Matrix::class, 'matrix_id', 'matrix_id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'members_id', 'members_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'spillover_id', 'members_id')
                    ->where('matrix_id', $this->matrix_id);
    }

    /** -------------------------------------------------
     *  Helper: get links for a member + matrix
     *  ------------------------------------------------- */
    public static function forMemberAndMatrix($memberId, $matrixId)
    {
        return static::where('members_id', $memberId)
                     ->where('matrix_id', $matrixId)
                     ->orderByDesc('link_id')
                     ->first();
    }
}

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

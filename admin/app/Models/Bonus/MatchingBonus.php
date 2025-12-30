<?php

namespace Admin\App\Models\Bonus;

use Admin\App\Models\MatrixConfig\MMatrix;
use Illuminate\Database\Eloquent\Model;

class MatchingBonus extends Model
{
    protected $table = 'ihook_matchingbonus';
    protected $primaryKey = 'matchbonus_id';
    public $incrementing = true;
    public $timestamps = true;
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'matrix_id',
        'matchbonus_name',
        'commission_based_on',
        'commission_sent_type',
        'matchingbonus_status',
        'created_by',
        'updated_by',
    ];

    // Relationships
    public function matrix()
    {
        return $this->belongsTo(MMatrix::class, 'matrix_id', 'matrix_id');
    }

    public function links()
    {
        return $this->hasMany(MatchingBonusLink::class, 'matchbonus_id', 'matchbonus_id');
    }

    // Check if bonus name exists
    public static function checkNameExists($name, $matrix_id, $exclude_id = null)
    {
        $query = self::where('matchbonus_name', $name)->where('matrix_id', $matrix_id);
        if ($exclude_id) {
            $query->where('matchbonus_id', '!=', $exclude_id);
        }
        return $query->exists();
    }
}

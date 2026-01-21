<?php

/**
 * This class contains public functions related to MatchingBonus
 *
 * @package         MatchingBonus
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

namespace Admin\App\Models\Bonus;

use Admin\App\Models\MatrixConfig\MMatrix;
use Illuminate\Database\Eloquent\Model;

class MatchingBonus extends Model
{
    protected $table;
    protected $primaryKey = 'matchbonus_id';
     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_matchingbonus';
    }
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

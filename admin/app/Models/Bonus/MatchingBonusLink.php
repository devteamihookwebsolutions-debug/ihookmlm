<?php

/**
 * This class contains public functions related to MatchingBonusLink
 *
 * @package         MatchingBonusLink
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

use Illuminate\Database\Eloquent\Model;
use Admin\App\Models\Rank\RankSetting;

class MatchingBonusLink extends Model
{
    protected $table = 'ihook_matchingbonus_link';
    protected $primaryKey = 'matchingbonus_link_id';
    public $timestamps = false;
    protected $fillable = [
        'matchbonus_id',
        'levels',
        'commission_amount',
        'commission_type',
        'wallet_type',
        'rank_id',
        'commission_percentage_from',
    ];

    public function matchingBonus()
    {
        return $this->belongsTo(MatchingBonus::class, 'matchbonus_id', 'matchbonus_id');
    }

    public function rank()
    {
        return $this->belongsTo(RankSetting::class, 'rank_id', 'rank_id');
    }
}

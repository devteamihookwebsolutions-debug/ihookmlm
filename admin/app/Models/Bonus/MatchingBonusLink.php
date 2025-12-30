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

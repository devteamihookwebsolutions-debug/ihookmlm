<?php

namespace Admin\App\Models\Rank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankLevelCommission extends Model
{
    use HasFactory;

    protected $table = 'ihook_rank_levelcommission';
    protected $fillable = ['rank_id', 'level', 'commission'];
    public $timestamps = false;
}
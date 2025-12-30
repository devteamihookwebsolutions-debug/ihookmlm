<?php

namespace User\App\Models\Rank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankSetting extends Model
{
    use HasFactory;

    protected $table = 'ihook_ranksetting';
    protected $fillable = ['rank_id', 'matrix_id', 'rank_key', 'rank_value'];
    public $timestamps = false;
}
<?php

namespace Admin\App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class RankSetting extends Model
{
    protected $table = 'ihook_ranksetting';
    public $timestamps = false;
    protected $primaryKey = 'id';
}

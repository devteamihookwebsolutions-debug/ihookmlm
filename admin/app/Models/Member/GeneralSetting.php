<?php

namespace Admin\App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
     protected $table = 'ihook_generalsettings_table';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'generalsettings_name',
        'generalsettings_value',
    ];
}

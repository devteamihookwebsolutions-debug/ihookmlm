<?php

namespace Admin\App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'ihook_sitesettings_table';
    public $timestamps = false;
    protected $primaryKey = 'sitesettings_id';
      protected $fillable = [
        'sitesettings_name',
        'sitesettings_value'
    ];
}

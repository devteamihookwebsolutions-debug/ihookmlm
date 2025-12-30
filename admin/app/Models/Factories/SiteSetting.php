<?php

namespace Admin\App\Models\Factories;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'ihook_sitesettings_table';
    protected $primaryKey = 'sitesettings_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'sitesettings_name',
        'sitesettings_value',
        'sitesettings_description',
    ];
}

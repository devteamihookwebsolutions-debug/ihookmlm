<?php

namespace Admin\App\Models\Factories;

use Illuminate\Database\Eloquent\Model;

class SiteSettingStatus extends Model
{
    protected $table = 'ihook_sitesettings_status_table';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'site_settings',
        'side_matrix_link',
        'replicatingedit',
        'member_image',
        'site_currency',
        'update_on',
    ];
}
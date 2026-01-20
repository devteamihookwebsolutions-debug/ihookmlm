<?php

/**
 * This class contains public functions related to State
 *
 * @package         State
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

namespace User\App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'ihook_state_table';
    protected $primaryKey = 'state_id';
    public $incrementing = true; // Enable auto-increment for state_id
    protected $fillable = ['state_code', 'state_name', 'country_code'];

    public function country()
    {
        return $this->belongsTo(CountryMaster::class, 'country_code', 'country_master_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'state_id');
    }
}

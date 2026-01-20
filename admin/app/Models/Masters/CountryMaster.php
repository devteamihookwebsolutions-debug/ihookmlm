<?php

/**
 * This class contains public functions related to CountryMaster
 *
 * @package         CountryMaster
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

namespace Admin\App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryMaster extends Model {
    use HasFactory;

    protected $table = 'ihook_country_master_table';
    protected $primaryKey = 'country_master_id';
    public $incrementing = true;
    // Enable auto-increment for country_master_id
    protected $fillable = [ 'sortname', 'country_master_name' ];


    public function cities() {
        return $this->hasMany( City::class, 'country_id', 'country_master_id' );
    }
}

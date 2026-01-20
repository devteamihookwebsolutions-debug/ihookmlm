<?php

/**
 * This class contains public functions related to CustomerBonus
 *
 * @package         CustomerBonus
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

namespace Admin\App\Models\CustomerBonus;

use Illuminate\Database\Eloquent\Model;

class CustomerBonus extends Model
{
    protected $table = 'ihook_customerbonus_meta';
    protected $primaryKey = 'meta_id';
    public $timestamps = true;

    protected $fillable = [
        'meta_key',
        'meta_value',
        'created_on',
        'updated_on',
    ];

    // Define timestamps fields explicitly
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    /**
     * Get bonus details as an associative array
     */
    public static function getBonusDetails()
    {
        $records = self::all()->pluck('meta_value', 'meta_key')->toArray();
        return $records;
    }

    /**
     * Update or create bonus details
     */
    public static function updateBonusDetails(array $data)
    {
        foreach ($data as $key => $value) {
            self::updateOrCreate(
                ['meta_key' => $key],
                [
                    'meta_value' => $value,
                    'updated_on' => now(),
                ]
            );
        }
    }
}

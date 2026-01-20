<?php

/**
 * This class contains public functions related to GenerationBonusLinkTable
 *
 * @package         GenerationBonusLinkTable
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Bonus;

use Illuminate\Database\Eloquent\Model;

class GenerationBonusLinkTable extends Model
{
    protected $table = 'ihook_generation_bonuslinktable';
    protected $primaryKey = 'generationalbonus_link_id';
    public $timestamps = false;

    protected $fillable = [
        'metakey',
        'metavalue',
        'matrix_id',
    ];

    /**
     * Store multiple key-value pairs for a given matrix_id
     */
    public static function storeKeyValuePairs(array $data, $matrix_id)
    {
        // Delete existing records for the matrix_id to avoid duplicates
        self::where('matrix_id', $matrix_id)->delete();

        // Store new key-value pairs
        foreach ($data as $key => $value) {
            if ($value !== null && $value !== '') {
                self::create([
                    'matrix_id' => $matrix_id,
                    'metakey' => $key,
                    'metavalue' => $value,
                ]);
            }
        }
    }

    /**
     * Update key-value pairs for a given matrix_id
     */
    public static function updateKeyValuePairs(array $data, $matrix_id)
    {
        // Use storeKeyValuePairs to handle updates (deletes and re-inserts)
        self::storeKeyValuePairs($data, $matrix_id);
    }

    /**
     * Get key-value pairs for a given matrix_id
     */
    public static function getKeyValuePairs($matrix_id)
    {
        return self::where('matrix_id', $matrix_id)
            ->pluck('metavalue', 'metakey')
            ->toArray();
    }

    /**
     * Delete key-value pairs for a given matrix_id
     */
    public static function deleteByMatrixId($matrix_id)
    {
        return self::where('matrix_id', $matrix_id)->delete();
    }
}

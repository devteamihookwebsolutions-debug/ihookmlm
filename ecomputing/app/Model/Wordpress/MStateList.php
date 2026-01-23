<?php

/**
 * This class contains public functions related to MStateList
 *
 * @package         MStateList
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Ecomputing\App\Model\Wordpress;
use Ecomputing\App\Display\Wordpress\DStateList;
use Illuminate\Support\Facades\DB;

class MStateList
{
   /**
     * This public function is used  to get state list
     * @param mixed $id
     * @return mixed|null
     */
    public function getStateList($id)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $records =DB::table($prefix . 'state_table')
            ->where('country_id', $id)
            ->orderBy('state_name', 'asc')
            ->get()
            ->map(function ($r) {
                return (array) $r;
            })
            ->toArray();
        if (!empty($records)) {
            $dstate = new DStateList();
            return $dstate->getStateList($records);
        }

        return null;
    }

    /**
     * This public function is used  to get state name
     * @param int $state_id
     * @return  string|null
     */
    public function getStateName($state_id)
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $record =DB::table($prefix . 'state_table')
            ->where('state_id', $state_id)
            ->first();

        if (!$record) {
            return null;
        }

        $row = (array) $record;
        return $row['name'] ?? $row['state_name'] ?? null;
    }
}

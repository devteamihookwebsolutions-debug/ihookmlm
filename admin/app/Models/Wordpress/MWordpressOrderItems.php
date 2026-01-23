<?php
/**
 * This class contains public static functions related to MWordpressOrderItems
 *
 * @package         MWordpressOrderItems
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?><?php
namespace Admin\App\Models\Wordpress;
use Illuminate\Support\Facades\DB;

class MWordpressOrderItems{


public static function getOrderedItems($where = null)
{
    $storePrefix = config('services.ihook.store_prefix');
    $table = $storePrefix . '_woocommerce_order_items';

    $query = DB::table($table);

    if (!empty($where)) {
        $query->whereRaw($where);
    }

    // Fetch records
    $records = $query->get()->toArray();

    return $records;
}

}

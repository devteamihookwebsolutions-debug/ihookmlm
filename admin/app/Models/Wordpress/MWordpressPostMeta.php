<?php
/**
 * This class contains public static functions related to WordpressPost Meta.
 *
 * @package         MWordpressPostMetas
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
class MWordpressPostMeta
{

    public static function getShopPostMeta($where = null)
    {
        $storePrefix = config('services.ihook.store_prefix'); // e.g., 'wp_'
        $table = $storePrefix . '_postmeta';

        $query = DB::table($table);

        if (!empty($where)) {
            $query->whereRaw($where); // use raw if $where is a raw SQL string
        }

        $records = $query->get()->toArray();

        return $records;
    }

    /**
     * Execute a raw query and return results
     */
    public static function getShopParamValue($sqlq)
    {
        $records = DB::select($sqlq); // DB::select executes raw SQL

        return $records;
    }

    /**
     * Get postmeta for a specific post_id and meta_key
     */
    public static function getShopPartParamValue($param, $post_id)
    {
        $storePrefix = config('services.ihook.store_prefix'); // e.g., 'wp_'
        $table = $storePrefix . '_postmeta';

        $records = DB::table($table)
            ->where('post_id', $post_id)
            ->where('meta_key', $param)
            ->get()
            ->toArray();

        return $records;
    }


}

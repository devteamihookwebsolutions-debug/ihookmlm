<?php
/**
 * This class contains public static functions related to get wordpress product details.
 *
 * @package         MFetchShopProduct
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright        Copyright (c) 2025 - 2026, Ihook.
 * @version        Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\ShopAncillary;
use Illuminate\Support\Facades\DB;
class MFetchShopProduct {


public static function getShopProduct($where)
{
    $storeprefix = config('services.ihook.store_prefix');

    $query = DB::table($storeprefix . '_posts')
        ->select(
            $storeprefix . '_posts.ID',
            $storeprefix . '_posts.post_name',
            $storeprefix . '_posts.post_status',
            $storeprefix . '_posts.post_title',
            $storeprefix . '_posts.post_content',
            $storeprefix . '_posts.post_date',
            $storeprefix . '_users.user_nicename',
            DB::raw("(SELECT meta_value FROM {$storeprefix}_postmeta WHERE meta_key='_regular_price' AND post_id={$storeprefix}_posts.ID LIMIT 1) AS regular_price"),
            DB::raw("(SELECT meta_value FROM {$storeprefix}_postmeta WHERE meta_key='_sale_price' AND post_id={$storeprefix}_posts.ID LIMIT 1) AS sales_price"),
            DB::raw("(SELECT meta_value FROM {$storeprefix}_postmeta WHERE meta_key='_stock_status' AND post_id={$storeprefix}_posts.ID LIMIT 1) AS stock_status"),
            DB::raw("(SELECT meta_value FROM {$storeprefix}_postmeta WHERE meta_key='_tax_status' AND post_id={$storeprefix}_posts.ID LIMIT 1) AS tax_status"),
            DB::raw("(SELECT meta_value FROM {$storeprefix}_postmeta WHERE meta_key='_sku' AND post_id={$storeprefix}_posts.ID LIMIT 1) AS sku")
        )
        ->leftJoin($storeprefix . '_users', $storeprefix . '_users.ID', '=', $storeprefix . '_posts.post_author');

    // Apply dynamic where clause if provided
    if (!empty($where)) {
        $query->whereRaw($where);
    }

    return $query->get();
}

}
?>

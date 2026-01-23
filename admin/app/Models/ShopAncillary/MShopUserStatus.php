<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MShopProduct
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
?>
<?php
namespace Admin\App\Models\ShopAncillary;
use Illuminate\Support\Facades\DB;

class MShopUserStatus{

public static function changeUserStatus($members_shop_id, $status)
{
    $storeprefix = config('services.ihook.store_prefix');

    if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 1) {
        // Get the existing meta value
        $meta = DB::table($storeprefix . '_usermeta')
                    ->where('user_id', $members_shop_id)
                    ->where('meta_key', 'user_active_status')
                    ->value('meta_value');

        if ($meta === 'yes' && !empty($meta)) {
            // Update the existing record
            DB::table($storeprefix . '_usermeta')
                ->where('user_id', $members_shop_id)
                ->where('meta_key', 'user_active_status')
                ->update(['meta_value' => $status]);
        } else {
            // Insert new record
            DB::table($storeprefix . '_usermeta')->insert([
                'user_id'    => $members_shop_id,
                'meta_key'   => 'user_active_status',
                'meta_value' => $status,
            ]);
        }
    }
}

}

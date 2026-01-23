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
namespace Admin\App\Models\Wordpress;

use Admin\App\Lib\PasswordHash;
use Illuminate\Support\Facades\DB;
class MWordPressSetPassword {
  public static function wpHashPassword(string $password, int $members_shop_id): bool
{
    $prefix      = config('services.ihook.prefix');
    $storeprefix = config('services.ihook.store_prefix');

    $wp_hasher  = new PasswordHash(8, true);
    $wpPassword = $wp_hasher->HashPassword(trim($password));

    // Update WordPress users table
    return DB::table($storeprefix . '_users')
        ->where('ID', $members_shop_id)
        ->update([
            'user_pass' => $wpPassword,
        ]) > 0;
}
}
?>

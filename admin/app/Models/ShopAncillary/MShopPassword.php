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

use Admin\App\Models\Wordpress\MWordPressSetPassword;

class MShopPassword {
   public static function setPassword($password,$members_shop_id)
    {
        if ($_SESSION['site_settings']['cart_id']['cart_configure_id'] == 1) {
            return MWordPressSetPassword::wpHashPassword($password,$members_shop_id);
        }
    }
}
?>

<?php
/**
 * This class contains public static functions related to wordpress password
 * @package         MBonus
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
class MWpHashPassword {
    /**
     * This public static function is used for to change password encryption
     * @param string $password
     * @return string data
    */
    public static function wpHashPassword($password) {
        // By default, use the portable hash from phpass
        $wp_hasher = new PasswordHash(8, true);
        $wp_hasher->HashPassword(trim($password));
        return $wp_hasher->HashPassword(trim($password));
    }
}
?>

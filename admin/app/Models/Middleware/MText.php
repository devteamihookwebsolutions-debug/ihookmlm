<?php

/**
 * This class contains public functions related to MText
 *
 * @package         MText
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
namespace Admin\App\Models\Middleware;

use Display\Middleware\DText;

class MText {

    public static function setLanguage($filename = '') {


        // Check if the 'lang' parameter is set in the POST request

        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "sitesettings_table WHERE sitesettings_name='admin_site_language'";
        $language = $sql[0]['sitesettings_value'];
        if ($_SESSION['adminsitelang'] == "") {
            $_SESSION['adminsitelang'] = "en";
            $_SESSION['adminsitelang_flag'] = "en.svg";
            $_SESSION['adminsitelang_name'] = 'English';
            $_SESSION['adminsitelang_id'] = '1';
        }

    }

   public static function getLanguage()
   {
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "language_table";
            $records = $sql;
            return DText::getLanguage($records);
    }

    public static function setSelectedlanguage() {

        if (isset($_POST['lang'])) {
            $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "language_table WHERE lang_code='" . $_POST['lang'] . "'";
            $language = $sql[0]['lang_code'];
            $_SESSION['adminsitelang'] = $language;
            $_SESSION['adminsitelang_flag'] = $sql[0]['lang_flag'];
            $_SESSION['adminsitelang_name'] = $sql[0]['lang_name'];
            $_SESSION['adminsitelang_id'] = $sql[0]['lang_id'];
            $_SESSION['adminsite_own'] = "true";

            session_write_close();

            echo json_encode(['status' => 'success', 'message' => 'Language set successfully'.$language]);
            exit();
        }
    }
}
?>

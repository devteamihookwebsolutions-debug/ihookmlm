<?php

/**
 * This class contains public functions related to MQuickBooksIntegrations
 *
 * @package         MQuickBooksIntegrations
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Models\Integrations;

use ZipArchive;
class MQuickBooksIntegration {
    /**
     * This public static function is used to setSalesForceIntegration template
     */
    public static function setQuickBooksIntegration() {
         $file = file_get_contents($_ENV['UI_ASSET_URL'].'/lib/quickbook.zip');
            $path=$_SERVER['DOCUMENT_ROOT'] . '/user/classes/Lib';
            chmod($path, 0777);
            $newfile = fopen($_SERVER['DOCUMENT_ROOT'] . '/user/classes/Lib/quickbook.zip', "w");
            fwrite($newfile, $file);
            fclose($newfile);
            $zip = new ZipArchive;
            if ($zip->open($_SERVER['DOCUMENT_ROOT'] . '/user/classes/Lib/quickbook.zip') === TRUE) {
                $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . '/user/classes/Lib/');
                $zip->close();
            }
            chmod($path, 0755);
            unlink($_SERVER['DOCUMENT_ROOT'] . '/user/classes/Lib/quickbook.zip');
            $_SESSION['success_message'] = '' . __('Integrations updated successfully') . '';
            header('Location: ' . $_ENV['BCPATH'] . '/integration');
            exit();
        }
    }

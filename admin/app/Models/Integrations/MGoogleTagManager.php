<?php

/**
 * This class contains public functions related to MGoogleTagManager
 *
 * @package         MGoogleTagManager
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
namespace Admin\Models\Integrations;
use Query\Bin_Query;

class MGoogleTagManager {
    /**
     * This public static function is used to setgoogleTagManager template
     * @return html
     */
    public static function setGoogleTagManager() {
        $objlink = new Bin_Query();
                $link = $objlink->getConnection();
                $googletagmanager = mysqli_real_escape_string($link, trim($_POST['google_tag_manager_code']));
                $googletagmanager=str_replace('\"','"',$googletagmanager);
                $txt ="<!--start::google_tag_manager_code -->".$googletagmanager."<!--end::end google_tag_manager_code -->";
                $dir='../'.$_ENV['CURRENT_UPATH'].'/templates/_include_footer_scripts.html';
                $dirlogin='../'.$_ENV['CURRENT_UPATH'].'/templates/login_footer.html';
                $contents = file_get_contents($dir);
                $contents = str_replace($txt, '', $contents);
                file_put_contents($dir, $contents);
                $contentslogin = file_get_contents($dirlogin);
                $contentslogin = str_replace($txt, '', $contentslogin);
                file_put_contents($dirlogin, $contentslogin);
                if($integration_status==1){
                $myfile = file_put_contents($dir, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
                $myfilelogin = file_put_contents($dirlogin, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
                }
                else{
                    $contents = file_get_contents($dir);
                    $contents = str_replace($txt, '', $contents);
                    file_put_contents($dir, $contents);
                    $contentslogin = file_get_contents($dirlogin);
                    $contentslogin = str_replace($txt, '', $contentslogin);
                    file_put_contents($dirlogin, $contentslogin);
                }
    }
}

<?php

/**
 * This class contains public functions related to MLiveChatIntegrations
 *
 * @package         MLiveChatIntegrations
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
namespace Admin\Models\Integrations;

class MLiveChatIntegrations {
    /**
     * This public static function is used to setLiveChatIntegration template

     * @return html
     */
    public static function setLiveChatIntegration() {


    	$objlink = new Bin_Query();
                $link = $objlink->getConnection();
                $livechat = mysqli_real_escape_string($link, trim($_POST['livechat']));
                $livechat=str_replace('\"','"',$livechat);
                $txt ="<!--start::livechat -->".$livechat."<!--end::end livechat -->";
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

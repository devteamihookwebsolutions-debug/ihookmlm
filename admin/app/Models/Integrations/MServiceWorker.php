<?php

/**
 * This class contains public functions related to MServiceWorker
 *
 * @package         MServiceWorker
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
namespace Admin\App\Models\Integrations;
class MServiceWorker {
    /**
     * This public static function is used  to updateServiceWorker
    */
    public static function updateServiceWorker(){
         if ($_FILES['site_manfest']['size'] > 0) {
            $uploadedName = $_FILES['site_manfest']['name'];
            $ext = strtolower(substr($uploadedName, strripos($uploadedName, '.') + 1));
            $flnm = hash('sha256', $uploadedName) . '.' . $ext;
            $headerimagepath4 = 'uploads/site_logo/' . $flnm;
            MAmazonS3::amazonUpload($_FILES['site_manfest']['name'],$_FILES['site_manfest']['tmp_name'],$_FILES['site_manfest']['type'],$headerimagepath4);
        } else {
            $headerimagepath4 = trim($_POST['hidden_site_manfest']);
        }
        $site_service_worker_status = trim($_POST['site_service_worker']);
        $updatefields = array('site_service_worker','site_manfest'); //security settings
        foreach ($updatefields as $key => $value) {
            MSiteSettings::updateSiteFields($value);
        }

        if ($site_service_worker_status == '1') {
            $sql_logo_check4 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'site_manfest'";
            $objquer = new Bin_Query();
            $objquer->executeQuery($sql_logo_check4);
            $variable = $objquer->records;
            if (count($variable) > 0) {
                 $sql_site_logo4 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $headerimagepath4 . "'WHERE sitesettings_name='site_manfest'";
            } else {
                $sql_site_logo4 = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`) VALUES ('site_manfest','" . $headerimagepath4 . "' )";
            }
            $obj_site_logo4 = new Bin_Query();
            $obj_site_logo4->updateQuery($sql_site_logo4);

            $sql_logo_check4 = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table WHERE sitesettings_name= 'site_service_worker'";
            $objquer = new Bin_Query();
            $objquer->executeQuery($sql_logo_check4);
            $variable = $objquer->records;
            if (count($variable) > 0) {
                 $sql_site_logo4 = "UPDATE " . $_ENV['PROMLM_PREFIX'] . "sitesettings_table SET sitesettings_value= '" . $site_service_worker_status . "'
                           WHERE sitesettings_name='site_service_worker'";
            } else {
                $sql_site_logo4 = "INSERT INTO `" . $_ENV['PROMLM_PREFIX'] . "sitesettings_table`(`sitesettings_name`,`sitesettings_value`) VALUES ('site_service_worker','" . $site_service_worker_status . "' )";
            }
            $obj_site_logo4 = new Bin_Query();
            $obj_site_logo4->updateQuery($sql_site_logo4);
        }

        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="site_name"');
        $site_name = $sitesettings[0]['sitesettings_value'];
        $sitesettings = MSiteDetails::getSiteSettingsDetails('WHERE sitesettings_name="site_meta_themecolor"');
        $site_meta_themecolor = $sitesettings[0]['sitesettings_value'];
                //serverworker.js
        if(trim($_POST['site_service_worker'])=='1'){
            //update  manifest json file
            $theme_color = $site_meta_themecolor!='' ? $site_meta_themecolor : "#5867dd";

             $start_url='./';
             $user_start_url='./';
            $headerimagepathfull=$_ENV['CDNUPLOADURL'].'/'.$headerimagepath4;
            $manifestcontent='{"name": "'.$site_name.'",
            "short_name": "'.$site_name.'",
            "start_url": "'.$start_url.'",
            "lang": "en-US",
            "background_color": "'.$theme_color.'",
            "theme_color": "'.$theme_color.'",
            "display": "standalone",
            "icons": [
                 {
              "src": "'.$headerimagepathfull.'",
              "type": "image/png",
              "sizes": "192x192"
                 },
                 {
                    "src": "'.$headerimagepathfull.'",
                    "sizes": "512x512",
                    "type": "image/png"
                }
            ]
            }';
            $manifestcontentuser='{"name": "'.$site_name.'",
            "short_name": "'.$site_name.'",
            "start_url": "'.$user_start_url.'",
            "lang": "en-US",
            "background_color": "'.$theme_color.'",
            "theme_color": "'.$theme_color.'",
            "display": "standalone",
            "icons": [
                 {
              "src": "'.$headerimagepathfull.'",
              "type": "image/png",
              "sizes": "192x192"
                 },
                 {
                    "src": "'.$headerimagepathfull.'",
                    "sizes": "512x512",
                    "type": "image/png"
                }
            ]
            }';
            $upladfile = fopen("manifest.json", "w");
            fwrite($upladfile, $manifestcontent);
            fclose($upladfile);
            //in user manifest
            $upladfile = fopen("../".$_ENV['CURRENT_UPATH']."/manifest.json", "w");
            fwrite($upladfile, $manifestcontentuser);
            fclose($upladfile);
            //serviceworker
            $adminofflinepath=$_ENV['BCPATH'] .'/offline.html';
            $userofflinepath=$_ENV['FCPATH'] .'/offline.html';
            $pagepath =  $_ENV['UI_ASSET_URL'].'/assets/custom/js/pwabuilder-sw.js';
            $userindexcontent = file_get_contents($pagepath);
            $finaladminofflinecontent= str_replace('[[offline]]',$adminofflinepath,$userindexcontent);
            $finaluserofflinecontent = str_replace('[[offline]]',$userofflinepath,$userindexcontent);
            $upladfile = fopen("pwabuilder-sw.js", "w");
            fwrite($upladfile, $finaladminofflinecontent);
            fclose($upladfile);
            $upladfile = fopen("../".$_ENV['CURRENT_UPATH']."/pwabuilder-sw.js", "w");
            fwrite($upladfile, $finaluserofflinecontent);
            fclose($upladfile);
         }
         MSiteSettings::updateSiteAutoloadContent();
         $_SESSION['success_message'] = '' . __('Integrations updated successfully') . '';
            header('Location: ' . $_ENV['BCPATH'] . '/integration');
            exit();
    }

}
?>

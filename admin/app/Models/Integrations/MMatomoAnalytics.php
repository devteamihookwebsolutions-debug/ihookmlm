<?php
/**
 * This class contains public static functions related to integration api.
 *
 * @package         MMatomoAnalytics
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\Models\Integrations;

class MMatomoAnalytics {
    /**
     * This public static function is used to setMatomoAnalytics template

     */
    public static function setMatomoAnalytics() {

        $integration_status=trim($_POST['integration_status']);
        $objlink = new Bin_Query();
                $link = $objlink->getConnection();
                $matomoanalytics = mysqli_real_escape_string($link, trim($_POST['matomo_analytics_code']));
                $matomoanalytics=str_replace('\"','"',$matomoanalytics);
                $matomoanalytics=str_replace('\r\n','',$matomoanalytics);
                $matomoanalytics=str_replace("\'",'"',$matomoanalytics);
                $txt ="<!--start::matomo_analytics_code -->".$matomoanalytics."<!--end::end matomo_analytics_code -->";
                $dir='../'.$_ENV['CURRENT_UPATH'].'/templates/_include_footer_analytics_scripts.html';
                $contents = file_get_contents($dir);
                $contents = str_replace($txt, '', $contents);
                file_put_contents($dir, $contents);

                if($integration_status==1){

                  $myfile = file_put_contents($dir, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

                }
                else{
                    $contents = file_get_contents($dir);
                    $contents = str_replace($txt, '', $contents);
                    file_put_contents($dir, $contents);
                }
            }
    }
?>

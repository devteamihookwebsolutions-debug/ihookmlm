<?php
/**
 * This class contains public static functions related to site settings .
 *
 * @package         MSiteAnalytics
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
class MSiteAnalytics {
   /**
     * This public static function is used  to  getMatomaUserToken
     * @return HTML data
     */
    public static function getMatomaUserToken(){
        $dbmatomocontent=file_get_contents('../matomo/config/config.ini.php');
        $dbmatomocontentpares=explode("tables_prefix", $dbmatomocontent);
        $dbmatomocontentpares2=explode("adapter", $dbmatomocontentpares[1]);
        $dbmatomocontentpares2=explode("adapter", $dbmatomocontentpares[1]);
         $matomoprefix=$dbmatomocontentpares2['0'];
          $matomoprefix1=explode('= "', $matomoprefix);
          $matomoprefix2=explode('"', $matomoprefix1[1]);
          $matomoprefixdb=$matomoprefix2[0];
        $sqlmato = "SELECT * FROM " .$matomoprefixdb. "user WHERE superuser_access='1'";
        $objmato = new Bin_Query();
        $objmato->executeQuery($sqlmato);
        if (count($objmato->records) > 0) {
            $token_auth=trim($objmato->records[0]['token_auth']);
        }
        return $token_auth;
    }
}
?>

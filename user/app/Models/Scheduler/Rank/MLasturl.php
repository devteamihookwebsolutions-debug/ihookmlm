<?php
/**
 * This class contains public static functions related to rank .
 *
 * @package         MLasturl
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Model\Scheduler\Rank;
use Query\Bin_Query;

use Model\Middleware\MAmazonCloudFront;
use Model\Middleware\MFormatNumber;

class MLasturl
{
   /**MLasturl
     * This public static function is used  to save last url
     * @return vaid data
    */
   public static function loginbackurl(){
      // $url=$_SERVER['HTTP_REFERER'];
      // echo $url ;exit;
        $url=$_SERVER['REQUEST_URI'];
        $str = ltrim($url, '/user');
        echo $str ;exit;
   }
}
?>
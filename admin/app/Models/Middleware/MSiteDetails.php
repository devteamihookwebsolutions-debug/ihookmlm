<?php
/**
 * This class contains public static functions related to payment gateway details.
 *
 * @package         MPaymentGatewayDetails
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?><?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\currencyFormat;
use Admin\App\Models\Member\SiteDetails;
class MSiteDetails
{
        public static function getSiteSettingsDetails()
    {
         return SiteDetails::all();
    }
        public static function currencyformat(){
            return currencyformat::all();

        }

}

?>

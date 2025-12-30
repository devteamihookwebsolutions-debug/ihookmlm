<?php
/**
 * This class contains public static functions related to CryptoCurrency details.
 *
 * @package         MCryptoCurrencyDetails
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
namespace Admin\App\Models\Middleware;
use Query\Bin_Query;
use Display\Middleware\DCryptoCurrency;

class MCryptoCurrencyDetails {
	/**
     * This public static function is used to get crypto currency
     * @return HTML
     */
    public static function getCryptoCurrencyDetails($where){
        $query = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "crypto_currency_and_token WHERE crypto_status='active' $where ";
        $objquer = new Bin_Query();
        $objquer->executeQuery($query);
        $variable = $objquer->records;

        return $variable;
    }


}
?>

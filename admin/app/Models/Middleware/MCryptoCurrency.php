<?php
/**
 * This class contains public static functions related to format data.
 *
 * @package         MFormatDate
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php


namespace Admin\App\Models\Middleware;
use Admin\App\Http\Display\Middleware\DCryptoCurrency;
use Admin\App\Models\Member\CryptoCurrency;

class MCryptoCurrency
{

public static function getCryptoCurrency()
{
    $records = CryptoCurrency::where('crypto_status', 'active')->get();
    return DCryptoCurrency::getCryptoCurrency($records);
}
  public static function getCryptoCurrencyName($name,$id,$currency_id,$commission,$onchangescript){
        $query = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "crypto_currency_and_token WHERE crypto_status='active'";
        $objquer = new Bin_Query();
        $objquer->executeQuery($query);
        $variable = $objquer->records;
        return DCryptoCurrency::getCryptoCurrencyName($name,$id,$currency_id,$commission,$variable,$onchangescript);
    }
}

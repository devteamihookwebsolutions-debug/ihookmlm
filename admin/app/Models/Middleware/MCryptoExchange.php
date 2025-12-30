<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MBonus
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

use Illuminate\Support\Facades\DB;

class MCryptoExchange
{
    public static function cryptoExchange($crypto_currency_id, $direct_commision = 0)
    {
        $cryptocurrency = DB::select(
            "SELECT crypto_default_name
             FROM ihook_crypto_currency_and_token
             WHERE crypto_currency_id = ?",
            [$crypto_currency_id]
        );

        // safety check
        if (empty($cryptocurrency)) {
            return 0;
        }

        $cryptoName = $cryptocurrency[0]->crypto_default_name;

        $btc_crypto_balance = MCryptoConverter::cryptoConverter($cryptoName);

        $cryptovalue = (float) str_replace(',', '', $btc_crypto_balance);

        if ($cryptovalue > 0) {
            $crypto_qty = $direct_commision / $cryptovalue;
        } else {
            $crypto_qty = 0;
        }

        return number_format($crypto_qty, 6, '.', '');
    }
}


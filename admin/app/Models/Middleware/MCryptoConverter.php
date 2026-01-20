<?php

/**
 * This class contains public functions related to MCryptoConverter
 *
 * @package         MCryptoConverter
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

namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class MCryptoConverter
{

    public static function cryptoConverter($crypto)
    {
        if (empty($crypto)) {
            return '0.00000000';
        }

        $vsCurrency = strtolower(Config::get('app.site_currency_code', 'usd'));

        $cacheKey = "crypto_price_{$crypto}_{$vsCurrency}";

        return Cache::remember($cacheKey, 60, function () use ($crypto, $vsCurrency) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(10)
                    ->get('https://api.coingecko.com/api/v3/simple/price', [
                        'ids' => $crypto,
                        'vs_currencies' => $vsCurrency
                    ]);

                if ($response->failed()) {
                    return '0.00000000';
                }

                $data = $response->json();

                $price = $data[$crypto][$vsCurrency] ?? null;

                if ($price && is_numeric($price)) {
                    return number_format((float)$price, 8, '.', '');
                }

            } catch (\Exception $e) {
                \Log::warning('CryptoConverter API Error: ' . $e->getMessage());
            }

            return '0.00000000';
        });
    }
}

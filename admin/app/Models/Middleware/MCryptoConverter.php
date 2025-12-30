<?php

/**
 * This class contains public static functions related to Crypto Converter
 *
 * @package         MCryptoConverter
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */

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

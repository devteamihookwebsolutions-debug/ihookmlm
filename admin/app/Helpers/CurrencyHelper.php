<?php
namespace Admin\App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CurrencyHelper
{
    public static function getSymbol($currencyCode = null)
    {
        if (!$currencyCode) {
            $currencyCode = self::getSiteCurrency();
        }
        return Cache::remember("currency_symbol_{$currencyCode}", 86400, function () use ($currencyCode) {
            $currency = DB::table('ihook_currencysettings_table')
                ->where('currency_name', $currencyCode)
                ->orWhere('currency', $currencyCode)
                ->first();
            return [
                'symbol' => $currency->currency_symbol ?? '$',
                'position' => $currency->position ?? 'left',
            ];
        });
    }

    public static function getSiteCurrency()
    {
        return Cache::remember('site_currency', 86400, function () {
            $setting = DB::table('ihook_sitesettings_table')
                ->where('sitesettings_name', 'site_currency')
                ->value('sitesettings_value');
            return $setting ?: 'USD';
        });
    }

    public static function format($amount, $currencyCode = null)
    {
        $info = self::getSymbol($currencyCode);

        $cleanAmount = str_replace(',', '', (string)$amount);
        $formatted = number_format((float)$cleanAmount, 2, '.', ',');

        return $info['position'] === 'right'
            ? $formatted . ' ' . $info['symbol']
            : $info['symbol'] . $formatted;
    }

    public static function symbol($currencyCode = null)
    {
        return self::getSymbol($currencyCode)['symbol'];
    }
}

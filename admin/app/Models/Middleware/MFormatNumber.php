<?php

namespace Admin\App\Models\Middleware;

use Admin\App\Models\Member\SiteDetails;
use NumberFormatter;

class MFormatNumber
{

    public static function toFloat($num)
    {
        $sitesettings = SiteDetails::find(1);

        $thousand = ',';
        $decimal  = '.';

        if ($sitesettings) {
            $code = $sitesettings->thousand_seperator ?? '30';

            if ($code == '10' || $code == '40') {
                $thousand = '.'; $decimal = ',';
            } elseif ($code == '20') {
                $thousand = ' '; $decimal = ',';
            } elseif ($code == '30' || $code == '50') {
                $thousand = ','; $decimal = '.';
            }
        }

        $clean = str_replace($thousand, '', (string)$num);
        $clean = str_replace($decimal, '.', $clean);

        return (float) $clean;
    }


    public static function formatCurrency($num, $decimals = null)
    {
        $sitesettings = SiteDetails::find(1);

        if (!$sitesettings) {
            return number_format((float)$num, 2, '.', ',');
        }

        $thousand_code = $sitesettings->thousand_seperator ?? '30';
        $decimal_code  = $sitesettings->decimal_seperator ?? '2';

        // Set separators
        $thousand = ',';
        $decimal  = '.';

        if (in_array($thousand_code, ['10', '40'])) {
            $thousand = '.'; $decimal = ',';
        } elseif ($thousand_code == '20') {
            $thousand = ' '; $decimal = ',';
        } elseif (in_array($thousand_code, ['30', '50'])) {
            $thousand = ','; $decimal = '.';
        }

        $num = (float) $num;
        $decimalPlaces = ($decimal_code === 'round') ? 0 : (int) $decimal_code;

        return number_format($num, $decimalPlaces, $decimal, $thousand);
    }

    /**
     * Legacy function - kept for backward compatibility
     * Now just calls formatCurrency()
     */
    public static function formatingNumberCurrency($num)
    {
        return self::formatCurrency($num);
    }

    /**
     * Legacy function - kept for backward compatibility
     * Now just calls toFloat()
     */
    public static function formatPaymentAmount($num)
    {
        return self::toFloat($num);
    }

    /**
     * Clean number for DB insert (recommended to use this!)
     * Example: 1404.12345678 → 1404.12345678 (clean float)
     */
    public static function cleanForDatabase($num, $precision = 8)
    {
        return round((float) $num, $precision);
    }
}

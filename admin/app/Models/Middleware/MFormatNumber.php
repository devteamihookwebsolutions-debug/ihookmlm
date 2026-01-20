<?php

/**
 * This class contains public functions related to MFormatNumber
 *
 * @package         MFormatNumber
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

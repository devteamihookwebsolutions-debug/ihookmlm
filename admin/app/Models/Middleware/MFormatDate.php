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

class MFormatDate
{
    public static function formatingDate($number)
    {
        if ($number != '') {
            $reqformat = !empty($_SESSION['site_settings']['sitedatetimeformat'])
            ? $_SESSION['site_settings']['sitedatetimeformat']
            : 'm/d/Y'; // Default US format
            $newDate = date($reqformat, strtotime($number));
            return $newDate;
        }
    }
}

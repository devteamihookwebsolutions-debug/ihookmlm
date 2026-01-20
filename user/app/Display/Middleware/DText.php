<?php

/**
 * This class contains public functions related to DTerms
 *
 * @package         DTerms
 * @category        Display
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?><?php
namespace Display\Middleware;
class DText
{

   public static function getLanguage($records)
   {
        $link = $_ENV['FCPATH'];
        $result="";
        for ($i = 0; $i < count((array)$records); $i++) {

            if ($records[$i]['lang_code']==$_SESSION['sitelang']) {
                $select = 'selected';
            }else {
                $select = '';
            }
            $result .= "<li class='m-nav__item'><a aria-label='link' class='m-nav__link' href='" . $link . '/language/set/' . $records[$i]['lang_id'] . "'><span class='m-nav__link-icon'><img alt='image' class='m-topbar__language-img' src='" .$_ENV['UI_ASSET_URL']. '/assets/img/flag/' . $records[$i]['lang_flag'] . "' alt='flag'></span><span class='m-nav__link-title m-topbar__language-text m-nav__link-text'>" . $records[$i]['lang_name'] . "</span></a></li>";

        }
        return $result;
    }
}
?>

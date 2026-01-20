<?php

/**
 * This class contains public functions related to MNameExists
 *
 * @package         MNameExists
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace User\App\Models\Register\Middleware;
use User\App\Models\Member;

class MNameExists
{
    /**
     * This public static function is used to check exists username
     * @return boolean data
     */
    public  function checkUserNameExists($username)
    {
          $username = trim($username);

        return  Member::where('members_username', $username)->exists();


    }





}

<?php

/**
 * This class contains public functions related to MCheckPassword
 *
 * @package         MCheckPassword
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MCheckPassword{
    /**
     * This public static function is used to check password
     * @return boolean data
    */

public function checkPassword(Request $request): bool
{
    $validator = Validator::make($request->all(), [
        'members_password' => [
            'required',
            'string',
            'min:9', // greater than 8
            'regex:/[0-9]/',        // must contain a number
            'regex:/[A-Z]/',        // must contain an uppercase letter
            'regex:/[a-z]/',        // must contain a lowercase letter
            'regex:/[\W_]/',        // must contain a special character
        ],
    ]);

    if ($validator->fails()) {
        return false;
    }

    return true;
}

}
?>

<?php

/**
 * This class contains public functions related to WordpressAutoLoginController
 *
 * @package         WordpressAutoLoginController
 * @category        Controller
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
namespace User\App\Http\Controllers\Wpautologin;

use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class WordpressAutoLoginController extends Controller
{
    public function __invoke(Request $request, $members_id)
    {
        $prefix = config('services.ihook.prefix', 'ihook');

        $member = DB::table($prefix . '_members_table')
            ->where('members_id', $members_id)
            ->select('members_username', 'members_password', 'members_shop_id')
            ->first();

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        if (empty($member->members_shop_id)) {
            return response()->json(['error' => 'No shop ID associated'], 403);
        }

        $payload = [
            'username' => $member->members_username,
            'password' => $member->members_password,
            'shop_id' => $member->members_shop_id,
            'expires' => now()->addMinutes(5)->timestamp,
        ];

        $encryptedToken = Crypt::encrypt($payload);

        $wpBaseUrl = 'https://backoffice.ihookmlmsoftware.com';
        $autoLoginUrl = $wpBaseUrl . '/my-account/?id=' . $member->members_shop_id;

        return response()->json(['url' => $autoLoginUrl]);

    }
}

<?php

/**
 * This class contains public functions related to GenealogySidebarController
 *
 * @package         GenealogySidebarController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace User\App\Http\Controllers\Genealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use User\App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GenealogySearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        try {
            $payload   = $request->json()->all();
            $encrypt   = $payload['encrypturl'] ?? null;
            $username  = $payload['members_username'] ?? null;

            [$members_id, $matrix_id] = MURLCrypt::getDecryptURL($encrypt);

            return response(MGenealogySearch::getSearchMemberDetails($username, $matrix_id));
        } catch (\Exception $e) {
            session(['error_message' => $e->getMessage()]);
            return redirect()->route('genealogy.search');
        }
    }
}

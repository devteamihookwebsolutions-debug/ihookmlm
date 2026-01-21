<?php

/**
 * This class contains public functions related to GenealogyController
 *
 * @package         GenealogyController
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

namespace User\App\Http\Controllers\Genealogy;

use Admin\App\Models\Middleware\MAutoSearchMembers;
use Illuminate\Http\Request;
use Session;
use User\App\Http\Controllers\Controller;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use User\App\Models\Genealogy\MBinaryBottomUser;
use User\App\Models\Genealogy\MBinaryGenealogy;
use User\App\Models\Genealogy\MGenealogy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use User\App\Models\Member;
class GenealogyController extends Controller
{
    public function viewGenealogyTree(Request $request, $encrypted)
    {
        $decoded = MURLCrypt::decode($encrypted);
        if (!$decoded || count($decoded) !== 2) {
            abort(404);
        }

        [$members_id, $matrix_id] = $decoded;

        $loggedInId = Auth::user()->members_id ?? session('default.customer_id');

        $member = MMemberDetails::getUserDetails($members_id);
        $matrix = MMatrixDetails::getMatrixDetails($matrix_id);
        $matrixTypeId = $matrix['matrix_type_id'] ?? 0;
        $customerId = Session::get('default.customer_id');

        $jsData = '';

                if ($matrixTypeId == 1) {

                    $output['flag'] = 0;

                    if ($request->has('sub1')) {
                        $where = "members_id='{$members_id}'
                                AND matrix_id='{$matrix_id}'
                                ORDER BY link_id DESC";

                        $memberLink = MMatrixMemberLink::getPartMatrixLinkDetails('', $where);

                        if (!empty($memberLink) && $memberLink[0]['spillover_id'] > 0) {
                            $output['flag'] = 1;
                        }
                    }

                    $bottomUser = MBinaryBottomUser::getBottomUser($customerId, $matrix_id);

                    $output['bottomuser'] = $bottomUser;
                    $output['topuser']    = MURLCrypt::getEncryptURL($matrix_id, $customerId);
                    $output['leftuser']   = MURLCrypt::getEncryptURL($matrix_id, $bottomUser['leftuser']);
                    $output['rightuser']  = MURLCrypt::getEncryptURL($matrix_id, $bottomUser['rightuser']);
                    $output['genealogy']  = MBinaryGenealogy::getBinaryGenealogyDetails($members_id, $matrix_id);
                    $output['members_id'] = $members_id;
                    $output['matrix_id']  = $matrix_id;
                    $output['members_username'] = $member['members_username'] ?? 'User';
                    $output['matrix_name']      = ucfirst($matrix['matrix_name'] ?? 'Binary');
                    $output['sub1'] = $encrypted;
                    Session::forget(['success_message', 'error_message']);

                    return view('user::genealogy.binary_genealogy', $output);
                }

                if ($matrixTypeId != 6) {
                    $output['genealogy']  = MGenealogy::updateGenealogyDetails($members_id, $matrix_id);
                    $output['topuser']    = MURLCrypt::getEncryptURL($matrix_id, $customerId);
                    $output['members_id'] = $members_id;
                    $output['matrix_id']  = $matrix_id;
                    $output['members_username'] = $member['members_username'] ?? 'User';
                    $output['matrix_name']      = ucfirst($matrix['matrix_name'] ?? 'Binary');
                    $output['sub1'] = $encrypted;
                    Session::forget(['success_message', 'error_message']);

                    return view('user::genealogy.genealogy', $output);
                }
    }

    public function getMembers(Request $request)
    {
        $search    = $request->input('search');
        $matrixEnc = $request->input('matrixEnc');

        if (!$search || !$matrixEnc) {
            return response()->json([]);
        }

        // Decode encrypted data (returns: root_member_id , matrix_id)
        [$members_id, $matrix_id] = MURLCrypt::decode($matrixEnc);

        if (!$members_id || !$matrix_id) {
            return response()->json([]);
        }

        $prefix = config('services.ihook.prefix', 'ihook');
        $matrixTable = "{$prefix}_matrix_members_link_table";
        $membersTable = "{$prefix}_members_table";

        // Now pass the decoded matrix_id into your query:
        $members = DB::table("{$matrixTable}")
            ->join($membersTable, "{$membersTable}.members_id", '=', "{$matrixTable}.members_id")
            ->where("{$matrixTable}.matrix_id", $matrix_id) // ← decode used here
            ->where("{$membersTable}.members_username", 'LIKE', "%{$search}%")
            ->select("{$membersTable}.members_id", "{$membersTable}.members_username")
            ->limit(10)
            ->get();
    // dd($members);
        return response()->json($members);
    }

    // Optional: Direct search redirect
    public function searchMember(Request $request, $encrypted)
    {
        $username = trim($request->input('members_username'));

        [$current_member_id, $matrix_id] = MURLCrypt::decode($encrypted);

        if (!$current_member_id || !$matrix_id) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }

        // Get member by username
    //    $members = DB::table('ihook_members_table as m')
    //         ->join('ihook_matrix_members_link_table as l', 'm.members_id', '=', 'l.members_id')
    //         ->where('l.matrix_id', $matrix_id)
    //         ->whereRaw("FIND_IN_SET(?, l.members_parents)", [$current_member_id])
    //         ->where('m.members_username', 'LIKE', "%{$username}%")
    //         ->select('m.members_id', 'm.members_username')
    //         ->get();
        $members = Member::where('members_username', $username)->first();
    // dd($members);
        if (!$members) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $found_id = $members->members_id;
        $newUrl = MURLCrypt::encode($found_id, $matrix_id);

        return response()->json([
            'status' => 'success',
            'redirect' => $newUrl
        ]);
    }


}

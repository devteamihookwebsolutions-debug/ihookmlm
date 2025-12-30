<?php

namespace User\App\Http\Controllers\Genealogy;

use Admin\App\Models\Middleware\MAutoSearchMembers;
use Illuminate\Http\Request;
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
public function viewGenealogyTree($encrypted)
    {
        // try {
            Log::info('Genealogy Tree Request Start', ['encrypted' => $encrypted]);

            // Decrypt
            $decoded = MURLCrypt::decode($encrypted);
            if (!$decoded || count($decoded) !== 2) {
                Log::error('Invalid encrypted URL', ['encrypted' => $encrypted]);
                abort(404);
            }

            [$members_id, $matrix_id] = $decoded;
            Log::info('Decoded IDs', ['members_id' => $members_id, 'matrix_id' => $matrix_id]);

            if (!$members_id || !$matrix_id) {
                Log::error('Invalid member or matrix ID after decode');
                abort(404);
            }

            $loggedInId = Auth::user()->members_id ?? session('default.customer_id');
            Log::info('Logged in user', ['loggedInId' => $loggedInId]);

            // Security check
            // if ($members_id != $loggedInId) {
            //     $where = "FIND_IN_SET('{$loggedInId}', members_parents) AND matrix_id='{$matrix_id}' AND members_id='{$members_id}'";
            //     $cnt = MMatrixMemberLink::getPartMatrixLinkDetails('COUNT(members_id) as cnt', $where);
            //     $count = $cnt[0]['cnt'] ?? 0;
            //     Log::info('Security check result', ['count' => $count]);
            //     if ($count == 0) {
            //         Log::warning('Unauthorized access attempt', ['members_id' => $members_id]);
            //         abort(403);
            //     }
            // }

            $member = MMemberDetails::getUserDetails($members_id);
            $matrix = MMatrixDetails::getMatrixDetails($matrix_id);
            $matrix_type_id = $matrix->matrix_type_id ?? $matrix['matrix_type_id'] ?? 0;

            Log::info('Matrix type', ['matrix_type_id' => $matrix_type_id]);

            $jsData = '';

            if ($matrix_type_id == 1) {
                Log::info('Generating Binary Genealogy Tree...');
                $jsData = MBinaryGenealogy::getBinaryGenealogyDetails($members_id, $matrix_id);
                // dd($jsData);
                Log::info('Binary Genealogy JS Data Length', ['length' => strlen($jsData)]);
                Log::info('Binary Genealogy Raw Output', ['data' => substr($jsData, 0, 1000)]);
                // dd(['data' => substr($jsData, 0, 1000)]);
            } else {
                Log::info('Non-binary genealogy');
                $jsData = MGenealogy::updateGenealogyDetails($members_id, $matrix_id);
            }

// dd($jsData);
            return view('user::genealogy.binary_genealogy', [
                'members_username' => $member->members_username ?? 'User',
                'matrix_name'      => ucfirst($matrix->matrix_name ?? 'Binary'),
                'flag'             => 0,
                'bottomuser'       => [],
                'topuser'          => MURLCrypt::encode($loggedInId, $matrix_id),
                'leftuser'         => '',
                'rightuser'        => '',
                'genealogy'        => $jsData,
                'sub1'             => $encrypted,
                'members_id'       => $members_id,
                'matrix_id'        => $matrix_id,
            ]);

        // } catch (\Exception $e) {
        //     Log::error('Genealogy Tree Critical Error', [
        //         'message' => $e->getMessage(),
        //         'file' => $e->getFile(),
        //         'line' => $e->getLine(),
        //         'trace' => $e->getTraceAsString()
        //     ]);
        //     abort(500, 'Server Error - Check logs');
        // }
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

    // Now pass the decoded matrix_id into your query:
    $members = DB::table('ihook_matrix_members_link_table')
        ->join('ihook_members_table', 'ihook_members_table.members_id', '=', 'ihook_matrix_members_link_table.members_id')
        ->where('ihook_matrix_members_link_table.matrix_id', $matrix_id) // ← decode used here
        ->where('ihook_members_table.members_username', 'LIKE', "%{$search}%")
        ->select('ihook_members_table.members_id', 'ihook_members_table.members_username')
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

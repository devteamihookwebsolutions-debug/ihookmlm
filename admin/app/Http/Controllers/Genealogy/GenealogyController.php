<?php

/**
 * This class contains public functions related to GenealogyController
 *
 * @package         GenealogyController
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

namespace Admin\App\Http\Controllers\Genealogy;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Genealogy\MCompressedGenealogy;
use Admin\App\Models\Genealogy\MGenealogy;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MMembersDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Genealogy\MBinaryBottomUser;
use Admin\App\Models\Genealogy\MBinaryGenealogy;
class GenealogyController extends Controller
{


//  public static function viewGenealogyTree(Request $request)
//     {
//         // dd($request);
//         try {
//             // 1 Decrypt URL values
//             $decryptUrl = MURLCrypt::getDecryptURL($request->query('sub1'));
//             // dd($decryptUrl);
//             $members_id = $decryptUrl[0];
//             $matrix_id  = $decryptUrl[1];

//             $customer_id = session('default.customer_id');

//             // 2 Verify permission
//             $matrix_link_where = [
//                 ['matrix_id', '=', $matrix_id],
//                 ['members_id', '=', $members_id]
//             ];

//             // Custom find-in-set logic (Laravel doesn’t natively support it)
//             $recordCount = MMatrixMemberLink::selectRaw('COUNT(members_id) as membercnt')
//                 ->whereRaw("FIND_IN_SET(?, members_parents)", [$customer_id])
//                 ->where($matrix_link_where)
//                 ->first();

//             $allowMemberView = $recordCount->membercnt ?? 0;

//             if ($allowMemberView > 0 || $members_id == $customer_id) {

//                 // 3 Fetch member and matrix details
//                 $member = MMembersDetails::select('members_username')
//                     ->where('members_id', $members_id)
//                     ->first();

//                 $matrix = MMatrixDetails::find($matrix_id);

//                 $output = [
//                     'members_username' => $member->members_username ?? '',
//                     'matrix_name' => ucfirst($matrix->matrix_name ?? ''),
//                 ];

//                 $matrix_type_id = $matrix->matrix_type_id ?? null;

//                 // 4 Handle based on matrix type
//                 if ($matrix_type_id != 6) {
//                     if ($matrix_type_id == 1) {
//                         // Binary Matrix
//                         $output['flag'] = 0;

//                         $memberLink = MMatrixMemberLink::where('members_id', $members_id)
//                             ->where('matrix_id', $matrix_id)
//                             ->orderBy('link_id', 'desc')
//                             ->first();

//                         if ($memberLink && $memberLink->spillover_id > 0) {
//                             $output['flag'] = 1;
//                         }

//                         $bottomUser = MBinaryBottomUser::getBottomUser($customer_id, $matrix_id);
//                         $output['bottomuser'] = $bottomUser;

//                         $output['topuser'] = MURLCrypt::getEncryptURL($matrix_id, $customer_id);
//                         $output['leftuser'] = MURLCrypt::getEncryptURL($matrix_id, $bottomUser['leftuser'] ?? null);
//                         $output['rightuser'] = MURLCrypt::getEncryptURL($matrix_id, $bottomUser['rightuser'] ?? null);

//                         $output['genealogy'] = MBinaryGenealogy::getBinaryGenealogyDetails($members_id, $matrix_id);

//                         return view('genealogy.binary_genealogy', $output);
//                     } else {
//                         // Non-binary matrix
//                         $output['members_id'] = $customer_id;
//                         $output['genealogy'] = MGenealogy::updateGenealogyDetails($members_id, $matrix_id);

//                         return view('genealogy.genealogy', $output);
//                     }
//                 }
//             } else {
//                 return redirect('/login');
//             }

//         } catch (Exception $e) {
//             session()->flash('error_message', $e->getMessage());
//             return redirect('/genealogy/viewtree');
//         }
//     }
    public function viewGenealogyTree(Request $request, $matrixId, $memberId = null)
    {

            $memberId = $memberId ?? Session::get('members_id', 1);

            $memberDetails = MMemberDetails::getPartMembersDetails('members_username', $memberId);
            // dd($memberDetails);
            $matrixDetails = MMatrixDetails::getMatrixDetails($matrixId);

            $matrixList    = MMatrixDetails::getAllActiveMatrices();
            $output = [
                'members_username' => $memberDetails['members_username'] ?? 'User',
                'matrix_name'      => ucfirst($matrixDetails->matrix_name ?? ''),
                'matrix_type_id'   => $matrixDetails->matrix_type_id ?? 1,
                'matrixId'         => $matrixId,
                'defaultmatrix'    => $matrixList

            ];
            // dd($output);

            // $matrix_type_id = $matrix->matrix_type_id ?? null;
        $matrixName = $matrixDetails['matrix_name'];
        //    dd($matrixName);
                $matrix_type_id = $matrixDetails['matrix_type_id'];
                    //  dd($matrix_type_id);
            // 4 Handle each matrix type
            if ($matrix_type_id != 6) {

                if ($matrix_type_id == 1) {
                    // Binary Matrix
                    $output['flag'] = 0;

                if (isset($encoded_id)) {
                    $where = 'members_id="' . $memberId . '" AND matrix_id="' . $matrixId . '" ORDER BY link_id DESC ';
                    $output['memberslinkdetails'] = MMatrixMemberLink::getPartMatrixLinkDetails('spillover_id', $where);
                    if ($output['memberslinkdetails'][0]['spillover_id'] > 0) {
                        $output['flag'] = 1;
                    }
                }

                        $bottomUser = MBinaryBottomUser::getBottomUser($memberId, $matrixId);
                        $output['bottomuser'] = $bottomUser;


                    $output['topuser']  = MURLCrypt::getEncryptURL($matrixId, $memberId);
                    $output['leftuser'] = MURLCrypt::getEncryptURL($matrixId, $bottomUser['leftuser'] ?? null);
                    $output['rightuser'] = MURLCrypt::getEncryptURL($matrixId, $bottomUser['rightuser'] ?? null);

                    // Genealogy data
                    $output['genealogy'] = MBinaryGenealogy::getBinaryGenealogyDetails($memberId, $matrixId);
                    //  dd($output);
                    return view('genealogy.binary_genealogy', $output);
                }

                else {
                    // dd('non-binary');
                        $output['genealogy'] = MGenealogy::updateGenealogyDetails($memberId, $matrixId);
                        $output['members_id'] = $memberId;
                        $output['matrix_name'] = $matrixName;
                        $output['matrix_type_id'] = $matrix_type_id;
                        $output['members_id'] = $memberId;
                        $output['selectedMatrixId'] = $matrixId;
                        $output['sub1'] = MURLCrypt::getEncryptURL($matrixId, $memberId);
                        return view('genealogy.genealogy', $output);
                    }
            }
    }
     public static function getCryptData(Request $request)
    {
        try {
            echo MGenealogy::getCryptData($request);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location:" . $_ENV['BCPATH'] . "/genealogy/getcryptdata");
            exit();
        }
    }
    public function getMembers($matrixId, $query)
    {
    $prefix = config('services.ihook.prefix');
    $members = DB::table('' . $prefix . '_matrix_members_link_table')
        ->join('' . $prefix . '_members_table', '' . $prefix . '_members_table.members_id', '=', '' . $prefix . '_matrix_members_link_table.members_id')
        ->where('' . $prefix . '_matrix_members_link_table.matrix_id', $matrixId)
        ->where('' . $prefix . '_members_table.members_username', 'LIKE', "%{$query}%")
        ->select('' . $prefix . '_members_table.members_id', '' . $prefix . '_members_table.members_username')
        ->limit(10)
        ->get();

        // dd($members);
        return response()->json($members);
    }

    public function searchMember(Request $request)
    {
        // dd("ffsf");
        $username = $request->input('members_username');
        $member = Member::where('members_username', $username)->first();

        if (!$member) {
            return response('not-found', 200);
        }

        return response($member->members_id);
    }

}

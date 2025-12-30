<?php

namespace Admin\App\Http\Controllers\Genealogy;

use Admin\App\Http\Controllers\Controller;
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
    try {
        // 1 Decrypt URL params from ?sub1=...
        // $decryptUrl = MURLCrypt::getDecryptURL($request->query('sub1'));
        // $members_id = $decryptUrl[0];
        // $matrix_id  = $decryptUrl[1];

        // 2 Get session user (logged-in user)
        // $customer_id = session('default.customer_id');
        // dd($customer_id);
        $memberId = $memberId ?? Session::get('members_id', 1);

        // // 3 Fetch member & matrix details
        // $member = MMembersDetails::select('members_username')->where('members_id', $members_id)->first();
        // dd($member);
        // $matrix = MMatrixDetails::find($matrix_id);


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


                // $output['topuser']  = MURLCrypt::getEncryptURL($matrix_id, $members_id);
                // $output['leftuser'] = MURLCrypt::getEncryptURL($matrix_id, $bottomUser['leftuser'] ?? null);
                // $output['rightuser'] = MURLCrypt::getEncryptURL($matrix_id, $bottomUser['rightuser'] ?? null);

                // Genealogy data
                $output['genealogy'] = MBinaryGenealogy::getBinaryGenealogyDetails($memberId, $matrixId);
                //  dd($output);
                return view('genealogy.binary_genealogy', $output);
            }
            else {
                // Unilevel or other matrix
                $allowfile = env('CDNCLOUDURL') . '/uploads/allowmenu.txt';
                if (file_exists($allowfile) && strpos(file_get_contents($allowfile), 'dynamiccompression') !== false) {
                    $output['compressionenabled'] = 1;
                    $output['genealogy'] = MCompressedGenealogy::updateGenealogyDetails($memberId, $matrixId);
                } else {
                    $output['genealogy'] = MGenealogy::updateGenealogyDetails($memberId, $matrixId);
                }

                return view('genealogy.genealogy', $output);

            }
        }

        // If matrix_type_id == 6 or invalid
        return redirect('/dashboard')->with('error_message', 'Invalid matrix type.');

    } catch (Exception $e) {
        session()->flash('error_message', $e->getMessage());
        return redirect('/genealogy/viewtree');
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
    // dd($matrixId);
$members = DB::table('ihook_matrix_members_link_table')
    ->join('ihook_members_table', 'ihook_members_table.members_id', '=', 'ihook_matrix_members_link_table.members_id')
    ->where('ihook_matrix_members_link_table.matrix_id', $matrixId)
    ->where('ihook_members_table.members_username', 'LIKE', "%{$query}%")
    ->select('ihook_members_table.members_id', 'ihook_members_table.members_username')
    ->limit(10)
    ->get();

    // dd($members);
    return response()->json($members);
}

public function searchMember(Request $request)
{
    $username = $request->input('members_username');
    $member = Member::where('members_username', $username)->first();


    if (!$member) {
        return response('not-found', 200);
    }

    return response($member->members_id);
}

}

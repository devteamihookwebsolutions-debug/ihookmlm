<?php

namespace Admin\App\Http\Controllers\Genealogy;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Genealogy\MGenealogy;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Genealogy\MBinaryBottomUser;
use Admin\App\Models\Genealogy\MBinaryCollapseGenealogy;

class CollapseGenealogyController extends Controller
{

public function viewGenealogyTree(Request $request, $matrixId, $memberId = null)
{
//    dd($memberId);


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
        
        $matrixList    = MMatrixDetails::getAllActiveMatrices(); // Now real arrays

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
                $output['genealogy'] = MBinaryCollapseGenealogy::getBinaryGenealogyDetails($memberId, $matrixId);
                // dd('funciton reacche');
                //  dd($output);
                return view('genealogy.binary_collapse', $output);
            } 
            else {
                $output['genealogy'] = MCollapseGenealogy::updateGenealogyDetails($memberId, $matrixId);
            }
        }

        // If matrix_type_id == 6 or invalid
        return redirect('/dashboard')->with('error_message', 'Invalid matrix type.');

    } catch (Exception $e) {
        session()->flash('error_message', $e->getMessage());
        return redirect('/genealogy/viewtree');
    }

}
}
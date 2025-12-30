<?php

namespace Admin\App\Http\Controllers\Genealogy;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Genealogy\MGenealogy;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MMembersDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\MemberLinks;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Genealogy\MBinaryBottomUser;
use Admin\App\Models\Genealogy\MTabularGenealogy;

class TabularGenealogyController extends Controller
{

public function viewTabularGenealogy(Request $request, $matrixId, $memberId = null)
{
//    dd($memberId);
  try{

        $memberId = $memberId ?? Session::get('members_id', 1);

        $memberDetails = MMemberDetails::getPartMembersDetails('members_username', $memberId);
        // dd($memberDetails);
        $matrixDetails = MMatrixDetails::getMatrixDetails($matrixId);
        // dd($matrixDetails);
        $matrixList    = MMatrixDetails::getAllActiveMatrices(); // Now real arrays

$output = [
    'members_username' => $memberDetails['members_username'] ?? 'User',
    'matrix_name'      => ucfirst($matrixDetails->matrix_name ?? ''),
    'matrix_type_id'   => $matrixDetails->matrix_type_id ?? 1,
    'matrixId'         => $matrixId,
    'defaultmatrix'    => $matrixList

];
// dd($output);
    return view('genealogy.tabular', $output);
  }
   catch (Exception $e) {
        session()->flash('error_message', $e->getMessage());
        return redirect('/genealogy/viewtree');
    }
}
   public function getTabularGenealogyDetails(Request $request, $matrixId, $memberId = null)
{
        $memberId = $memberId ?? Session::get('members_id', 1);
        // dd($memberId);

        $memberDetails = MMemberDetails::getPartMembersDetails('members_username', $memberId);
        // dd($memberDetails);
        $matrixDetails = MMatrixDetails::getMatrixDetails($matrixId);
//     dd($matrixDetails);

    return MTabularGenealogy::getTabularGenealogyDetails($matrixId, $memberId, $request);
}

}



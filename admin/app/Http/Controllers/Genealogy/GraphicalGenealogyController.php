<?php

namespace Admin\App\Http\Controllers\Genealogy;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Genealogy\MGraphicalGenealogy;
use Admin\App\Models\Genealogy\MGraphicalRankGenealogy;
use Admin\App\Models\Middleware\MMemberDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Middleware\MMembersDetails;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Member\SiteDetails;
use Admin\App\Models\Genealogy\MGenealogy;
use Admin\App\Models\Genealogy\MBinaryBottomUser;

use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Genealogy\MBinaryGraphicalGenealogy;

use Admin\App\Models\Genealogy\MBinaryGraphicalRankGenealogy;
use Admin\App\Models\Genealogy\MGraphicalGenealogyColors;

class GraphicalGenealogyController extends Controller
{

public function viewGenealogyTree(Request $request, $matrixId, $memberId = null)
    {

        // try {
            // dd($request->all());
     $memberId = $memberId ?? Session::get('members_id', 1);
    // dd($matrixId, $memberId);
            // Decrypt URL parameter
            // $decryptUrl = URLSearchparms()

            // $url = url()->current();
            // $path = request()->path();
            $segment1 = request()->segment(1); // admin
            $graphicalGenealogyType = request()->segment(2); // grpgenealogy
            $segment3 = request()->segment(3); // viewtree
            $segment4 = request()->segment(4); // 1

// In viewGenealogyTree()

// $memberId = 1;
// $matrixId = $request->segment(4) ?? 1;

$memberDetails = MMemberDetails::getPartMembersDetails('members_username', $memberId);
// dd($memberDetails);
$matrixDetails = MMatrixDetails::getMatrixDetails($matrixId);
$matrixList    = MMatrixDetails::getAllActiveMatrices(); // Now real arrays

$output = [
    'members_username' => $memberDetails['members_username'] ?? 'User',
    'matrix_name'      => ucfirst($matrixDetails->matrix_name ?? ''),
    'matrix_type_id'   => $matrixDetails->matrix_type_id ?? 1,
    'matrixId'         => $matrixId,
    'defaultmatrix'    => $matrixList, // 100% array of arrays
    'graphicalGenealogyType' => $graphicalGenealogyType,
];
// dd($output);

            $matrixName = $matrixDetails['matrix_name'];
            $matrixTypeId = $matrixDetails['matrix_type_id'];
        //  dd($matrixName);
            // Determine genealogy template
            if ($graphicalGenealogyType == 'grpgenealogy') {
                // dd($graphicalGenealogyType);
                $templateKey = "graphical_genealogy_" . trim($matrixName);
            } elseif ($graphicalGenealogyType == 'countgenealogy') {
                $templateKey = "count_genealogy_" . trim($matrixName);
            } elseif ($graphicalGenealogyType == 'rankgenealogy') {
                $templateKey = "rank_genealogy_" . trim($matrixName);
            } elseif ($graphicalGenealogyType == 'directdownlinegenealogy') {
                $templateKey = "directdownline_genealogy_" . trim($matrixName);
            } else {
                $templateKey = null;
            }
            // dd($templateKey);

$setting = SiteDetails::where('sitesettings_name', $templateKey)->first();
// dd($setting);
$output['genealogyTemplate'] = $setting && filled($setting->sitesettings_value)
    ? trim($setting->sitesettings_value)
    : 'polina';

            // dd($output);


            if ($matrixTypeId != 6) {
                if ($matrixTypeId == 1) {
                    // Binary matrix


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


                    // $output['topuser'] = MURLCrypt::getEncryptURL($matrixId, $memberId);
                    // $output['leftuser'] = MURLCrypt::getEncryptURL($matrixId, $bottomUser['leftuser']);
                    // $output['rightuser'] = MURLCrypt::getEncryptURL($matrixId, $bottomUser['rightuser']);



                    // Binary genealogy templates
                    if ($graphicalGenealogyType == 'grpgenealogy') {
                        $output['genealogy'] = MBinaryGraphicalGenealogy::getbinaryGenealogyDetails($memberId, $matrixId);
                    //   dd('contenion reached');
                //   dd($output);
                        return view('genealogy.binary_graphical', $output);

                    } elseif ($graphicalGenealogyType == 'countgenealogy') {
                        $output['genealogy'] = MBinaryGraphicalGenealogy::getbinaryGenealogyDetails($memberId, $matrixId);
                        $output['rankcolors'] = MGraphicalGenealogyColors::getRankcolors($matrixId);
                        // dd($output);
                        return view('genealogy.binary_graphical_count', $output);

                    } elseif ($graphicalGenealogyType == 'rankgenealogy') {
                        // dd('function reached');
                        $genealogy = MBinaryGraphicalRankGenealogy::getbinaryGenealogyDetails($memberId, $matrixId);
                        // dd($genealogy);
                        $output['genealogy'] = $genealogy[0];
                        $output['genealogycss'] = $genealogy[1];

                        $output['rankcolors'] = MGraphicalGenealogyColors::getRankcolors($matrixId);
                        // dd($output);
                        return view('genealogy.binary_graphical_rank', $output);

                    } elseif ($graphicalGenealogyType == 'directdownlinegenealogy') {
                        $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($memberId, $matrixId);
                        return view('genealogy.directdownline', $output);
                    }

                } else {
                    // Non-binary matrices
                    if ($graphicalGenealogyType == 'grpgenealogy') {
                        $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($memberId, $matrixId);
                        return view('genealogy.graphical', $output);

                    } elseif ($graphicalGenealogyType == 'countgenealogy') {
                        $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($memberId, $matrixId);
                        return view('genealogy.graphical_count', $output);

                    } elseif ($graphicalGenealogyType == 'rankgenealogy') {
                        $genealogy = MGraphicalRankGenealogy::updateGenealogyDetails($memberId, $matrixId);
                        // dd($genealogy);
                        $output['genealogy'] = $genealogy[0];
                        $output['genealogycss'] = $genealogy[1];
                        $output['rankcolors'] = MGraphicalGenealogyColors::getRankcolors($matrixId);
                        return view('genealogy.graphical_rank', $output);

                    } elseif ($graphicalGenealogyType == 'directdownlinegenealogy') {
                        $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($memberId, $matrixId);
                        return view('genealogy.directdownline', $output);
                    }
                }

                Session::forget(['success', 'error_message']);
            }



        // } catch (\Exception $e) {
        //     Session::flash('error_message', $e->getMessage());

        // }
    }

     public function setGenealogyTemplate(Request $request)
    {
        // dd($request->all());
        try {
            MGraphicalGenealogy::updateGenealogySettings();
            Session::flash('success', 'Genealogy template updated successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error_message', $e->getMessage());
            return redirect(env('BCPATH') . '/rankgenealogy/updatetemplate');
        }
    }



}

<?php

namespace User\App\Http\Controllers\Genealogy;

use User\App\Models\Genealogy\MBinaryBottomUser;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MURLCrypt;
use User\App\Models\Genealogy\MBinaryCollapseGenealogy;
use User\App\Models\Genealogy\MCollapseGenealogy;
use Admin\App\Models\Middleware\MMemberDetails;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CollapseGenealogyController extends Controller
{
    public static function viewTree($encrypted, Request $request)
    {
        // 1. Decode encrypted string
        [$members_id, $matrix_id] = MURLCrypt::decode($encrypted);

        // 2. Must be logged in
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to continue.');
        }

        // Adjust this line according to your users table primary key
        $loggedInUserId = Auth::user()->customer_id ?? Auth::id();


        // 4. Fetch member & matrix details (these old methods return object or array)
        $membersDetails = MMemberDetails::getPartMembersDetails('members_username', $members_id);
        $matrixDetails  = MMatrixDetails::getMatrixDetails($matrix_id);

        if (!$membersDetails || !$matrixDetails) {
            abort(404, 'Member or Matrix not found.');
        }

        // Helper to safely get property whether it's object or array
        $get = function ($data, $key, $default = null) {
            if (is_array($data)) {
                return $data[$key] ?? $default;
            }
            return $data->$key ?? $default;
        };

        $output = [
            'members_username' => $get($membersDetails, 'members_username', 'Unknown'),
            'matrix_name'      => ucfirst($get($matrixDetails, 'matrix_name', 'Matrix')),
        ];

        $matrix_type_id = $get($matrixDetails, 'matrix_type_id');

        if ($matrix_type_id == 1) {
            $output['flag'] = 0;

            if ($request->has('sub1')) {
                $where = "members_id = '$members_id' AND matrix_id = '$matrix_id' ORDER BY link_id DESC";
                $membersLinkDetails = MMatrixMemberLink::getPartMatrixLinkDetails('', $where);

                if (!empty($membersLinkDetails)) {
                    $first = is_array($membersLinkDetails) ? $membersLinkDetails[0] : $membersLinkDetails->first();
                    $spillover = $first ? ($get($first, 'spillover_id', 0)) : 0;

                    if ($spillover > 0) {
                        $output['flag'] = 1;
                    }
                }

                $output['memberslinkdetails'] = $membersLinkDetails;
            }

            $output['bottomuser'] = MBinaryBottomUser::getBottomUser($members_id, $matrix_id);
            $output['genealogy']  = MBinaryCollapseGenealogy::getBinaryGenealogyDetails($members_id, $matrix_id);
// dd($output['genealogy']);
            return view('user::genealogy.binary_collapse', $output);
        }


        $output['genealogy'] = MCollapseGenealogy::updateGenealogyDetails($members_id, $matrix_id);

           return view('user::genealogy.binary_collapse', [
            'members_username' => $get($membersDetails, 'members_username', 'Unknown'),
            'matrix_name'      => ucfirst($get($matrixDetails, 'matrix_name', 'Binary')),
            // 'genealogy'   => json_encode($output, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)
        ]);
    }
}

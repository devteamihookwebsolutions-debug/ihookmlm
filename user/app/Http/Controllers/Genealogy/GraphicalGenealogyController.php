<?php

namespace User\App\Http\Controllers\Genealogy;

use User\App\Models\Genealogy\MBinaryGraphicalRankGenealogy;
use User\App\Models\Genealogy\MGraphicalGenealogy;
use User\App\Models\Genealogy\MGraphicalGenealogyColors;
use User\App\Models\Genealogy\MGraphicalRankGenealogy;
use User\App\Models\Genealogy\MBinaryBottomUser;
use User\App\Models\Genealogy\MBinaryGraphicalGenealogy;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MSiteDetails;
use Admin\App\Models\Middleware\MURLCrypt;
use DB;
use Log;
use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GraphicalGenealogyController extends Controller
{
    public function viewTree($encrypted, Request $request)
    {
        // 1. Decrypt URL
        [$memberId, $matrixId] = MURLCrypt::decode($encrypted);

        Log::info('Decrypted values', ['memberId' => $memberId, 'matrixId' => $matrixId]);

        if (!$memberId || !$matrixId) {
            abort(404, 'Invalid link');
        }

        // 2. Auth check
        $loggedInMemberId = Auth::user()->members_id ?? session('default.customer_id');
        if ($memberId != $loggedInMemberId) {
            abort(403, 'Unauthorized access');
        }

        $prefix = config('ihook.prefix', 'ihook');

        // 3. Fetch Member
        $member = DB::table("{$prefix}_members_table")
            ->where('members_id', $memberId)
            ->first();

        // 4. Fetch Matrix
        $matrix = DB::table("{$prefix}_matrix_table")
            ->where('matrix_id', $matrixId)
            ->first();

        if (!$member || !$matrix) {
            abort(404, 'Member or Matrix not found');
        }

        $members_id     = $memberId;
        $matrix_id      = $matrixId;
        $matrix_type_id = $matrix->matrix_type_id;
        $matrix_name    = $matrix->matrix_name ?? 'default';

        $type = $request->query('type', 'grpgenealogy');
        $urlSegment = $request->segment(2);

        $allowedUrlTypes = [
            'grpgenealogy',
            'countgenealogy',
            'rankgenealogy',
            'directdownlinegenealogy',
            'advancedgenealogy'
        ];

        if (in_array($urlSegment, $allowedUrlTypes, true)) {
            $type = $urlSegment;
        }

        // Template key for theme selection
        $templateKey = match ($type) {
            'grpgenealogy', 'advancedgenealogy' => "graphical_genealogy_{$matrix_name}",
            'countgenealogy'                    => "count_genealogy_{$matrix_name}",
            'rankgenealogy'                     => "rank_genealogy_{$matrix_name}",
            'directdownlinegenealogy'           => "directdownline_genealogy_{$matrix_name}",
            default                             => 'polina',
        };

        $tpl = MSiteDetails::getSiteSettingsDetails("WHERE sitesettings_name='$templateKey'");
        $output['genealogyTemplate'] = $tpl[0]['sitesettings_value'] ?? 'polina';

        if ($matrix_type_id == 6) {
            abort(403, 'Access denied for this matrix type');
        }

        $output['member'] = $member;
        $output['matrix'] = $matrix;

        if ($matrix_type_id == 1) {

            $output['flag'] = 0;
            $link = MMatrixMemberLink::getPartMatrixLinkDetails(
                'spillover_id',
                "members_id='$members_id' AND matrix_id='$matrix_id' ORDER BY link_id DESC"
            );
            if (!empty($link) && ($link[0]['spillover_id'] ?? 0) > 0) {
                $output['flag'] = 1;
            }

            $bottom = MBinaryBottomUser::getBottomUser(Auth::user()->customer_id ?? $members_id, $matrix_id);
            $output['bottomuser'] = $bottom;
            $output['topuser']    = MURLCrypt::getEncryptURL($matrix_id, $members_id);
            $output['leftuser']   = !empty($bottom['leftuser'])  ? MURLCrypt::getEncryptURL($matrix_id, $bottom['leftuser'])  : '#';
            $output['rightuser']  = !empty($bottom['rightuser']) ? MURLCrypt::getEncryptURL($matrix_id, $bottom['rightuser']) : '#';

            if ($type === 'advancedgenealogy') {
                $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($members_id, $matrix_id);
                return view('user::genealogy/graphical', $output);
            }

            if ($type === 'grpgenealogy' || $type === 'countgenealogy') {
                $output['genealogy'] = MBinaryGraphicalGenealogy::getbinaryGenealogyDetails($members_id, $matrix_id);

                $blade = $type === 'countgenealogy'
                    ? 'user::genealogy/binary_graphical_count'
                    : 'user::genealogy/binary_graphical';

                return view($blade, $output);
            }

            if ($type === 'rankgenealogy') {
                $result = MBinaryGraphicalRankGenealogy::getbinaryGenealogyDetails($members_id, $matrix_id);

                $output['genealogy']    = $result[0] ?? [];
                $output['genealogycss'] = $result[1] ?? '';
                $output['rankcolors']   = MGraphicalGenealogyColors::getRankcolors($matrix_id);

                return view('user::genealogy/binary_graphical_rank', $output);
            }

            if ($type === 'directdownlinegenealogy') {
                $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($members_id, $matrix_id);
                return view('user::genealogy/binary_graphical_directdownline', $output);
            }

            $output['genealogy'] = MBinaryGraphicalGenealogy::getbinaryGenealogyDetails($members_id, $matrix_id);
            return view('user::genealogy/binary_graphical', $output);
        }


        if (in_array($type, ['grpgenealogy', 'countgenealogy', 'directdownlinegenealogy', 'advancedgenealogy'])) {
            $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($members_id, $matrix_id);

            $blade = match ($type) {
                'countgenealogy'          => 'user::genealogy/graphical_count',
                'directdownlinegenealogy' => 'user::genealogy/graphical_directdownline',
                'advancedgenealogy'       => 'user::genealogy/graphical',
                default                   => 'user::genealogy/graphical',
            };

            return view($blade, $output);
        }

        if ($type === 'rankgenealogy') {
            $result = MGraphicalRankGenealogy::updateGenealogyDetails($members_id, $matrix_id);

            $output['genealogy']    = $result[0] ?? [];
            $output['genealogycss'] = $result[1] ?? '';
            $output['rankcolors']   = MGraphicalGenealogyColors::getRankcolors($matrix_id);

            return view('user::genealogy/graphical_rank', $output);
        }

        // Final fallback - most common case
        $output['genealogy'] = MGraphicalGenealogy::updateGenealogyDetails($members_id, $matrix_id);
        return view('user::genealogy/graphical', $output);
    }

    public function updateTemplate(Request $request)
    {
        try {
            MGraphicalGenealogy::updateGenealogySettings();
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            session(['error_message' => $e->getMessage()]);
            return redirect()->route('grpgenealogy.updatetemplate');
        }
    }
}

<?php
namespace User\App\Models\Genealogy;
use Admin\App\Models\Middleware\MMemberDetails;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MGenealogy
{

    public static function updateGenealogyDetails($members_id, $matrix_id)
    {
        $prefix = $_ENV['IHOOK_PREFIX'];

        // Actually execute the query
        $recordsdefault = DB::select(
            "SELECT * FROM {$prefix}_matrix_members_link_table
            WHERE matrix_id = ? AND members_id = ?",
            [$matrix_id, $members_id]
        );

        // Safely access the first record
        $default_members_id = !empty($recordsdefault) ? $recordsdefault[0]->members_id : null;
        $default_members_account_status = !empty($recordsdefault) ? $recordsdefault[0]->members_account_status : null;

        // Main query - now properly executed
        $referralslinkdetails = DB::select("
            SELECT SQL_CALC_FOUND_ROWS
                a.*,
                b.members_email,
                b.members_firstname,
                b.members_lastname,
                b.members_image,
                b.members_phone,
                b.members_username,
                c.members_username AS sponsorname,
                MAX(CASE WHEN d.rank_key = 'rank_value' THEN d.rank_value ELSE NULL END) AS rank_value_display,
                MAX(CASE WHEN e.rank_key = 'rank_icon_path' AND e.matrix_id = ? THEN e.rank_value ELSE NULL END) AS rank_icon_path

            FROM {$prefix}_matrix_members_link_table AS a
            LEFT JOIN {$prefix}_members_table AS b ON a.members_id = b.members_id
            LEFT JOIN {$prefix}_members_table AS c ON c.members_id = a.direct_id
            LEFT JOIN {$prefix}_ranksetting AS d
                ON d.rank_id = a.rankid AND d.rank_key = 'rank_value'
            LEFT JOIN {$prefix}_ranksetting AS e
                ON e.rank_id = a.rankid
                AND e.rank_key = 'rank_icon_path'
                AND e.matrix_id = ?

            WHERE FIND_IN_SET(?, a.members_parents) OR a.members_id = ?
            GROUP BY a.link_id, a.members_id
            ORDER BY a.position ASC
            LIMIT 100
        ", [$matrix_id, $matrix_id, $members_id, $members_id]);

        $output = '';

        if (!empty($referralslinkdetails)) {
            foreach ($referralslinkdetails as $row) {
                $groupTitleColor = '#4169e1';
                $itemTitleColor  = '#4169e1';

                $spillover_id    = $row->spillover_id ?? 0;
                $members_email   = $row->members_email ?? '';
                $memberimage     = $row->members_image && $row->members_image !== ''
                    ? $row->members_image
                    : 'uploads/members/avatar.png';

                $members_fullname = $row->members_username ?? 'Unknown';
                $members_phone    = $row->members_phone ?? '';
                $linkid           = $row->link_id ?? 0;
                $sponsor_name     = $row->sponsorname ?? 'Nil';
                $rank_value       = $row->rank_value_display ?? '';
                $rank            = $rank_value !== '' ? $rank_value : 'Nil';

                // Passup logic
                $members_passup_id = $row->members_passup_id ?? 0;
                $passupdetails = '';
                if ($members_passup_id > 0) {
                    $member_details = MMemberDetails::getPartMembersDetails('members_username', $members_passup_id);
                    $passupmembername = $member_details['members_username'] ?? 'Unknown';
                    $passupdetails = ', Passup : ' . $passupmembername;
                }

                // Rank icon
                $rank_icon_path = $row->rank_icon_path ?? '';
                $rank_icon_path = $rank_icon_path !== ''
                    ? $_ENV['CDNCLOUDEXTURL'] . '/' . $rank_icon_path
                    : '';

                $template = ($row->rank_icon_path && $row->rankid > 0)
                    ? 'contactTemplate'
                    : 'contactTemplate1';

                $rankimage = ($row->rank_icon_path && $row->rankid > 0) ? $rank_icon_path : '0';

                $output .= "{
                    id: '{$row->members_id}',
                    parent: '{$spillover_id}',
                    title: '{$members_fullname}',
                    description: '" . __('Sponsor') . " : {$sponsor_name}{$passupdetails}',
                    phone: '{$members_phone}',
                    email: '{$members_email}',
                    rank: '" . __('Rank') . " : {$rank}',
                    image: '{$memberimage}',
                    rankimage: '{$rankimage}',
                    templateName: '{$template}',
                    members_id: '{$row->members_id}',
                    groupTitleColor: '{$groupTitleColor}',
                    itemTitleColor: '{$itemTitleColor}',
                    href: '/genealogy/viewtree/{$linkid}'
                },";
            }
        }

        $output = 'var data = [' . rtrim($output, ',') . '];';

        return $output;
    }
    public  static function getCryptData(Request $request)
        {
            // Get matrix_id from request, default to 1
            $matrix_id = $request->input('matrix_id', 1);

            // Fetch the matrix record
            $matrix = Matrix::where('matrix_status', '1')
                            ->where('matrix_id', $matrix_id)
                            ->orderBy('matrix_id', 'asc')
                            ->first();

            if (!$matrix) {
                return response()->json(['error' => 'Matrix not found'], 404);
            }

            // Fetch the configuration record manually
            $config = MatrixConfiguration::where('matrix_id', $matrix->matrix_id)
                                        ->where('matrix_key', 'default_sponsor')
                                        ->first();

            if (!$config) {
                return response()->json(['error' => 'Matrix configuration not found'], 404);
            }

            // Generate encrypted URL
            $crypturl = MURLCrypt::getEncryptURL($matrix->matrix_id, $config->matrix_value);

            // Store in session
            Session::put('genealogylinkcrypt', $crypturl);

            return response()->json(['crypt_url' => $crypturl]);
    }

    public static function getActiveMatrixList($encoded_id)
    {
        // Decrypt URL parameters
        $decryptUrl = MURLCrypt::encode($encoded_id);
        $members_id = $decryptUrl[0];
        $matrix_id  = $decryptUrl[1];

        // Get active matrices
        $defaultmatrix = Matrix::where('matrix_status', 1)->get();

        return $defaultmatrix;
    }

}




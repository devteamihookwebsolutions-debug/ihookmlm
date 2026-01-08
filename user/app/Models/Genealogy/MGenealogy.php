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
    $prefix = config('services.ihook.prefix', 'ihook');

    $sql = "SELECT SQL_CALC_FOUND_ROWS
                a.*,
                b.members_email, b.members_firstname, b.members_lastname, b.members_image, b.members_phone, b.members_username,
                c.members_username AS sponsorname,
                MAX(CASE WHEN d.rank_key = 'rank_value' THEN d.rank_value ELSE NULL END) AS rank_value_display,
                MAX(CASE WHEN e.rank_key = 'rank_icon_path' AND e.matrix_id = ? THEN e.rank_value ELSE NULL END) AS rank_icon_path
            FROM {$prefix}_matrix_members_link_table AS a
            LEFT JOIN {$prefix}_members_table AS b ON a.members_id = b.members_id
            LEFT JOIN {$prefix}_members_table AS c ON c.members_id = a.direct_id
            LEFT JOIN {$prefix}_ranksetting AS d ON d.rank_id = a.rankid AND d.rank_key = 'rank_value'
            LEFT JOIN {$prefix}_ranksetting AS e ON e.rank_id = a.rankid
                AND e.rank_key = 'rank_icon_path' AND e.matrix_id = ?
            WHERE FIND_IN_SET(?, a.members_parents) OR a.members_id = ?
            GROUP BY a.link_id, a.members_id
            ORDER BY a.matrix_doj ASC
            LIMIT 1000";

    $referralslinkdetails = DB::select($sql, [$matrix_id, $matrix_id, $members_id, $members_id]);

    $nodes = [];

    foreach ($referralslinkdetails as $row) {
        $parent_id = $row->direct_id ?? 0;

        $memberimage = !empty($row->members_image)
            ? env('CDNCLOUDEXTURL') . '/' . ltrim($row->members_image, '/')
            : env('CDNCLOUDEXTURL') . '/uploads/members/avatar.png';

        $members_fullname = $row->members_username ?? 'Unknown';
        $sponsor_name     = $row->sponsorname ?? 'Nil';
        $rank_value       = $row->rank_value_display ?? '';
        $rank             = !empty($rank_value) ? $rank_value : 'Nil';

        $passupdetails = '';
        if (!empty($row->members_passup_id)) {
            $passup = MMemberDetails::getPartMembersDetails('members_username', $row->members_passup_id);
            $passup_name = $passup['members_username'] ?? 'Unknown';
            $passupdetails = ', Passup: ' . $passup_name;
        }

        $rank_icon_path = '';
        if (!empty($row->rank_icon_path) && $row->rankid > 0) {
            $rank_icon_path = env('CDNCLOUDEXTURL') . '/' . ltrim($row->rank_icon_path, '/');
        }

        $template = (!empty($rank_icon_path) && $row->rankid > 0) ? 'contactTemplate' : 'contactTemplate1';

        $nodes[] = [
            'id'               => (string)$row->members_id,
            'parent'           => $row->members_id == $members_id ? null : ($parent_id == 0 ? null : (string)$parent_id),
            'title'            => $members_fullname,
            'description'      => 'Sponsor: ' . $sponsor_name . $passupdetails,
            'phone'            => $row->members_phone ?? '',
            'email'            => $row->members_email ?? '',
            'rank'             => 'Rank: ' . $rank,
            'image'            => $memberimage,
            'rankimage'        => $rank_icon_path ?: '0',
            'templateName'     => $template,
            'itemTitleColor'   => '#4169e1',
            'groupTitleColor'  => '#4169e1',
            'href'             => '/genealogy/viewtree/' . MURLCrypt::getEncryptURL($matrix_id, $row->members_id)
        ];
    }

    // If no members found, show at least the root
    if (empty($nodes)) {
        $rootImage = env('CDNCLOUDEXTURL') . '/uploads/members/avatar.png';
        $nodes[] = [
            'id'           => (string)$members_id,
            'parent'       => null,
            'title'        => 'No Downlines Yet',
            'description'  => 'Start recruiting!',
            'image'        => $rootImage,
            'templateName' => 'contactTemplate1',
            'itemTitleColor' => '#4169e1'
        ];
    }

    // IMPORTANT: Return only the JSON array (no "var rawData =")
    return json_encode($nodes, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
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




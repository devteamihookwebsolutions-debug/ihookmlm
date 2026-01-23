<?php

/**
 * This class contains public functions related to MGenealogy
 *
 * @package         MGenealogy
 * @category        Model
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

namespace Admin\App\Models\Genealogy;

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

        $sql = "
            SELECT
                a.*,
                b.members_email,
                b.members_firstname,
                b.members_lastname,
                b.members_image,
                b.members_phone,
                b.members_username,
                c.members_username AS sponsorname,
                rs_value.rank_value AS rank_value_display,
                rs_icon.rank_value AS rank_icon_path
            FROM {$prefix}_matrix_members_link_table AS a
            LEFT JOIN {$prefix}_members_table AS b
                ON a.members_id = b.members_id
            LEFT JOIN {$prefix}_members_table AS c
                ON c.members_id = a.direct_id
            LEFT JOIN (
                SELECT rank_id, rank_value
                FROM {$prefix}_ranksetting
                WHERE rank_key = 'rank_value'
            ) rs_value ON rs_value.rank_id = a.rankid
            LEFT JOIN (
                SELECT rank_id, rank_value
                FROM {$prefix}_ranksetting
                WHERE rank_key = 'rank_icon_path'
                  AND matrix_id = ?
            ) rs_icon ON rs_icon.rank_id = a.rankid
            WHERE FIND_IN_SET(?, a.members_parents)
               OR a.members_id = ?
            ORDER BY a.matrix_doj ASC
            LIMIT 1000";

        $referralslinkdetails = DB::select($sql, [$matrix_id, $members_id, $members_id]);

        $nodes = [];

        foreach ($referralslinkdetails as $row) {
            $parent_id = $row->direct_id ?? 0;

            $memberimage = !empty($row->members_image)
                ? env('CDNCLOUDEXTURL') . '/' . ltrim($row->members_image, '/')
                : env('CDNCLOUDEXTURL') . '/uploads/members/avatar.png';

            $members_fullname = $row->members_username ?? 'Unknown';
            $sponsor_name     = $row->sponsorname ?? 'Nil';

            $rank_value = $row->rank_value_display ?? '';
            $rank       = $rank_value !== '' ? $rank_value : 'Nil';

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

        if (empty($nodes)) {
            $rootImage = env('CDNCLOUDEXTURL') . '/uploads/members/avatar.png';

            $nodes[] = [
                'id'             => (string)$members_id,
                'parent'         => null,
                'title'          => 'No Downlines Yet',
                'description'    => 'Start recruiting!',
                'image'          => $rootImage,
                'templateName'   => 'contactTemplate1',
                'itemTitleColor' => '#4169e1'
            ];
        }

        return json_encode($nodes, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    /**
     * Generate encrypted genealogy link and store in session
     */
    public static function getCryptData(Request $request)
    {
        $matrix_id = $request->input('matrix_id', 1);

        $matrix = Matrix::where('matrix_status', '1')
            ->where('matrix_id', $matrix_id)
            ->first();

        if (!$matrix) {
            return response()->json(['error' => 'Matrix not found'], 404);
        }

        $config = MatrixConfiguration::where('matrix_id', $matrix->matrix_id)
            ->where('matrix_key', 'default_sponsor')
            ->first();

        if (!$config) {
            return response()->json(['error' => 'Default sponsor configuration not found'], 404);
        }

        $crypturl = MURLCrypt::getEncryptURL($matrix->matrix_id, $config->matrix_value);

        Session::put('genealogylinkcrypt', $crypturl);

        return response()->json(['crypt_url' => $crypturl]);
    }
    public static function getActiveMatrixList($encoded_id)
    {
        $decryptUrl = MURLCrypt::decode($encoded_id);

        $members_id = $decryptUrl[0] ?? null;
        $matrix_id  = $decryptUrl[1] ?? null;

        $activeMatrices = Matrix::where('matrix_status', 1)
            ->orderBy('matrix_id', 'asc')
            ->get();

        return $activeMatrices;
    }
}

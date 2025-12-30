<?php
/**
 * MNetwork – Laravel model for the “My Network” page
 *
 * @package    User\App\Models\Network
 * @author     Sunsofty Dev Team
 * @copyright  Copyright (c) 2020 - 2025, Sunsofty.
 * @version    8.1
 */

namespace User\App\Models\Network;

use Auth;
use Illuminate\Support\Facades\DB;
use User\App\Display\Network\DActiveNetwork;
use User\App\Display\Network\DInactiveNetwork;

class MNetwork
{
    /** @var string|null Cached table prefix */
    private static ?string $prefix = null;

    /** Get the table prefix (config → fallback to 'ihook') */
    private static function prefix(): string
    {
        return self::$prefix ??= config('ihook.prefix', 'ihook');
    }

    public static function getActiveNetworkDetails($matrix_id): ?string
    {
        $userId = session('default.customer_id');
        $p      = self::prefix();

        $sql = "
            SELECT
                a.matrix_id,
                ANY_VALUE(a.link_id)      AS link_id,
                ANY_VALUE(a.members_id)   AS members_id,

                ANY_VALUE(b.matrix_id)    AS matrix_id_b,
                ANY_VALUE(b.matrix_name)  AS matrix_name,
                ANY_VALUE(b.matrix_type_id) AS matrix_type_id_b,
                ANY_VALUE(b.matrix_status)  AS matrix_status,

                ANY_VALUE(c.matrix_type_id)   AS matrix_type_id_c,
                ANY_VALUE(c.matrix_type_name) AS matrix_type_name,

                ANY_VALUE(d.members_status)   AS members_status,
                ANY_VALUE(d.members_doj)      AS members_doj,
                ANY_VALUE(d.members_username) AS members_username
            FROM {$p}_matrix_members_link_table AS a
            LEFT JOIN {$p}_matrix_table          AS b ON b.matrix_id = a.matrix_id
            LEFT JOIN {$p}_matrix_type_table     AS c ON c.matrix_type_id = b.matrix_type_id
            LEFT JOIN {$p}_members_table         AS d ON d.members_id = a.members_id
            WHERE a.members_id = ?
            GROUP BY a.matrix_id
        ";

        $records = DB::select($sql, [$userId]);

        return $records
            ? DActiveNetwork::getActiveNetworkDetails($records)
            : null;
    }


    public static function getInactiveNetworkDetails(): ?string
    {
        $userId = session('default.customer_id');
        $p      = self::prefix();

        $owned = DB::select(
            "SELECT matrix_id FROM {$p}_matrix_members_link_table WHERE members_id = ?",
            [$userId]
        );

        $where = '';
        if ($owned) {
            $ids   = implode('","', array_column($owned, 'matrix_id'));
            $where = "WHERE a.matrix_id NOT IN (\"{$ids}\")";
        }

        // 2. All other matrices
        $sql = "
            SELECT a.*, b.matrix_type_name, b.matrix_type_id
            FROM {$p}_matrix_table AS a
            LEFT JOIN {$p}_matrix_type_table AS b ON b.matrix_type_id = a.matrix_type_id
            {$where}
        ";

        $records = DB::select($sql);

        return $records
            ? DInactiveNetwork::showInactiveNetworkDetails($records)
            : null;
    }


    public static function getAllGenealogy($members_id, $matrix_id)
    {
        return DActiveNetwork::getAllGenealogy($members_id, $matrix_id);
    }

    public static function getAllGenealogyList($members_id, $matrix_id)
    {
        return DActiveNetwork::getAllGenealogyList($members_id, $matrix_id);
    }


    public static function getActiveNetworkList()
    {
        $user_id = Auth::user()->members_id;
        // dd($user_id);
        $sql     = "SELECT a.*,b.matrix_id,b.matrix_name,b.matrix_type_id,b.matrix_status,c.matrix_type_id,
        c.matrix_type_id,c.matrix_type_name,d.members_status,d.members_doj,d.members_username
        FROM " . env('IHOOK_PREFIX') . "matrix_members_link_table AS a LEFT JOIN " . env('IHOOK_PREFIX') . "_matrix_table
        AS b ON b.matrix_id=a.matrix_id LEFT JOIN " . env('IHOOK_PREFIX') . "matrix_type_table AS c ON c.matrix_type_id=
        b.matrix_type_id  LEFT JOIN " . env('IHOOK_PREFIX') . "members_table AS d ON d.members_id=a.members_id WHERE
        a.members_id='" . $user_id . "' GROUP BY a.matrix_id";
    
            $records = $sql;
            // dd($records);
            return DActiveNetwork::getActiveNetworkList($records);

    }
}

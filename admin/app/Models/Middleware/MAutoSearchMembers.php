<?php
/**
 * This class contains public static functions related to auto search members .
 *
 * @package         MAutoSearchMembers
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\Middleware;

use Admin\App\Display\Middleware\DAutoSearchMembers;

class MAutoSearchMembers {

    public static function getMembers($searchval,$matrix_id,$wherecondition)
    {
        $matrix_where=$matrix_id>0 ? 'AND b.matrix_id='.$matrix_id.'' :'';
        $where=($searchval!='') ? 'WHERE members_username LIKE "' . $searchval . '%" '.$matrix_where.''.$wherecondition.'' :'';
         $sql = "SELECT  a.members_username,a.members_id FROM " . $_ENV['IHOOK_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as b ON a.members_id=b.members_id $where  AND b.members_status>0  GROUP BY members_id LIMIT 0,50 ";

        return DAutoSearchMembers::getMembers($sql);
    }

    public static function getAllMembersNew()
    {
         $sql = "SELECT  a.members_username,a.members_id FROM " . $_ENV['IHOOK_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as b ON a.members_id=b.members_id AND b.members_status>0 order by a.members_username asc";

        return DAutoSearchMembers::getAllMembersNew($sql);
    }

    public static function getMembersList($searchval,$matrix_id,$wherecondition): void
    {
        // dd($matrix_id);
        $matrix_where=$matrix_id>0 ? 'AND b.matrix_id='.$matrix_id.'' :'';
        $where=($searchval!='') ? 'WHERE members_username LIKE "' . $searchval . '%" '.$matrix_where.''.$wherecondition.'' :'';
        $sql = "SELECT  a.members_username,a.members_id FROM " . $_ENV['IHOOK_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as b ON a.members_id=b.members_id $where  AND b.members_status>0  GROUP BY members_id LIMIT 0,50 ";

        // Check if records exist and return as JSON
        if (!empty($obj->records)) {
            // Output data as a JSON response
            echo json_encode($sql);
        } else {
            // Return an empty array if no records are found
            echo json_encode([]);
        }
    }

    public static function getMembersValId($searchval,$matrix_id,$wherecondition)
    {
        $matrix_where=$matrix_id>0 ? 'AND b.matrix_id='.$matrix_id.'' :'';
        $where=($searchval!='') ? 'WHERE members_username LIKE "' . $searchval . '%" '.$matrix_where.''.$wherecondition.'' :'';
         $sql = "SELECT  a.members_username,a.members_id FROM " . $_ENV['IHOOK_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as b ON a.members_id=b.members_id $where  AND b.members_status>0  GROUP BY members_id LIMIT 0,50 ";

        return DAutoSearchMembers::getMembersValId($sql);
    }
}
?>

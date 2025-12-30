<?php
/**
 * This class contains public static functions related to network page
 *
 * @package         MMemberGenealogyDetail
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?>
<?php
namespace Model\MemberArea;
use Query\Bin_Query;

use Display\MemberArea\DMemberGenealogyDetail;
class MMemberGenealogyDetail {
    /**
     * This public static function is used  to get network details of users
     * @return HTML data
     */
    public static function getGenealogyDetail()
    {
        $user_id = trim($_GET['sub1']);
        $sql     = "SELECT a.*,b.matrix_id,b.matrix_name,b.matrix_type_id,b.matrix_status,c.matrix_type_id,
        c.matrix_type_id,c.matrix_type_name,d.members_status,d.members_doj,d.members_username
        FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table AS a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "_matrix_table
        AS b ON b.matrix_id=a.matrix_id LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_type_table AS c ON c.matrix_type_id=
        b.matrix_type_id  LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "members_table AS d ON d.members_id=a.members_id WHERE
        a.members_id='" . $user_id . "' GROUP BY a.matrix_id";
        $obj     = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
       return DMemberGenealogyDetail::getGenealogyDetail($records);

    }
}
?>

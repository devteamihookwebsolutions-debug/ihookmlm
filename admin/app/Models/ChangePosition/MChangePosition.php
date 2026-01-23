<?php

/**
 * This class contains public functions related to MChangePosition
 *
 * @package         MChangePosition
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
namespace Admin\App\Models\ChangePosition;

use Admin\App\Display\ChangePosition\DChangePosition;
use Admin\App\Models\Middleware\MMatrixMemberLink;

class MChangePosition
{

    public static function viewUsers()
    {
        $matrix_id  = $_GET['sub2'];
        $members_id = $_GET['sub1'];
        //member list
        $where   = 'matrix_id="' . $matrix_id . '" AND members_id!="' . $members_id . '" AND members_account_status="1" AND members_status="1"  ORDER BY link_id ASC';
        $records = MMatrixMemberLink::getMatrixLinkDetails($where);
        return DChangePosition::viewUsers($records);
    }
    /**
     * This public static function is used to get the change position.
     * @param int $member1_id
     * @param int $matrix_id
     * @param int $member2_id
     * @param int $matrix_type_id
     * @return boolean data
     */
    public static function getChangePosition($member1_id, $matrix_id, $member2_id, $matrix_type_id)
    {
        $sqldel = "DROP TABLE `" . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table`";
        $objdel = new Bin_Query();
        $objdel->updateQuery($sqldel);
        $sql = "CREATE TABLE " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table AS SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table;";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);
        //member1 details
        $where                      = 'matrix_id="' . $matrix_id . '" AND members_id="' . $member1_id . '" AND members_account_status="1" AND members_status="1"  ORDER BY link_id ASC';
        $recordsmembers_id          = MMatrixMemberLink::getMatrixLinkDetails($where);
        $member1_id_spillover_id    = $recordsmembers_id[0]['spillover_id'];
        $member1_id_members_parents = $recordsmembers_id[0]['members_parents'];
        $member1_id_root            = $recordsmembers_id[0]['root'];
        //member1 spillover details
        $where         = 'matrix_id="' . $matrix_id . '" AND spillover_id="' . $member1_id . '" ORDER BY link_id ASC';
        $recordsspill1 = MMatrixMemberLink::getMatrixLinkDetails($where);
        //member2 details
        $where                      = 'matrix_id="' . $matrix_id . '" AND members_id="' . $member2_id . '" AND members_account_status="1" AND members_status="1"  ORDER BY link_id ASC';
        $recordsmember2_id          = MMatrixMemberLink::getMatrixLinkDetails($where);
        $member2_id_spillover_id    = $recordsmember2_id[0]['spillover_id'];
        $member2_id_members_parents = $recordsmember2_id[0]['members_parents'];
        $member2_id_root            = $recordsmember2_id[0]['root'];

        //member2 spillover details
        $where            = 'matrix_id="' . $matrix_id . '" AND spillover_id="' . $member2_id . '" ORDER BY link_id ASC';
        $recordsspill2    = MMatrixMemberLink::getMatrixLinkDetails($where);
        $Arg1             = explode(',', $member1_id_members_parents);
        $Arg2             = explode(',', $member2_id_members_parents);
        $Difference_1     = array_diff($Arg1, $Arg2);
        $Difference_2     = array_diff($Arg2, $Arg1);
        $samememberparent = array_intersect($Arg1, $Arg2);
        //upline updation
        $samememberparent = $samememberparent;
        $member1_idparent = $Difference_1;
        $member2_idparent = $Difference_2;
        if (count($samememberparent) > 0) {
            //self::uplineMemberChildren($samememberparent, $member1_id, $member2_id, $matrix_id, 'same');
        }
        if (count($member1_idparent) > 0) {
            //self::uplineMemberChildren($member1_idparent, $member1_id, $member2_id, $matrix_id, '');
        }
        if (count($member2_idparent) > 0) {
            //self::uplineMemberChildren($member2_idparent, $member2_id, $member1_id, $matrix_id, '');
        }
        //spilloverupdation
        if (count($recordsspill1) > 0) {
            self::downlineSpilloverUpdation($recordsspill1, $member2_id, $matrix_id);
        }
        if (count($recordsspill2) > 0) {
            self::downlineSpilloverUpdation($recordsspill2, $member1_id, $matrix_id);
        }
        //member1 details
        $sqlrecords1 = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table WHERE matrix_id='" . $matrix_id . "' AND members_id='" . $member1_id . "' AND members_account_status='1' AND members_status='1'  ORDER BY link_id ASC";
        $objrecords1 = new Bin_Query();
        $objrecords1->executeQuery($sqlrecords1);
        $records1child               = $objrecords1->records;
        $member1_id_members_position = $records1child[0]['position'];

        $sqlrecords2 = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table WHERE matrix_id='" . $matrix_id . "' AND members_id='" . $member2_id . "' AND members_account_status='1' AND members_status='1'  ORDER BY link_id ASC";
        $objrecords2 = new Bin_Query();
        $objrecords2->executeQuery($sqlrecords2);
        $records2child               = $objrecords2->records;
        $member2_id_members_position = $records2child[0]['position'];

        //samememberspillover,memberparents,changes
        self::membersDataChanges($member1_id_members_parents, $member1_id_spillover_id, $member2_id, $matrix_id, $member1_id, $member1_id_root, $member1_id_members_position);
        self::membersDataChanges($member2_id_members_parents, $member2_id_spillover_id, $member1_id, $matrix_id, $member2_id, $member2_id_root, $member2_id_members_position);

        //members downline changes
        self::membersDownlineDataChanges($member1_id, $member2_id, $matrix_id);
        self::membersDownlineDataChanges($member2_id, $member1_id, $matrix_id);
        //getdefault details
        $sqldefault = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table WHERE matrix_id='" . $matrix_id . "' AND default_sponsor='1'";
        $objdefault = new Bin_Query();
        $objdefault->executeQuery($sqldefault);
        $recordsdefault     = $objdefault->records;
        $default_members_id = $recordsdefault[0]['members_id'];

        $sqlmembers = "SELECT SQL_CALC_FOUND_ROWS a.*,b.members_email,b.members_firstname,b.members_lastname,b.members_image,b.members_phone,b.members_username,c.members_username AS sponsorname,d.rank_key,d.rank_value,e.rank_value AS rank_icon_path,a.position FROM
            " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table AS a
            LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "members_table AS b ON a.members_id=b.members_id
            LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "members_table AS c ON c.members_id=a.direct_id
            LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "ranksetting AS d ON d.rank_id=a.rankid
            LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "ranksetting AS e ON (e.rank_id=a.rankid && e.rank_key='rank_icon_path')
            WHERE (FIND_IN_SET('" . $default_members_id . "',`members_parents`) || a.members_id='" . $default_members_id . "')
            AND a.matrix_id='" . $matrix_id . "' ORDER BY  a.position ASC";
        $objmembers = new Bin_Query();
        $objmembers->executeQuery($sqlmembers);
        $referralslinkdetails = $objmembers->records;

        if (count((array) $referralslinkdetails) > '0') {
            for ($i = 0; $i < count((array) $referralslinkdetails); $i++) {
                $groupTitleColor          = '#4169e1';
                $itemTitleColor           = '#4169e1';
                $spillover_id             = $referralslinkdetails[$i]['spillover_id'];
                $members_email            = $referralslinkdetails[$i]['members_email'];
                $memberimage              = $referralslinkdetails[$i]['members_image'];
                $memberimage              = $memberimage != '' ? $_ENV['CDNUPLOADURL'] . '/' . $memberimage : '' . $_ENV['UI_ASSET_URL'] . '/assets/pages/img/avatars/avatar.png';
                $members_fullname         = $referralslinkdetails[$i]['members_username'];
                $members_phone            = $referralslinkdetails[$i]['members_phone'];
                $linkid                   = $referralslinkdetails[$i]['link_id'];
                $sponsor_name             = $referralslinkdetails[$i]['sponsorname'];
                $rank_value               = $referralslinkdetails[$i]['rank_value'];
                $members_passup_id        = $referralslinkdetails[$i]['members_passup_id'];
                $members_passup_direct_id = $referralslinkdetails[$i]['members_passup_direct_id'];
                if ($members_passup_id > 0) {
                    $member_details   = MMembersDetails::getUserDetails($members_passup_id);
                    $passupmembername = $member_details['members_username'];
                    $groupTitleColor  = '#4169e1';
                    $itemTitleColor   = '#B800E6';
                    $passupdetails    = ',Passup : ' . $passupmembername . '';
                } else {
                    $passupdetails = '';
                }
                $sponsor_name   = $sponsor_name == '' ? 'Nil' : $sponsor_name;
                $rank           = $rank_value == '' ? 'Nil' : $rank_value;
                $rank_icon_path = $referralslinkdetails[$i]['rank_icon_path'];
                $rank_icon_path = $rank_icon_path == '' ? '' : $_ENV['CDNCLOUDEXTURL'] . '/' . $rank_icon_path;
                if ($referralslinkdetails[$i]['rank_icon_path'] != '' && $referralslinkdetails[$i]['rankid'] > 0) {
                    $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", parent: "' . $spillover_id . '", title: "' . $members_fullname . '", description: "Sponsor : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "Rank : ' . $rank . '", image: "' . $memberimage . '", rankimage: "' . $rank_icon_path . '",  templateName: "contactTemplate", members_id: ' . $referralslinkdetails[$i]['members_id'] . ',groupTitleColor:"' . $groupTitleColor . '",itemTitleColor:"' . $itemTitleColor . '", href: "/genealogy/viewtree/' . $linkid . '"},';
                } else {
                    $output .= '{ id:  "' . $referralslinkdetails[$i]['members_id'] . '", parent: "' . $spillover_id . '", title: "' . $members_fullname . '", description: "Sponsor : ' . $sponsor_name . ' ' . $passupdetails . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "Rank : ' . $rank . '", image: "' . $memberimage . '",rankimage: "0",  templateName: "contactTemplate1", members_id: ' . $referralslinkdetails[$i]['members_id'] . ',groupTitleColor:"' . $groupTitleColor . '",itemTitleColor:"' . $itemTitleColor . '", href: "/genealogy/viewtree/' . $linkid . '"},';
                }
            }
        }
        $output = 'var data=[' . $output . ']';
        /* $upladfile = fopen("../" . $_ENV['CURRENT_UPATH'] . "/shift/previewuser" . $member1_id . "" . $matrix_id . ".js", "w");
        fwrite($upladfile, $output);
        fclose($upladfile);
        $flnm          = '../' . $_ENV['CURRENT_UPATH'] . '/shift/previewuser' . $member1_id . $matrix_id . ".js";
        $amaname       = 'previewuser' . $member1_id . $matrix_id . ".js";
        $genealogyfile = 'uploads/genealogydata/' . $amaname;
        MAmazonS3::amazonFileCreation($flnm, 'text/js', $genealogyfile);
        /*end:amazonupload*/
        return $output;
    }
    /**
     * This public static function is used to get the change position.
     * @param array $originmembersparents
     * @param int $members_id
     * @param int $change_member_id
     * @param int $matrix_id
     * @param int $flag
     * @return boolean data
     */
    public static function uplineMemberChildren($originmembersparents, $members_id, $change_member_id, $matrix_id, $flag)
    {
        $originmembers_parents = implode(',', $originmembersparents);
        $sqlancestor           = "SELECT members_children,members_id FROM " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table WHERE
        members_id IN (" . $originmembers_parents . ") AND matrix_id='" . $matrix_id . "' ";
        $objancestor = new Bin_Query();
        $objancestor->executeQuery($sqlancestor);
        $recordsancestor = $objancestor->records;
        if (count($recordsancestor) > 0) {
            foreach ($recordsancestor as $key => $value) {
                $final_array           = [];
                $final_arrayres        = [];
                $anseupmemberchildren  = '';
                $ancesmembers_children = $recordsancestor[$key]['members_children'];
                $ancesmembers_id       = $recordsancestor[$key]['members_id'];
                $arrseri               = unserialize($ancesmembers_children);
                $arr                   = [];
                foreach ($arrseri as $key => $value) {
                    if ($value == $members_id) {
                        $arr[$key] = 'con,' . $change_member_id;
                    } else {
                        $arr[$key] = $value;
                    }
                    if (count($value) > 1) {
                        $value     = array_replace($value, array_fill_keys(array_keys(preg_grep('/^' . $members_id . '/', $value)), 'con,' . $change_member_id));
                        $arr[$key] = $value;
                    }
                }
                if ($flag == 'same') {
                    foreach ($arr as $key => $value) {
                        if ($value == $change_member_id) {
                            $arr[$key] = 'con,' . $members_id;
                        } else {
                            $arr[$key] = $value;
                        }
                        if (count($value) > 1) {
                            $value     = array_replace($value, array_fill_keys(array_keys(preg_grep('/^' . $change_member_id . '/', $value)), 'con,' . $members_id));
                            $arr[$key] = $value;
                        }
                    }
                }
                foreach ($arr as $key => $value) {
                    $temp = explode(',', $value);
                    if (count($temp) > 1) {
                        $arr[$key] = $temp[1];
                    } else {
                        $arr[$key] = $temp[0];
                    }
                    if (count($value) > 1) {
                        foreach ($value as $keysub => $valuesub) {
                            $tempsub = explode(',', $valuesub);
                            if (count($tempsub) > 1) {
                                $arrsub[$keysub] = $tempsub[1];
                            } else {
                                $arrsub[$keysub] = $tempsub[0];
                            }
                        }
                        $arr[$key] = $arrsub;
                    }
                }
                $anseupmemberchildren = serialize($arr);
                $sqlupances           = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table SET members_children='" . $anseupmemberchildren . "' WHERE members_id='" . $ancesmembers_id . "' AND matrix_id='" . $matrix_id . "'";
                $objupances           = new Bin_Query();
                $objupances->updateQuery($sqlupances);
            }
        }
        return true;
    }
    /**
     * This public static function is used to get the downline spillover updation.
     * @param array $recordspillover
     * @param int $newspillover
     * @param int $matrix_id
     * @return void data
     */
    public static function downlineSpilloverUpdation($recordspillover, $newspillover, $matrix_id)
    {
        if (count($recordspillover) > 0) {
            foreach ($recordspillover as $key => $value) {
                $reqmembers_id  = $recordspillover[$key]['members_id'];
                $sqlmemberspil1 = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table SET
                spillover_id ='" . $newspillover . "'
                WHERE matrix_id='" . $matrix_id . "' AND members_id='" . $reqmembers_id . "'";
                $objmemberspil1 = new Bin_Query();
                $objmemberspil1->updateQuery($sqlmemberspil1);
            }
        }
    }
    /**
     * This public static function is used to get the members data changes.
     * @param int $ownmembersparent
     * @param int $ownspilloverid
     * @param int $ownmemberchildren
     * @param int $ownmembers_id
     * @param int $matrix_id
     * @param int $swapmemberid
     * @param int $ownroot
     * @param int $ownrootplacement
     * @return void data
     */
    public static function membersDataChanges($ownmembersparent, $ownspilloverid, $ownmembers_id, $matrix_id, $swapmemberid, $ownroot, $position)
    {
        if ($ownspilloverid == $ownmembers_id) {
            $ownspilloverid = $swapmemberid;
        }
        $sqlmemberown = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table SET
        members_parents ='" . $ownmembersparent . "',
        spillover_id    ='" . $ownspilloverid . "',
        position='" . $position . "',
        root='" . $ownroot . "'
        WHERE matrix_id='" . $matrix_id . "' AND members_id='" . $ownmembers_id . "'";
        $objmemberown = new Bin_Query();
        $objmemberown->updateQuery($sqlmemberown);
    }
    /**
     * This public static function is used to get the members downline data change.
     * @param int $replacememberid
     * @param int $newmemberid
     * @param int $matrix_id
     * @return void data
     */
    public static function membersDownlineDataChanges($replacememberid, $newmemberid, $matrix_id)
    {
        $sqlmemberdown = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table SET
        members_parents = replace(members_parents , '" . $replacememberid . "', '" . $newmemberid . "')
        WHERE matrix_id='" . $matrix_id . "' AND FIND_IN_SET('" . $replacememberid . "',members_parents) <> 0";
        $objmemberdown = new Bin_Query();
        $objmemberdown->updateQuery($sqlmemberdown);
    }
    /**
     * This public static function is used to get the update change position.
     * @param int $member1_id
     * @param int $matrix_id
     * @param int $change_member_id
     * @return void data
     */
    public static function updateChangePosition($member1_id, $matrix_id, $change_member_id)
    {
        $re       = file_get_contents('../' . $_ENV['CURRENT_UPATH'] . '/Bin/Configuration.php');
        $res      = explode('\'', $re);
        $hostname = $res[1];
        $username = $res[3];
        $password = $res[5];
        $dbname   = $res[7];
        $options  = [
            'db_host'           => $hostname, //mysql host
            'db_uname'          => $username, //user
            'db_password'       => $password, //pass
            'db_to_backup'      => $dbname,   //database name
            'db_backup_path'    => 'shift',   //where to backup
            'db_include_tables' => [
                $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table",
            ], //tables to exclude
        ];
        $backup_file_name = self::backup_mysql_database($options);
        $sql              = "TRUNCATE `" . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table`";
        $obj              = new Bin_Query();
        $obj->updateQuery($sql);
        $sqlin = "INSERT `" . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table` SELECT * FROM `" . $_ENV['IHOOK_PREFIX'] . "preview_matrix_members_link_table`";
        $objin = new Bin_Query();
        $objin->updateQuery($sqlin);
        $_SESSION['success_message'] = __('Position has been changed successfully');
    }
    /**
     * This public static function is used to get the update change position.
     * @param array $options
     * @return html data
     */
    public static function backup_mysql_database($options)
    {
        $mtables  = [];
        $contents = "-- Database: `" . $options['db_to_backup'] . "` --\n";
        $mysqli   = new mysqli($options['db_host'], $options['db_uname'], $options['db_password'], $options['db_to_backup']);

        if ($mysqli->connect_error) {
            die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $results = $mysqli->query("SHOW TABLES");

        while ($row = $results->fetch_array()) {
            if (in_array($row[0], $options['db_include_tables'])) {
                $mtables[] = $row[0];
            }
        }

        foreach ($mtables as $table) {
            $contents .= "-- Table `" . $table . "` --\n";
            $results = $mysqli->query("SHOW CREATE TABLE " . $table);
            while ($row = $results->fetch_array()) {
                $contents .= $row[1] . ";\n\n";
            }

            $results      = $mysqli->query("SELECT * FROM " . $table);
            $row_count    = $results->num_rows;
            $fields       = $results->fetch_fields();
            $fields_count = count($fields);

            $insert_head = "INSERT INTO `" . $table . "` (";
            $columns     = [];

            // Collect column names for the INSERT statement
            for ($i = 0; $i < $fields_count; $i++) {
                $columns[] = "`" . $fields[$i]->name . "`";
            }

            $insert_head .= implode(', ', $columns) . ") VALUES\n";
            $contents .= $insert_head;

            if ($row_count > 0) {
                $r = 0;
                while ($row = $results->fetch_array()) {
                    $contents .= "(";
                    $row_values = [];

                    for ($i = 0; $i < $fields_count; $i++) {
                        $row_content = str_replace("\n", "\\n", $mysqli->real_escape_string($row[$i]));
                        switch ($fields[$i]->type) {
                            case 8: // Date
                            case 3: // Numeric
                                $row_values[] = $row_content;
                                break;
                            default:
                                $row_values[] = "'" . $row_content . "'";
                        }
                    }

                    $contents .= implode(', ', $row_values);
                    if (($r + 1) == $row_count || ($r % 400) == 399) {
                        $contents .= ");\n\n";
                    } else {
                        $contents .= "),\n";
                    }
                    $r++;
                }
            }
        }

        if (! is_dir($options['db_backup_path'])) {
            mkdir($options['db_backup_path'], 0777, true);
        }

        $backup_file_name = $options['db_to_backup'] . " sql-backup- " . date("d-m-Y--h-i-s") . ".sql";
        $fp               = fopen($options['db_backup_path'] . '/' . $backup_file_name, 'w+');

        if (($result = fwrite($fp, $contents))) {
            // echo "Backup file created '--$backup_file_name' ($result)";
        }

        fclose($fp);
        return $backup_file_name;
    }

}

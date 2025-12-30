<?php
/**
 * This class contains public static functions related to user network
 *
 * @package         DWaitingRoom
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?><?php

namespace Display\Network;

use Query\Bin_Query;
use Model\Middleware\MFormatDate;
use Model\Middleware\MMatrixDetails;

class DWaitingRoom
{
    /**
     * This public static function is used to show  network details of member
     * @param array  $records
     *
     * @return HTML data
     */
    public static function showDownlineUser($userrecords)
    {
        if (count((array)$userrecords) > 0) {
            $sno = 1;
            for ($i = 0;$i < count((array)$userrecords);$i++) {
                $country_id = $userrecords[$i]['members_country'];
                $sql = "SELECT * FROM  " . $_ENV['IHOOK_PREFIX'] . "country_master_table WHERE sortname='" . $country_id . "'";
                $obj = new Bin_Query();
                $obj->executeQuery($sql);
                $records = $obj->records;
                $country_master_name = $records[0]['country_master_name'];
                $formatdate = MFormatDate::formatingReportDate($userrecords[$i]['members_doj']);
                $output .= '<tr>
                          <td>' . $sno . '</td>
                           <td>' . $userrecords[$i]['members_username'] . '</td>
                            <td>' . $userrecords[$i]['members_email'] . '</td>
                             <td>' . $formatdate . '</td>
                          <td>' . $userrecords[$i]['members_firstname'] . '</td>
                          <td>' . $userrecords[$i]['members_lastname'] . '</td>
                           <td>' . $country_master_name . '</td>
                          <td>
                          <a aria-label="link" href="'.$_ENV['FCPATH'].'/waitingroom/position/'.$userrecords[$i]['members_id'].'/'.$userrecords[$i]['matrix_id'].'">
                          <button type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-1.5 py-1 text-center me-2 mb-2">Select Position</button>
                          </a>
                          </td>
                        </tr>';

                $sno = $sno + 1;

            }
        }
        return $output;
    }
    public static function getMemberList($recordsmembers)
    {
        $matrix_id = $_POST['matrix_id'];
        $sqlwidth = "SELECT matrix_key,matrix_value FROM  " . $_ENV['IHOOK_PREFIX'] . "matrix_configuration_table
            WHERE matrix_id  = '" . $matrix_id . "' AND matrix_key='level_width'";
        $qrywidth = new Bin_Query();
        $qrywidth->executeQuery($sqlwidth);
        $level_width = $qrywidth->records[0]['matrix_value'];
        $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
        $matrix_type_id = $matrixdetails['matrix_type_id'];
        if ($matrix_type_id == '1') {
            $level_width = 2;
        }
        // echo 'level_width'.$level_width;exit;
        $output = '<div class="bg-neutral-100 p-2 shadow-md rounded-lg cursor-pointer m-scrollable" data-scrollable="true" data-height="120" data-mobile-height="450">';
        $clicklabel = ($_GET['do'] == 'sponsorlist') ? 'getvaluesponsor' : 'getvalue';
        if (count((array)$recordsmembers) > 0) {
            for ($i = 0;$i < count((array)$recordsmembers);$i++) {
                // for($j = 1; $j <= $level_width; $j++){
                // 	$position =self::fetchMembersuserBinary($recordsmembers[$i]['members_id'],$recordsmembers[$i]['matrix_id'],$j);
                // 	if(empty($position)){
                // 		$userposition = $recordsmembers[$i]['members_username']."_POSITION".$j;
                $userposition = $recordsmembers[$i]['members_username'];
                $output .= '<div class="search-suggestion search-selectable" id="' . $recordsmembers[$i]['members_id'] . '_'.$recordsmembers[$i]['members_username'].'" onclick="'.$clicklabel.'(this.id)">' . $userposition . '
						</div>';
                // 	}
                // }
            }
        } else {
            $output .= '<div class="search-suggestion search-selectable" id="' . $recordsmembers[$i]['members_id'] . '" onclick="'.$clicklabel.'(this.id)">' . __('No records found') . '</div>';
        }
        $output .= '</div>';
        echo $output;
        exit;
    }
    public static function fetchMembersuserBinary($members_id, $matrix_id, $appposition)
    {
        $sqlbinarymemberpo = "SELECT a.members_id FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table AS a
         WHERE a.matrix_id='" . $matrix_id . "' AND a.spillover_id='".$members_id."' AND a.position='".$appposition."' ";
        $objbinarymemberpo = new Bin_Query();
        $objbinarymemberpo->executeQuery($sqlbinarymemberpo);
        $rebimembers_id = $objbinarymemberpo->records[0]['members_id'];
        return $rebimembers_id;
    }

}
?>

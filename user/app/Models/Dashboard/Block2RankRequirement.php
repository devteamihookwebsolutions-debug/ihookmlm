<?php
/**
 * This class contains public static functions related to dashboard block 4 details
 *
 * @package         MDashboardBlock4Details
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
?><?php

namespace Model\Dashboard;

use Query\Bin_Query;
use Model\Middleware\MFormatNumber;
use Model\Middleware\MWalletBalance;
use Model\Middleware\MDownlineSales;
use Model\Wordpress\MDownlineShopSales;
use Model\Middleware\MTotalPV;
use Model\Middleware\MTotalGPV;
use Model\Scheduler\Rank\MDirectReferal;
use Model\Scheduler\Rank\MGroupReferal;
use Model\Scheduler\Rank\MProduct;
use Model\Middleware\MTargetSalesAmount;
use Model\Middleware\MGroupSalesTargetAmount;
use Model\Scheduler\Rank\MTarget;
use Model\Scheduler\Rank\MGetLevel;
use Model\Dashboard\Horizontal\MDashboardRankProgress;
class Block2RankRequirement
{
    /**
    * This public static function is used  to show the dashboard sales value
    * @return int data
    */
    public static function getBlock2RankRequirement()
    {
        $user_id = $_SESSION['default']['customer_id'];
        $matrix_id = $_SESSION['matrix']['id'];

        $sql     = "SELECT rankid,matrix_id FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table WHERE members_id =" . $user_id . "";
        $obj     = new Bin_Query();
        $obj->executeQuery($sql);
        $records   = $obj->records;

        $rankid    = $records[0]['rankid'];
        $matrix_id = $records[0]['matrix_id'];


        // Check if the query returns any results
        $sql_current_rank    = "SELECT rank_value FROM  " . $_ENV['IHOOK_PREFIX'] . "ranksetting WHERE matrix_id='" . $matrix_id . "' AND rank_id='" . $rankid . "' AND rank_key='rank_title'";
        $obj_curren_rank    = new Bin_Query();
        $obj_curren_rank->executeQuery($sql_current_rank);
        $currentrank_records = $obj_curren_rank->records;
        if (empty($currentrank_records[0]['rank_value'])) {
            $rankname = 'Null';
        } else {
            $rankname = $currentrank_records[0]['rank_value'];
        }

        $nextrankid = $rankid + 1;
        $sql    = "SELECT rank_key,rank_value FROM  " . $_ENV['IHOOK_PREFIX'] . "ranksetting WHERE matrix_id='" . $matrix_id . "' AND rank_id='" . $nextrankid . "' AND rank_value!='' AND (rank_key REGEXP '^-?[0-9]+$' || rank_key='bonus' || rank_key='rank_title' || rank_key='commission' || rank_key='renewal' || rank_key='rank_icon_path' )  ORDER BY id ASC";
        $obj    = new Bin_Query();
        $obj->executeQuery($sql);
        $records  = $obj->records;

        $rankconditions = array();
        for ($i = 0; $i < count((array)$records); $i++) {

            if ($records[$i]['rank_key'] == 'renewal') {
                $renewal = $records[$i]['rank_value'];
            } elseif (is_numeric($records[$i]['rank_key'])) {
                $rankconditions[$records[$i]['rank_key']] = $records[$i]['rank_value'];
            } elseif ($records[$i]['rank_key'] == 'bonus') {
                $bonus = $records[$i]['rank_value'];
            } elseif ($records[$i]['rank_key'] == 'commission') {
                $commission = $records[$i]['rank_value'];
            } elseif ($records[$i]['rank_key'] == 'rank_title') {
                $nextrankname = $records[$i]['rank_value'];
            }
        }

        $directreferral = MDirectReferal::directReferal($user_id, $matrix_id);
        $groupreferral = MGroupReferal::groupReferal($user_id, $matrix_id);
        $noofsales = MProduct::product($user_id, $matrix_id);
        $noofprodctsold = MProduct::productSold($user_id, $matrix_id);
        $targetachieved = MTarget::target($user_id, $matrix_id);
        $levelcompletion = MGetLevel::getLevel($user_id, $matrix_id, $records[$i]['rank_value']);
        $totalPV = MTotalPV::getTotalPV($user_id, $matrix_id);
        $totalGPV = MTotalGPV::getTotalGPV($user_id, $matrix_id);
        $salestargetamount = MTargetSalesAmount::salesTargetByAmount($user_id, $matrix_id);
        $grouptargetamount = MGroupSalesTargetAmount::groupSalesTarget($user_id, $matrix_id);


        $sqlhistory = "SELECT
                h.*,
                r.rank_value AS rank_name,
                r_icon.rank_value AS rank_icon
            FROM
                " . $_ENV['IHOOK_PREFIX'] . "members_rank_history_table h
            LEFT JOIN
                " . $_ENV['IHOOK_PREFIX'] . "ranksetting r
            ON
                r.matrix_id = '" . $matrix_id . "'
                AND r.rank_id = h.rankid
                AND r.rank_key = 'rank_title'

            LEFT JOIN
            " . $_ENV['IHOOK_PREFIX'] . "ranksetting r_icon
            ON r_icon.matrix_id = '" . $matrix_id . "'
            AND r_icon.rank_id = h.rankid
            AND r_icon.rank_key = 'rank_icon_path'
            WHERE
                h.members_id = '" . $user_id . "'
            ORDER BY
                h.rank_history_id DESC ";
        $objhistory    = new Bin_Query();
        $objhistory->executeQuery($sqlhistory);
        $rankhistory  = $objhistory->records;



        // Check if the query returns any results
        $sql_allnext_rank    = "SELECT rank_value,rank_id FROM  " . $_ENV['IHOOK_PREFIX'] . "ranksetting WHERE matrix_id='" . $matrix_id . "' AND rank_key='rank_title'";
        $obj_allnext_rank    = new Bin_Query();
        $obj_allnext_rank->executeQuery($sql_allnext_rank);
        $allnextrank_records = $obj_allnext_rank->records;


        $nextrank = array(
            'rankname' => $rankname,
            'nextrankconditions' => $rankconditions,
            'directreferral' => $directreferral,
            'groupreferral' => $groupreferral,
            'noofsales' => $noofsales,
            'noofprodctsold' => $noofprodctsold,
            'targetachieved' => $targetachieved,
            'levelcompletion' => $levelcompletion,
            'totalPV' => $totalPV,
            'totalGPV' => $totalGPV,
            'salestargetamount' => $salestargetamount,
            'grouptargetamount' => $grouptargetamount,
            'nextrankname' => $nextrankname,
            'rankhistory' => $rankhistory,
            'allnextranks' => $allnextrank_records
        );
        return $nextrank;

    }
    public static function getBlock2RankDetails()
    {

        $rank_id = $_GET['sub1'];

        $sql    = "SELECT rank_key,rank_value FROM  " . $_ENV['IHOOK_PREFIX'] . "ranksetting WHERE rank_id='" . $rank_id . "' AND rank_value!='' AND (rank_key REGEXP '^-?[0-9]+$' || rank_key='bonus' || rank_key='rank_title' || rank_key='commission' || rank_key='renewal' )  ORDER BY id ASC";
        $obj    = new Bin_Query();
        $obj->executeQuery($sql);
        $records  = $obj->records;

        $rankconditions = array();
        for ($i = 0; $i < count((array)$records); $i++) {

            if ($records[$i]['rank_key'] == 'renewal') {
                $renewal = $records[$i]['rank_value'];
            } elseif (is_numeric($records[$i]['rank_key'])) {
                $rankconditions[$records[$i]['rank_key']] = $records[$i]['rank_value'];
            } elseif ($records[$i]['rank_key'] == 'bonus') {
                $bonus = $records[$i]['rank_value'];
            } elseif ($records[$i]['rank_key'] == 'commission') {
                $commission = $records[$i]['rank_value'];
            } elseif ($records[$i]['rank_key'] == 'rank_title') {
                $nextrankname = $records[$i]['rank_value'];
            }
        }

        echo json_encode($rankconditions);
        exit;
    }

    public static function getRankDetailsRequirements(){
        $rank_id = $_GET['sub1'];
        $user_id = $_SESSION['default']['customer_id'];
        $matrix_id = $_SESSION['default']['matrix_id'];

        $condition = MDashboardRankProgress::rankCondition(
            $user_id,
            $matrix_id,
            $rank_id
        );

        foreach ($condition as $key => $value) {
        $barval = round($value['bar']);
        $output .= ' <div class="border border-neutral-300 rounded-lg p-5 mb-5">
        <div class="progress-bar">
        <div class="flex mb-1 justify-between">
        <div class="text-sm font-medium dark:text-white">
        '.$value['name'].'
        </div>
        <div class="text-sm font-medium dark:text-white">
        '.$value['cval'].' / '.$value['rval'].'
        </div>
        </div>
        <div class="w-full bg-neutral-200 rounded-full h-5 mb-4 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
        <div class="bg-neutral-600 h-5 rounded-full dark:bg-neutral-300 text-white pl-2"
        style="width: '.$barval.'%">'.$barval.' %</div>
        </div>
        </div>
        </div>';
        }
        echo $output;  exit;
    }

}
?>

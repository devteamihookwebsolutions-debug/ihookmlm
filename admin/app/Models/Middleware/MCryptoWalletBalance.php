<?php
/**
 * This class contains public static functions related to user wallet balance.
 *
 * @package         MWalletBalance
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@alphabettechs.com.
 *****************************************************************************/
?><?php

namespace Admin\App\Models\Middleware;

use Query\Bin_Query;
use Model\Middleware\MFormatNumber;

class MCryptoWalletBalance
{
    /**
     * This public static function is used  to get wallet balance
     * @param int $user_id
     * @param int $history_wallet_type
     * @return int data
     */
    public static function getWalletCurrentBalance($user_id, $history_wallet_type, $currency_id)
    {
        $sqlhistypebalance = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "history_type_table";
        $objhistypebalance = new Bin_Query();
        $objhistypebalance->executeQuery($sqlhistypebalance);
        $recordshistypebalance = $objhistypebalance->records;
        if (count($recordshistypebalance) > 0) {
            $creditarray = array();
            $debitarray = array();
            foreach ($recordshistypebalance as $key => $value) {
                $history_credit_type = $recordshistypebalance[$key]['history_credit_type'];
                $history_debit_type = $recordshistypebalance[$key]['history_debit_type'];
                if ($history_credit_type) {
                    $history_type_name = $recordshistypebalance[$key]['history_type_name'];
                    array_push($creditarray, 'history_type="' . $history_type_name . '"');
                }
                if ($history_debit_type) {
                    $history_type_name = $recordshistypebalance[$key]['history_type_name'];
                    array_push($debitarray, 'history_type="' . $history_type_name . '"');
                }
            }
            $credittype = implode(' OR ', $creditarray);
            $debittype = implode(' OR ', $debitarray);
        }
        $wherecon = "WHERE history_member_id='" . $user_id . "' AND  history_wallet_type='" . $history_wallet_type . "' AND currency_id='".$currency_id."' AND (" . $credittype . ")";
        $wallet_credit_amount = self::getWalletBalanceDetails($wherecon);
        $where = "WHERE history_member_id='" . $user_id . "' AND  history_wallet_type='" . $history_wallet_type . "'  AND currency_id='".$currency_id."'  AND (" . $debittype . ")";
        $wallet_debit_amount = self::getWalletBalanceDetails($where);
        $balance_amount = $wallet_credit_amount - $wallet_debit_amount;
        return $balance_amount;
    }
    /**
     * This public static function is used  to get wallet balance
     * @param string $where
     * @return int
     */
    public static function getWalletBalanceDetails($where)
    {
        $sql = "SELECT SUM(history_amount) AS total FROM " . $_ENV['PROMLM_PREFIX'] . "history_table
        " . $where . " ";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $total = $obj->records[0]['total'];
        return $total;
    }

}

?>

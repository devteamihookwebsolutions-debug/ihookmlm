<?php

/**
 * This class contains public functions related to MStairStepCommission
 *
 * @package         MStairStepCommission
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

namespace Admin\App\Models\PaymentConquest;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MTargetSalesAmount;
use Illuminate\Support\Facades\DB;

class MStairStepCommission
{

    public static function checkStairStep($spillover_id, $matrix_id, $member_id, $matrix_type_id)
    {
        $prefix = config('services.ihook.prefix');

        // Get downline count
        $countdown = DB::table($prefix . '_matrix_members_link_table')
            ->whereRaw("FIND_IN_SET(?, members_parents)", [$spillover_id])
            ->where('matrix_id', $matrix_id)
            ->where('default_sponsor', 0)
            ->count();

        $matrixmemberlinkdetails = MMatrixMemberLink::getPartMatrixLinkDetails(
            'stairstep_levelsettings_id,spillover_id',
            'members_id="' . $spillover_id . '" AND matrix_id="' . $matrix_id . '" AND default_sponsor="0"'
        );

        $stairstep_level = $matrixmemberlinkdetails[0]['stairstep_levelsettings_id'] ?? 0;
        $parentspillover_id = $matrixmemberlinkdetails[0]['spillover_id'] ?? 0;

        $step_options = $stairstep_level + 1;
        $stepsettings = self::getStairSetting($step_options, $matrix_id);

        $seconmatrixmemberlinkdetails = MMatrixMemberLink::getPartMatrixLinkDetails(
            'members_id',
            'members_id="' . $parentspillover_id . '" AND matrix_id="' . $matrix_id . '" AND default_sponsor="0"'
        );

        $parentjumpcnt = count($seconmatrixmemberlinkdetails);

        if (count($stepsettings) > 0 && $countdown > 0 && $parentjumpcnt > 0) {
            $options = $stepsettings[0]['stairstep_option'] ?? '';
            $options_value = $stepsettings[0]['stairstep_option_value'] ?? '';
            $stairstep_commission = $stepsettings[0]['stairstep_commission'] ?? 0;
            $stairstep_commission_wallettype = $stepsettings[0]['stairstep_commission_wallettype'] ?? '';
            $stairstep_commission_method = $stepsettings[0]['stairstep_commission_method'] ?? '';
            $crypto_currency = $stepsettings[0]['crypto_qty'] ?? 0;
            $crypto_currency_id = $stepsettings[0]['currency_id'] ?? 0;

            $arrayss = json_decode($options, true) ?? [];
            $arrays_value = json_decode($options_value, true) ?? [];

            // Get total PV
            $totalpv = DB::table($prefix . '_history_table')
                ->where('history_member_id', $spillover_id)
                ->where('history_type', 'pv')
                ->where('history_matrix_id', $matrix_id)
                ->sum('history_amount');

            $stairflag = [];

            foreach ($arrayss as $i => $stairkey) {
                $targetvalue = trim($arrays_value[$i] ?? 0);

                $stairoptionkey = DB::table($prefix . '_stairstep_options')
                    ->where('option_id', $stairkey)
                    ->value('option_key') ?? '';

                if ($stairoptionkey == 'down_count' && $countdown >= $targetvalue) {
                    $stairflag[] = '1';
                }
                if ($stairoptionkey == 'pers_pv' && $totalpv >= $targetvalue) {
                    $stairflag[] = '1';
                }
                if ($stairoptionkey == 'group_pv') {
                    $grouppv = DB::table($prefix . '_history_table . " as a"')
                        ->leftJoin($prefix . 'matrix_members_link_table . " as b"', 'b.members_id', '=', 'a.history_member_id')
                        ->where('b.matrix_id', $matrix_id)
                        ->whereRaw("FIND_IN_SET(?, b.members_parents)", [$spillover_id])
                        ->where('a.history_type', 'pv')
                        ->sum('a.history_amount');

                    if (intval($grouppv) >= $targetvalue) {
                        $stairflag[] = '1';
                    }
                }
                if ($stairoptionkey == 'sales_target') {
                    $salestarget = MTargetSalesAmount::salesTargetByAmount($spillover_id, $matrix_id);
                    if ($salestarget >= $targetvalue) {
                        $stairflag[] = '1';
                    }
                }
            }

            $counts = array_count_values($stairflag);
            $alowedarraycount = $counts['1'] ?? 0;
            $targetfinalcount = count($arrayss);

            if ($targetfinalcount == $alowedarraycount && $spillover_id > 0) {
                MBreakAway::updateChangeSponsor($spillover_id, $matrix_id, $member_id, $matrix_type_id);

                DB::table($prefix . '_matrix_members_link_table')
                    ->where('members_id', $spillover_id)
                    ->where('matrix_id', $matrix_id)
                    ->update(['stairstep_levelsettings_id' => $step_options]);

                $dec = 'Your Stair Step Commission Credited';

                DB::table($prefix . '_history_table')->insert([
                    'history_member_id' => $spillover_id,
                    'history_amount' => $stairstep_commission,
                    'history_type' => 'stairstep',
                    'history_wallet_type' => $stairstep_commission_wallettype,
                    'history_description' => $dec,
                    'history_datetime' => now(),
                    'history_payment' => 0,
                    'history_transaction_id' => '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9),
                    'history_plan_id' => 0,
                    'history_matrix_id' => $matrix_id,
                    'crypto_qty' => $crypto_currency,
                    'currency_id' => $crypto_currency_id,
                ]);

                return true;
            }
        }

        return false;
    }

    public static function getStairSetting($stepoptions, $matrix_id)
    {
        $prefix = config('services.ihook.prefix');

        return DB::table($prefix . '_stairstep_levelsettings')
            ->where('step_levels', $stepoptions)
            ->where('stairstep_status', 1)
            ->where('matrix_id', $matrix_id)
            ->get()
            ->toArray();
    }

}


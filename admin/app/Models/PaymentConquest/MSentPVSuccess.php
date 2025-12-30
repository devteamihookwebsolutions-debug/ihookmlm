<?php

namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\Member\History;
use Illuminate\Support\Collection;

class MSentPVSuccess
{
    /**
     * PV goes to the SPONSOR (spilloverId)
     *
     * @param int   $members_id
     * @param float $pv_value
     * @param int   $matrix_id
     * @param int   $package_id
     * @param int   $spilloverId
     */
    public static function sentPV($members_id, $pv_value, $matrix_id, $package_id, $spilloverId)
    {
        // Handle if someone passes a Collection
        if ($pv_value instanceof Collection) {
            $pv_value = $pv_value->sum('pv_value');
        }

        $pv_value = (float) $pv_value;

        $description = $package_id > 0
            ? 'PV has been earned from package purchased'
            : 'PV has been earned through member registration';

        $history = new History();
        $history->history_member_id       = $members_id;
        $history->history_members_ref_id  = $members_id;
        $history->history_amount          = $pv_value;
        $history->history_type            = 'pv';
        $history->history_description     = $description;
        $history->history_datetime        = now();
        $history->history_payment         = 0;
        $history->history_transaction_id  = '#' . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 9);
        $history->history_plan_id         = $package_id ?: 0;
        $history->history_matrix_id       = $matrix_id;
        $history->history_wallet_type     = '1';

        $history->save();
    }
}

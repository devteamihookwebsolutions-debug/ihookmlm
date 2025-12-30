<?php

namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MFormatNumber;

class MWalletBalance
{
    public static function getWalletCurrentBalance($user_id, $history_wallet_type)
    {
        $prefix = env('IHOOK_PREFIX', '');

        // Correct table names with underscore
        $typeTable     = $prefix . '_history_type_table';
        $historyTable  = $prefix . '_history_table';

        // Fetch all history types
        $historyTypes = DB::table($typeTable)->get();

        $creditTypes = [];
        $debitTypes  = [];

        foreach ($historyTypes as $type) {
            if (!empty($type->history_credit_type)) {
                $creditTypes[] = $type->history_type_name;
            }
            if (!empty($type->history_debit_type)) {
                $debitTypes[] = $type->history_type_name;
            }
        }

        // Build IN() conditions safely
        $creditIn = !empty($creditTypes)
            ? 'history_type IN (' . substr(str_repeat('?,', count($creditTypes)), 0, -1) . ')'
            : '1 = 0';

        $debitIn = !empty($debitTypes)
            ? 'history_type IN (' . substr(str_repeat('?,', count($debitTypes)), 0, -1) . ')'
            : '1 = 0';

        // Single query for both credit and debit
        $sql = "
            SELECT
                COALESCE(SUM(CASE WHEN {$creditIn} THEN history_amount ELSE 0 END), 0) as credit_amount,
                COALESCE(SUM(CASE WHEN {$debitIn} THEN history_amount ELSE 0 END), 0) as debit_amount
            FROM {$historyTable}
            WHERE history_member_id = ?
              AND history_wallet_type = ?
        ";

        // Combine parameters: credit types + debit types + user_id + wallet_type
        $bindings = array_merge(
            $creditTypes,
            $debitTypes,
            [$user_id, $history_wallet_type]
        );

        $result = DB::selectOne($sql, $bindings);

        $balance = ($result->credit_amount ?? 0) - ($result->debit_amount ?? 0);

        return MFormatNumber::formatPaymentAmount($balance);
    }

    // Optional: Keep old method if other code still uses it (but fix it too!)
    public static function getWalletBalanceDetails($where, $bindings = [])
    {
        $prefix = env('IHOOK_PREFIX', '');
        $sql = "SELECT COALESCE(SUM(history_amount), 0) AS total
                FROM {$prefix}_history_table
                {$where}";

        $result = DB::selectOne($sql, $bindings);
        return $result->total ?? 0;
    }
}

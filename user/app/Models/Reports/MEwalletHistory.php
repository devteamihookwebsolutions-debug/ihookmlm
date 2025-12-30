<?php

namespace User\App\Models\Reports;
use User\App\Display\Reports\DEwalletHistory;
use User\App\Models\History;
use User\App\Models\WalletType;
use Illuminate\Support\Facades\Auth;

class MEwalletHistory
{
public static function ewalletHistory($user_id, $startdate = null, $enddate = null)
{
    $history_wallet_type = WalletType::where('wallet_default_name', 'e-wallet')
                                     ->value('wallet_type_id');

    // Debug
    // dd(['wallet_type' => $history_wallet_type]);

    $query = History::where('history_member_id', $user_id)
                    ->where('history_wallet_type', $history_wallet_type);

    if ($startdate && $enddate) {
        $query->whereBetween('history_datetime', [
            date("Y-m-d 00:00:00", strtotime($startdate)),
            date("Y-m-d 23:59:59", strtotime($enddate))
        ]);
    }

    $records = $query->get();

    // DEBUG:
    // dd([
    //     'sql' => $query->toSql(),
    //     'bindings' => $query->getBindings(),
    //     'records' => $records
    // ]);

    return DEwalletHistory::ewalletHistory($records->toArray());
}

}

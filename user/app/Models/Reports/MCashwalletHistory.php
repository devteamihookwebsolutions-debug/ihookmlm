<?php

namespace User\App\Models\Reports;
use User\App\Display\Reports\DCashwalletHistory;
use User\App\Models\LeadContact;
use User\App\Models\History;
use User\App\Models\WalletType;
use Illuminate\Support\Facades\Auth;

class MCashwalletHistory
{
public static function cashWalletHistory($user_id, $startdate = null, $enddate = null)
{
    $history_wallet_type = WalletType::where('wallet_default_name', 'cashwallet')
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

    return DCashwalletHistory::cashWalletHistory($records->toArray());
}



public static function leadcontact()
{
  
    $userId = Auth::user()->members_id;


    $records = LeadContact::where('leads_memer_id', $userId)->get();

    
    return DCashwalletHistory::leadcontact($records);
}
}

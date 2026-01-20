<?php

/**
 * This class contains public functions related to TransactionController
 *
 * @package         TransactionController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Http\Controllers\MemberArea;
use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Member\User;
use Admin\App\Models\MemberArea\MemberHistrory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function memberAreaTransaction($memberId)
    {
        $transactionTypes = [
            'levelcommission',
            'directcommission',
            'xupcommission',
            'binarycommission',
            'cyclecommission',
            'productlevelcommission',
            'packagelevelcommission',
            'ewalletdeducts',
            'ewalletcredits',
            'adminbonus',
            'admindeduct',
            'epinpurchasededuct',
            'joiningcommission',
            'entrybonus',
            'exitbonus',
            'custombonus',
            'stairwellcommission',
            'qualificationbonus',
            'directbonus',
            'networkbonus',
            'matchingbonus',
            'dailybinarycommision',
            'weeklybinarycommision',
            'monthlybinarycommision',
            'stairstep',
            'generationbonus',
            'customer_acquisition_bonus',
            'customer_retail_commission',
            'membershipcommission',
            'split_commission',
            'pool',
            'rankbonus',
            'pv',
            'deductpv',
            'fundtransferred',
            'fundreceived',
            'withdraw_pending',
            'withdrawal',
            'withdrawcompleted'
        ];

        $rows = MemberHistrory::where('history_member_id', $memberId)
            ->whereIn('history_type', $transactionTypes)
            ->orderByDesc('history_datetime')
            ->get(['history_datetime', 'history_description', 'history_amount', 'history_type']);
        return view('admin::memberarea.partials.transaction_rows', compact('rows'))->render();
    }
    public function userDetailsWithdrawal($memberId)
    {
        $rows = MemberHistrory::where('history_member_id', $memberId)
            ->whereIn('history_type', ['withdraw_pending','withdrawal','withdrawcompleted'])
            ->orderByDesc('history_datetime')
            ->get([
                'history_id','history_amount','account_id','history_type',
                'history_datetime'
            ]);

        return view('admin::memberarea.partials.withdrawal_rows', compact('rows'))->render();
    }

    public function showUserDetailsPv($memberId)
    {
        $rows = MemberHistrory::where('history_member_id', $memberId)
            ->where('history_type', 'pv')
            ->orderByDesc('history_datetime')
            ->get(['history_datetime','history_description','history_amount']);
            // dd($rows);
        return view('admin::memberarea.partials.pv_rows', compact('rows'))->render();
    }

public function showUserFundTransfer($memberId)
{
     $rows = MemberHistrory::with('member') // eager load member info
        ->where('history_member_id', $memberId)
        ->orderBy('history_datetime', 'desc')
        ->get();

    return view('admin::memberarea.partials.fundtransfer_rows', compact('rows'))->render();
}

}

<?php

namespace Admin\App\Models\Reports;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Reports;
use Admin\App\Models\Member\PaymentHistory;
// use Display\Reports\DAdminEarningReports; //  Make sure this class exists
use Admin\App\Display\Reports\DAdminEarningsReports;

class MAdminEarningReports
{
    public static function adminEarnings($request)
    {
        $limit = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;
        $columnIndex = (int) $request->input('columnIndex', 0);
        $queryValue = $request->input('query', null);

        $prefix = 'ihook_';
        // dd($prefix);
        $wheres = '';

        //  Handle filters
        if (!empty($queryValue)) {
            switch ($columnIndex) {
                case 0:
                    $wheres .= " AND b.members_username='" . trim($queryValue) . "'";
                    break;
                case 1:
                    $wheres .= " AND a.history_type='" . trim($queryValue) . "'";
                    break;
                case 2:
                    $wheres .= " AND a.history_transaction_id='" . trim($queryValue) . "'";
                    break;
                case 3:
                    $dates = explode('|', $queryValue);
                    if (count($dates) === 2) {
                        $startDate = date("Y-m-d", strtotime($dates[0]));
                        $endDate = date("Y-m-d", strtotime($dates[1]));
                        $wheres .= " AND (DATE(b.members_doj) >= '{$startDate}' AND DATE(b.members_doj) <= '{$endDate}')";
                    }
                    break;
                case 4:
                    $wheres .= " AND a.history_description='" . trim($queryValue) . "'";
                    break;
                case 5:
                    $wheres .= " AND c.paymenthistory_status='" . trim($queryValue) . "'";
                    break;
            }
        }

        //  First SELECT (history)
        $query1 = DB::table($prefix . 'history_table AS a')
            ->selectRaw("
                a.history_id,
                a.history_type,
                a.history_transaction_id,
                a.history_datetime,
                a.history_description,
                a.history_member_id,
                a.history_amount,
                a.history_matrix_id,
                a.history_fund_transfer_from_to_id AS history_status,
                a.history_wallet_type,
                a.currency_id,
                b.members_username,
                b.members_id
            ")
            ->join($prefix . 'members_table AS b', 'a.history_members_ref_id', '=', 'b.members_id')
            ->whereIn('a.history_type', ['withdrawal', 'fundtransferred'])
            ->where('a.history_fund_transfer_from_to_id', '=', 0);

        //  Second SELECT (paymenthistory)
        $query2 = DB::table($prefix . 'paymenthistory_table AS c')
            ->selectRaw("
                c.paymenthistory_id AS history_id,
                c.paymenthistory_type AS history_type,
                c.paymenthistory_trans_id AS history_transaction_id,
                c.paymenthistory_date AS history_datetime,
                c.paymenthistory_type AS history_description,
                c.paymenthistory_member_id AS history_member_id,
                c.paymenthistory_amount AS history_amount,
                c.matrix_id AS history_matrix_id,
                c.paymenthistory_status AS history_status,
                c.paymenthistory_mode AS history_wallet_type,
                c.payment_user_request_currency_id AS currency_id,
                d.members_username,
                d.members_id
            ")
            ->join($prefix . 'members_table AS d', 'c.paymenthistory_member_id', '=', 'd.members_id')
            ->whereRaw("1=1 {$wheres}");

        //  Combine both queries using UNION
        $unionQuery = $query1->union($query2);

        // Wrap UNION in subquery to apply order and pagination
        $records = DB::query()
            ->fromSub($unionQuery, 'combined')
            ->orderByDesc('history_id')
            ->offset($offset)
            ->limit($limit)
            ->get();

        //  Count totals
        $count1 = DB::table($prefix . 'history_table AS a')
            ->join($prefix . 'members_table AS b', 'a.history_members_ref_id', '=', 'b.members_id')
            ->whereIn('a.history_type', ['withdrawal', 'fundtransferred'])
            ->where('a.history_fund_transfer_from_to_id', '=', 0)
            ->count();

        $count2 = DB::table($prefix . 'paymenthistory_table AS c')
            ->join($prefix . 'members_table AS d', 'c.paymenthistory_member_id', '=', 'd.members_id')
            ->whereRaw("1=1 {$wheres}")
            ->count();

        $iTotal = $count1 + $count2;
        $totalPages = ceil($iTotal / $limit);
        // dd($records);
        //Return result to display layer
        return DAdminEarningsReports::adminEarnings($records, $totalPages, $iTotal);
    }

public static function adminEarningsDetails($id)
{
    if (empty($id)) {
        return response()->json(['error' => 'Invalid ID'], 400);
    }

    // history table query
    $historyQuery = DB::table('ihook_history_table as a')
        ->join('ihook_members_table as b', 'a.history_members_ref_id', '=', 'b.members_id')
        ->select(
            'a.history_id',
            'a.history_type',
            'a.history_transaction_id',
            'a.history_datetime',
            'a.history_description',
            'a.history_member_id',
            'a.history_amount',
            'a.history_matrix_id',
            DB::raw('a.history_fund_transfer_from_to_id AS history_status'),
            'a.history_wallet_type',
            'b.members_username',
            'b.members_id'
        )
        ->whereIn('a.history_type', ['withdrawal', 'fundtransferred'])
        ->where('a.history_fund_transfer_from_to_id', 0)
        ->where('a.history_id', $id);

    // payment history query
    $paymentQuery = DB::table('ihook_paymenthistory_table as c')
        ->join('ihook_members_table as d', 'c.paymenthistory_member_id', '=', 'd.members_id')
        ->select(
            'c.paymenthistory_id as history_id',
            'c.paymenthistory_type as history_type',
            'c.paymenthistory_trans_id as history_transaction_id',
            'c.paymenthistory_date as history_datetime',
            'c.paymenthistory_type as history_description',
            'c.paymenthistory_member_id as history_member_id',
            'c.paymenthistory_amount as history_amount',
            'c.matrix_id as history_matrix_id',
            'c.paymenthistory_status as history_status',
            'c.paymenthistory_mode as history_wallet_type',
            'd.members_username',
            'd.members_id'
        )
        ->where('c.paymenthistory_id', $id);

    $records = $historyQuery->union($paymentQuery)->get();

    if ($records->isEmpty()) {
        return response()->json(['message' => 'No records found'], 404);
    }
// dd($records);
    return DAdminEarningsReports::adminEarningsDetails($records);
}

}

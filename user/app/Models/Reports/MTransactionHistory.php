<?php

namespace User\App\Models\Reports;

use Auth;
use User\App\Display\Reports\DTransactionHistory;
use User\App\Models\History;
use User\App\Models\HistoryType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MTransactionHistory
{
public static function TransactionHistory($user_id, $startdate = null, $enddate = null, $status = null, $type = null)
{
    $validTypes = [
        'levelcommission', 'directcommission', 'xupcommission', 'binarycommission', 'cyclecommission',
        'productlevelcommission', 'packagelevelcommission', 'ewalletdeducts', 'ewalletcredits',
        'adminbonus', 'admindeduct', 'epinpurchasededuct', 'joiningcommission', 'entrybonus',
        'exitbonus', 'custombonus', 'stairwellcommission', 'qualificationbonus', 'directbonus',
        'networkbonus', 'matchingbonus', 'dailybinarycommision', 'weeklybinarycommision',
        'monthlybinarycommision', 'stairstep', 'generationbonus', 'customer_acquisition_bonus',
        'customer_retail_commission', 'membershipcommission', 'split_commission', 'pool',
        'rankbonus', 'pv', 'deductpv',
        'fundtransferred', 'fundreceived',
        'withdraw_pending', 'withdrawal', 'withdrawcompleted'
    ];

    $query = History::where('history_member_id', $user_id)
        ->whereIn('history_type', $validTypes);

    // Date filter (start & end date)
    if (!empty($startdate) && !empty($enddate)) {
        $query->whereBetween(DB::raw("DATE(history_datetime)"), [$startdate, $enddate]);
    }

    if (!is_null($status)) {
        if ($status == 2) {
            $query->where('history_type', 'withdraw_pending');
        } else {
            $query->whereIn('history_type', ['withdrawal', 'withdrawcompleted']);
        }
    }

    $request = request();
    if ($request->filled('type') && in_array($request->type, $validTypes)) {
        $query->where('history_type', $request->type);
    }

    if (!is_null($type) && in_array($type, $validTypes)) {
        $query->where('history_type', $type);
    }

    // dd($query);
// return $query
//     ->orderBy('history_datetime', 'desc')
//     ->paginate(10)
//     ->appends(request()->all());
return $query
    ->orderBy('history_datetime', 'desc')
    ->get()
    ->toArray();



}


public static function getTransactionType()
{
    $typeMapping = [
        'levelcommission'               => 'Level Commission',
        'directcommission'              => 'Direct Commission',
        'xupcommission'                 => 'X-up Commission',
        'binarycommission'              => 'Binary Commission',
        'cyclecommission'               => 'Cycle Commission',
        'productlevelcommission'        => 'Product Level Commission',
        'packagelevelcommission'        => 'Package Level Commission',
        'ewalletdeducts'                => 'Ewallet Deduct',
        'ewalletcredits'                => 'Ewallet Credit',
        'adminbonus'                    => 'Admin Bonus',
        'admindeduct'                   => 'Admin Deduct',
        'epinpurchasededuct'            => 'Epin Purchase Deduct',
        'joiningcommission'             => 'Joining Commission',
        'entrybonus'                    => 'Entry Bonus',
        'exitbonus'                     => 'Exit Bonus',
        'custombonus'                   => 'Custom Bonus',
        'stairwellcommission'           => 'Stairwell Commission',
        'qualificationbonus'            => 'Qualification Bonus',
        'directbonus'                   => 'Direct Bonus',
        'networkbonus'                  => 'Network Bonus',
        'matchingbonus'                 => 'Matching Bonus',
        'dailybinarycommision'          => 'Daily Binary Commission',
        'weeklybinarycommision'         => 'Weekly Binary Commission',
        'monthlybinarycommision'        => 'Monthly Binary Commission',
        'stairstep'                     => 'Stairstep Commission',
        'generationbonus'               => 'Generation Bonus',
        'customer_acquisition_bonus'    => 'Customer Acquisition Bonus',
        'customer_retail_commission'    => 'Customer Retail Commission',
        'membershipcommission'          => 'Membership Commission',
        'split_commission'              => 'Split Commission',
        'pool'                          => 'Pool Bonus',
        'rankbonus'                     => 'Rank Bonus',
        'pv'                            => 'PV Credit',
        'deductpv'                      => 'PV Deduct',
        'fundtransferred'               => 'Fund Transferred',
        'fundreceived'                  => 'Fund Received',
        'withdraw_pending'              => 'Withdrawal Pending',
        'withdrawal'                    => 'Withdrawal Requested',
        'withdrawcompleted'             => 'Withdrawal Completed',
    ];



    $records = collect($typeMapping)->map(function ($name, $type) {
        return (object) [
            'history_type_name' => $type,
            'history_name'      => $name,
        ];
    })->sortBy('history_name');

    return DTransactionHistory::showTransactionType($records);
}


public static function createpdf($history_id)
{
    $user_id = Auth::user()->members_id;

    // --------------------------------------
    // 1. Get Member Details
    // --------------------------------------
    $member = DB::table('members_table')->where('members_id', $user_id)->first();

    if (!$member) {
        throw new \Exception("Member not found");
    }

    // --------------------------------------
    // 2. Get Site Settings
    // --------------------------------------
    $settings = DB::table('sitesettings_table')
        ->whereIn('sitesettings_name', ['site_currency', 'company_address'])
        ->pluck('sitesettings_value', 'sitesettings_name');

    $site_currency   = $settings['site_currency'] ?? '';
    $company_address = str_replace(',', '<br />', $settings['company_address'] ?? '');

    // --------------------------------------
    // 3. Get Invoice Record
    // --------------------------------------
    $history = DB::table('history_table')->where('history_id', $history_id)->first();

    if (!$history) {
        throw new \Exception("History record not found");
    }

    $invoice_number      = $history->history_transaction_id;
    $payment_method      = ($history->history_wallet_type == 1) ? "E-Wallet" : "C-Wallet";
    $history_amount      = number_format($history->history_amount, 2);
    $history_datetime    = date('Y-m-d H:i:s', strtotime($history->history_datetime));

    // --------------------------------------
    // 4. Get Invoice Template Content
    // --------------------------------------
    $invoiceTemplate = MInvoiceSelection::showSelectedInvoice();
    $invoiceHtml     = $invoiceTemplate['invoice_content'];

    // --------------------------------------
    // 5. Get Company Details (converted from session)
    // --------------------------------------
    $company_name    = setting('company_name');
    $company_address = setting('company_address');
    $company_email   = setting('company_city');
    $currency        = setting('site_currency');

    // --------------------------------------
    // 6. Replace Shortcodes
    // --------------------------------------
    $invoiceHtml = str_replace(
        [
            '{{$company_logo}}',
            '{{$company_name}}',
            '{{$company_address}}',
            '{{$company_email}}',
            '{{$invoice_number}}',
            '{{$invoice_date}}',
            '{{$order_date}}',
            '{{$customer_name}}',
            '{{$customer_email}}',
            '{{$customer_id}}',
            '{{$item_description}}',
            '{{$item_date}}',
            '{{$item_amount}}',
            '{{$currency}}',
            '{{$subtotal}}',
            '{{$grand_total}}',
        ],
        [
            '', // logo base64 (optional)
            $company_name,
            nl2br($company_address),
            $company_email,
            $invoice_number,
            now()->format('Y-m-d'),
            $history_datetime,
            $member->members_firstname . ' ' . $member->members_lastname,
            $member->members_email,
            $member->members_username,
            $history->history_description,
            $history_datetime,
            $history_amount,
            $currency,
            $history_amount,
            $history_amount,
        ],
        $invoiceHtml
    );
    // dd($invoiceHtml);
    return $invoiceHtml;
}
}

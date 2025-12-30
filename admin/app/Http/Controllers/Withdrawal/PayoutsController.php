<?php

namespace Admin\App\Http\Controllers\Withdrawal;

use Admin\App\Http\Controllers\Controller;
use User\App\Models\PaymentHistory;
use Admin\App\Models\Withdrawal\MPayouts;
use Admin\App\Models\Member\History;
use Admin\App\Models\Member\GeneralSetting;
use Illuminate\Http\Request;
use Admin\App\Models\Middleware\MFormatNumber;
use Illuminate\Http\RedirectResponse;
use Exception;

class  PayoutsController extends Controller
{
public function showWithdrawal()
{
    $output['withdraw'] = MPayouts::showWithdrawal();
    $output['completedwithdraw'] = MPayouts::showCompletedWithdrawal();
    $output['cancelledwithdraw'] = MPayouts::showCancelleddWithdrawal(); // add as a new key

    // Update unseen withdrawals (optional)
    // MPayouts::updateUnseenWithdrawal();

    // Return Blade view
    return view('withdrawal.withdraw', $output);
}



public  function changeWithdrawalStatus($id, $mid)
{
    // dd('function reached or not');
    try {
        // Fetch admin withdrawal commission
        $adminCommission = GeneralSetting::where('generalsettings_name', 'admin_withdraw_commission')
            ->value('generalsettings_value');
// dd($adminCommission);
        // Get withdrawal history record
        $withdrawal = History::where('history_id', $id)->firstOrFail();
// dd($withdrawal);
        $withdrawAmount = $withdrawal->history_amount;

        // Calculate admin earnings
        $adminEarning = $withdrawAmount * ($adminCommission / 100);
        $finalWithdrawAmount = $withdrawAmount - $adminEarning;

        // Format amount
        $formattedFinalAmount = MFormatNumber::formatingNumberCurrency($finalWithdrawAmount, 2, '.', '');
        $formattedAdminEarning = MFormatNumber::formatingNumberCurrency($adminEarning, 2, '.', '');
        // dd($formattedAdminEarning);

        // Update withdrawal record
        $withdrawal->update([
            'history_payment'     => $formattedFinalAmount,
            'history_type'        => 'withdrawal',
            'history_description' => 'Amount deposited after admin approval on ' . now(),
            'updated_on'          => now(),
        ]);
// dd($withdrawal);
        // Insert admin commission entry
        History::create([
            'history_member_id' => $mid,
            'history_members_ref_id' => $mid,
            'history_amount'         => $formattedAdminEarning,
            'history_type'           => 'withdrawal',
            'history_description'    => 'withdrawal commission paid',
            'history_datetime'       => now(),
            'history_payment'        => 0,
            'history_transaction_id' => '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal status has been updated successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Error: '.$e->getMessage()
        ], 500);
    }
}
public function cancelWithdrawalStatus($id, $mid)
{
    // dd('function reached or not');
    try {

        // Get admin withdrawal commission
        $adminCommission = GeneralSetting::where('generalsettings_name', 'admin_withdraw_commission')
            ->value('generalsettings_value');
        // Get the withdrawal history row
        $withdrawal = History::where('history_id', $id)->firstOrFail();

        $withdrawAmount = $withdrawal->history_amount;

        // Calculate admin earning
        $adminEarning = $withdrawAmount * ($adminCommission / 100);
        $formattedAdminEarning = number_format($adminEarning, 2, '.', '');

        // Delete withdrawal record
        $withdrawal->delete();

        // Insert admin commission entry
        History::create([
            'history_member_id' =>$mid,
            'history_members_ref_id' => $mid,
            'history_amount'         => $formattedAdminEarning,
            'history_type'           => 'withdrawal',
            'history_description'    => 'withdrawal commission paid',
            'history_datetime'       => now(),
            'history_payment'        => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal status cancelled successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}


}
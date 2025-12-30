<?php
namespace Admin\App\Models\PaymentConquest;

use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\History;
use Admin\App\Models\Middleware\MMatrixConfiguration;

class MJoiningCommission
{

  public static function sentJoiningCommission($memberId, $matrixId, $paymentAmtExclusive)
    {


        // Step 1: Check if joining commission is active
        $joining_commission_status = MatrixConfiguration::where('matrix_id', $matrixId)
            ->where('matrix_key', 'joining_commission_status')
            ->value('matrix_value');

        if ($joining_commission_status !== '1') {
            return false;
        }

        // Step 2: Get commission configuration
        $joining_commission_type = MatrixConfiguration::where('matrix_id', $matrixId)
            ->where('matrix_key', 'joining_commission_type')
            ->value('matrix_value');

        $joining_commission = MatrixConfiguration::where('matrix_id', $matrixId)
            ->where('matrix_key', 'joining_commission')
            ->value('matrix_value');

        $walletType = MatrixConfiguration::where('matrix_id', $matrixId)
            ->where('matrix_key', 'joining_commission_wallet_type')
            ->value('matrix_value');

        $historyWalletType = ($walletType == '1') ? '1' : '2';

        // Step 3: Calculate joining commission
        $joining_commission = ($joining_commission_type == '%')
            ? $paymentAmtExclusive * ($joining_commission / 100)
            : $joining_commission;

        $dec = '' .  __('Joining commission has been earned from registration') . '';


        if ($joining_commission >0) {

        // Step 4: Get cryptocurrency details
        // $cryptoId = MatrixConfiguration::where('matrix_id', $matrixId)
        //     ->where('matrix_key', 'join_commission_cryptocurrency')
        //     ->value('matrix_value');

        // $cryptoName = CryptoCurrency::where('crypto_currency_id', $cryptoId)
        //     ->value('crypto_default_name');

        // $cryptoValue = MCryptoConverter::cryptoConverter($cryptoName);
        // $cryptoValue = str_replace(',', '', $cryptoValue);

        // $cryptoQty = ($cryptoValue != 0)
        //     ? $joiningCommission / $cryptoValue
        //     : 0;

        // $cryptoQty = number_format($cryptoQty, 6, '.', '');
        // $formattedAmount = MFormatNumber::formatPaymentAmount($joiningCommission);

        // Step 5: Save to history table (Eloquent style)
        $history = new History();
        $history->history_member_id      = $memberId;
        $history->history_amount         = $joining_commission;
        $history->history_type           = 'joiningcommission';
        $history->history_description    = __('Joining commission has been earned from registration');
        $history->history_datetime       = now();
        $history->history_payment        = 0;
        $history->history_wallet_type    = $historyWalletType;
        $history->history_matrix_id      = $matrixId;
        $history->history_members_ref_id = $memberId;
        $history->history_transaction_id = '#' . substr(number_format(time() * rand(), 0, '', ''), 0, 9);
        // $history->crypto_qty             = $cryptoQty;
        // $history->currency_id            = $cryptoId;
        $history->save();

        }

        return true;
    }



}

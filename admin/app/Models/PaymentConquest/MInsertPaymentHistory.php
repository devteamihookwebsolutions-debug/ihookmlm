<?php
namespace Admin\App\Models\PaymentConquest;
use Admin\App\Models\Member\PaymentHistory;
use DateTime;

class MInsertPaymentHistory
{

    public function getInsertPaymentHistory( $members_id, $paymenthistory_amount,
                    $payment_amt_exclusive, $paymenthistory_trans_id, $paymenthistory_type,$paymenthistory_status,
                    $matrix_id,$paymenthistory_plan_id, $transaction_id,$payment_user_request_amount,
                    $paymenthistory_mode
                )

    {
        // dd('function reached or not ');
        // Create and save PaymentHistory via Eloquent
            $PaymentHistory = new PaymentHistory();
            $PaymentHistory->paymenthistory_member_id = $members_id;
            $PaymentHistory->paymenthistory_amount = $paymenthistory_amount;
            $PaymentHistory->payment_amt_exclusive = $payment_amt_exclusive;
            $PaymentHistory->paymenthistory_trans_id = $paymenthistory_trans_id;
            $PaymentHistory->paymenthistory_type =  $paymenthistory_type;
            $PaymentHistory->paymenthistory_status = $paymenthistory_status;
            $PaymentHistory->matrix_id = $matrix_id;
            $PaymentHistory->paymenthistory_plan_id =  $paymenthistory_plan_id;
            $PaymentHistory->transaction_id = $transaction_id;
            $PaymentHistory->payment_user_request_amount = $payment_user_request_amount;
            $PaymentHistory->created_on = date('Y-m-d H:i:s');
            $PaymentHistory->paymenthistory_date = date('Y-m-d H:i:s');
            $PaymentHistory->paymenthistory_mode = $paymenthistory_mode;
            $PaymentHistory->save();
            // dd($PaymentHistory);
            $payment_id = $PaymentHistory->paymenthistory_id;


        // Continue post-save logic
        // if ($payment_id > 0) {
        //     // Update Personal / Direct / Total Sales
        //     if ($members_subscription_plan > 0) {
        //         MPersonalSalesUpdate::updatePersonalSales($members_id, $matrix_id, $format_paymenthistory_amount);
        //         MDirectSalesUpdate::updateDirectSales($members_id, $matrix_id, $format_paymenthistory_amount);
        //         MTotalSalesUpdate::updateTotalSales($members_id, $matrix_id, $format_paymenthistory_amount);
        //     }

        //     // Cheque Payment
        //     if ($paymentsettings_default_name === 'cheque') {
        //         MChequePaymentDetails::insertChequePaymentDetails($members_id, $payment_id, $format_paymenthistory_amount);
        //     }

        //     // Ewallet Payment
        //     if ($paymentsettings_default_name === 'ewallet') {
        //         $ewallet_members_id = $identify_type === 'user_recruitnewuser'
        //             ? session('default.customer_id')
        //             : $members_id;

        //         MEwalletPaymentDetails::insertEwalletPaymentDetails(
        //             $ewallet_members_id,
        //             $matrix_id,
        //             $format_paymenthistory_amount,
        //             $paymenthistory_trans_id
        //         );
        //     }

        //     // EPIN Payment
        //     if ($paymentsettings_default_name === 'epin') {
        //         MEpinPaymentDetails::insertEpinPaymentDetails($members_id, $payment_id);
        //     }
        // }

        return $payment_id;




    }

}

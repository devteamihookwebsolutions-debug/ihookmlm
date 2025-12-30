<?php

namespace User\App\Models\Network;

use Illuminate\Support\Facades\DB;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\Middleware\MCryptoGraphy;

use Display\Network\DCardDetails;

class MCardDetails
{
    /**
     * This public static function is used to show card details
     * @return HTML data
     */
    public static function getStripeCartDetails(){
        $user_id = session('default.customer_id');
        $where = 'members_id="' . $user_id . '"';
        $matrixmemberlinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $stripe_cardid            = $matrixmemberlinkdetails[0]['stripe_cardid'];
        $stripe_cusid             = $matrixmemberlinkdetails[0]['stripe_cusid'];
        if(count($matrixmemberlinkdetails) > 1){
            foreach($matrixmemberlinkdetails as $key => $value){
                if($value[stripe_cardid] != '' ||  $value[stripe_cusid] != ''){
                    $stripe_cardid            = $value[stripe_cardid];
                    $stripe_cusid             = $value[stripe_cusid];
                }
            }
        }

        if($stripe_cardid != '' && $stripe_cusid != ''){
            $where                   = 'WHERE paymentsettings_default_name="stripe"';
            $stripedetails           = MPaymentGatewayDetails::getPaymentGatewayDetails($where);
            $publickey               = $stripedetails['paymentsettings_accname'];
            $privatekey              = $stripedetails['paymentsettings_accnum'];
            $id                      = $stripedetails['paymentsettings_id'];
            $publickey               = MCryptoGraphy::decryptionData($publickey);
            $privatekey              = MCryptoGraphy::decryptionData($privatekey);
            if ($stripedetails['paymentsettings_mode'] == 'sandbox') {
                $paymenturl = $stripedetails['payment_testurl'];
            } else {
                $paymenturl = $stripedetails['payment_liveurl'];
            }
            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'. $stripe_cusid  .'/sources/'.$stripe_cardid);
            //curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources/'.$stripe_cardid);
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'. $stripe_cusid  .'/sources');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_USERPWD, $privatekey);
            $result = curl_exec($ch);
            $carddetails = json_decode($result);
            if($carddetails->data[0]->card){
                $carddetails = $carddetails->data[0]->card;
            }else if($carddetails->data[0]->object == 'card'){
                $carddetails = array('brand' => $carddetails->data[0]->brand,
                                    'cvc_check' => $carddetails->data[0]->cvc_check,
                                    'exp_month' => $carddetails->data[0]->exp_month,
                                    'exp_year' => $carddetails->data[0]->exp_year,
                                    'fingerprint' => $carddetails->data[0]->fingerprint,											'last4' => $carddetails->data[0]->last4,
                                    );
            }else if($carddetails->card){
                $carddetails = $carddetails->card;
            }else{
                $carddetails = $carddetails->data[0]->three_d_secure;
            }

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if($carddetails->cvc_check == 'pass'){
                $card_cvv = 'Passed';
                $cart_cvv_status = 1;
            }else{
                $card_cvv = $carddetails->cvc_check;
                $cart_cvv_status = 0;
            }
            $result = (array)$carddetails;

        }else{
            $result = array();
        }
        return DCardDetails::showAllCards($result);
    }

    /**
     * This public static function is used to show month list
     * @return HTML data
     */
    public static function showMonthList($month){
        $monthlist = '';
            for($i = 1; $i <= 12; $i++){
                if($i == $month){
                    $monthlist .= '<option selected value="'.$i.'">'.$i.'</option>';
                }else{
                    $monthlist .= '<option value="'.$i.'">'.$i.'</option>';
                }

            }
        return $monthlist;
    }

    /**
     * This public static function is used to show year list
     * @return HTML data
     */
    public static function showYearList($year){
        $yearlist = '';
            for($i = 2020; $i <= 2040; $i++){
                if($i == $year){
                    $yearlist .= '<option selected value="'.$i.'">'.$i.'</option>';
                }else{
                    $yearlist .= '<option value="'.$i.'">'.$i.'</option>';
                }

            }
        return $yearlist;
    }

    /**
     * This public static function is used to update card details
     * @return HTML data
     */
    public static function updateCardDetails(){
        $user_id = session('default.customer_id');
        $where = 'members_id="' . $user_id . '"';
        $matrixmemberlinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $stripe_cardid            = $matrixmemberlinkdetails[0]['stripe_cardid'];
        $stripe_cusid             = $matrixmemberlinkdetails[0]['stripe_cusid'];

        if(count($matrixmemberlinkdetails) > 1){

            foreach($matrixmemberlinkdetails as $key => $value){
                if($value[stripe_cardid] != '' ||  $value[stripe_cusid] != ''){
                    $stripe_cardid            = $value[stripe_cardid];
                    $stripe_cusid             = $value[stripe_cusid];
                }
            }

        }


        $where                   = 'WHERE paymentsettings_default_name="stripe"';
        $stripedetails           = MPaymentGatewayDetails::getPaymentGatewayDetails($where);
        $publickey               = $stripedetails['paymentsettings_accname'];
        $privatekey              = $stripedetails['paymentsettings_accnum'];
        $id                      = $stripedetails['paymentsettings_id'];
        $publickey               = MCryptoGraphy::decryptionData($publickey);
        $privatekey              = MCryptoGraphy::decryptionData($privatekey);
        if ($stripedetails['paymentsettings_mode'] == 'sandbox') {
            $paymenturl = $stripedetails['payment_testurl'];
        } else {
            $paymenturl = $stripedetails['payment_liveurl'];
        }
        $name = trim(request('name'));
        $card_month = explode('/', request('card_month'));
        $card_year="20".$card_month[1];
        $card_month = $card_month[0];
        $cardnumber = trim(request('cardnumber'));
        $stripe_gen_token = trim(request('stripe_gen_token'));
        $amount_cents = 1000; // Chargeble amount
        $description = "New card";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "" . $paymenturl . "customers/".$stripe_cusid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "source=" .$stripe_gen_token);
        curl_setopt($ch, CURLOPT_USERPWD, $privatekey);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $resultvalue = json_decode($result);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        if($resultvalue->error){
            session()->put('error_message', __('Invalid card details'));
            return redirect(env('FCPATH') . "/mycard");
        }else{
            session()->put('success_message',  __('Card details updated successfully'));
            return redirect(env('FCPATH') . "/mycard");
        }
    }

    public static function showActiveSubscription(){
        $user_id = session('default.customer_id');
        $where = 'members_id="' . $user_id . '"';
        $matrixmemberlinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $stripe_subid            = $matrixmemberlinkdetails[0]['stripe_subid'];

        if(count($matrixmemberlinkdetails) > 1){

            foreach($matrixmemberlinkdetails as $key => $value){
                if($value['stripe_subid'] != ''){
                    $stripe_subid            = $value['stripe_subid'];
                }
            }

        }

        if(!empty($stripe_subid)){
            $sql = "SELECT * FROM `" . env('IHOOK_PREFIX') . "paymenthistory_table` ap, " . env('IHOOK_PREFIX') . "paymentsettings_table aps
            WHERE ap.paymenthistory_mode=aps.paymentsettings_id
            AND paymenthistory_member_id='" . $user_id . "'
            ORDER BY ap.paymenthistory_id DESC LIMIT 1";
            $records = DB::select($sql)[0];
            if($records['paymentsettings_default_name'] == 'stripe'){
                $sql = "SELECT *    FROM  " . env('IHOOK_PREFIX') . "package_table
                WHERE package_id='". $records['paymenthistory_plan_id'] ."'";
                $recordssss = DB::select($sql);
                return DCardDetails::showActiveSubscription($recordssss);
            }
        }
    }

    public static function cancelSubScription(){
        $packageid   = request()->query('sub1');
        $user_id     = session('default.customer_id');
        $where       = 'members_id="' . $user_id . '"';
        $matrixmemberlinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $stripe_subid            = $matrixmemberlinkdetails[0]['stripe_subid'];
        $matrix_id= $matrixmemberlinkdetails[0]['matrix_id'];

        if(count($matrixmemberlinkdetails) > 1){
            foreach($matrixmemberlinkdetails as $key => $value){
                if($value['stripe_subid'] != ''){
                    $stripe_subid            = $value['stripe_subid'];
                    $matrix_id				 = $value['matrix_id'];
                }
            }
        }

        $where                   = 'WHERE paymentsettings_default_name="stripe"';
        $stripedetails           = MPaymentGatewayDetails::getPaymentGatewayDetails($where);
        $publickey               = $stripedetails['paymentsettings_accname'];
        $privatekey              = $stripedetails['paymentsettings_accnum'];
        $id                      = $stripedetails['paymentsettings_id'];
        $publickey               = MCryptoGraphy::decryptionData($publickey);
        $privatekey              = MCryptoGraphy::decryptionData($privatekey);
        if ($stripedetails['paymentsettings_mode'] == 'sandbox') {
            $paymenturl = $stripedetails['payment_testurl'];
        } else {
            $paymenturl = $stripedetails['payment_liveurl'];
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "" . $paymenturl . "subscriptions/" . $stripe_subid . "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_USERPWD,$privatekey);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        DB::update("UPDATE " . env('IHOOK_PREFIX') . "matrix_members_link_table
        SET members_subscription_expirydate= NOW(), members_subscription_status='2',members_account_status='2',
        stripe_subid='' WHERE members_id='" . $user_id . "' AND matrix_id='".$matrix_id."'");
        session()->put('success_message', __('Subscription Cancelled Successfully'));
        return redirect(env('FCPATH') . '/mycard');
    }

    public static function deleteCardDetails()
    {
        // Original code had no body; preserved as empty
    }
}

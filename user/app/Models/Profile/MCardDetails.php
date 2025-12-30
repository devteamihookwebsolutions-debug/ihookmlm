<?php
/**
 * This class contains public static functions related to network page
 *
 * @package         MCardDetails
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?>
<?php
namespace Model\Profile;
use Query\Bin_Query;
use Model\Middleware\MMatrixMemberLink;
use Model\Middleware\MPaymentGatewayDetails;
use Model\Middleware\MCryptoGraphy;

class MCardDetails {
  
	
	public static function updateCardDetails(){


		$card_month = explode('/', $_POST['card_month']);
        $user_id = $_SESSION['default']['customer_id'];
        $exp_year='20'.trim($card_month[1]);
        $exp_month=trim($card_month[0]);
		$where = 'members_id="' . $user_id . '"';
        $matrixmemberlinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $stripe_cardid            = $matrixmemberlinkdetails[0]['stripe_cardid'];
       	$stripe_cusid             = $matrixmemberlinkdetails[0]['stripe_cusid'];
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
		$name = trim($_POST['name']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources/'.$stripe_cardid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "card[exp_month]=".$exp_month."&card[exp_year]=".$exp_year."&owner[name]=".$name."");
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
            $_SESSION['error_message'] = __('Invalid card details');
            header("Location:" . $_ENV['FCPATH'] . "/myprofile");
            exit();
        }else{
            $_SESSION['success_message'] =  __('Card details updated successfully');
            header("Location:" . $_ENV['FCPATH'] . "/myprofile");exit();
        }
	}
	public static function getStripeCartDetails(){
		$user_id = $_SESSION['default']['customer_id'];
		$where = 'members_id="' . $user_id . '"';
        $matrixmemberlinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
		$stripe_cardid            = $matrixmemberlinkdetails[0]['stripe_cardid'];
		$stripe_cusid             = $matrixmemberlinkdetails[0]['stripe_cusid'];
		if(count($matrixmemberlinkdetails) > 0){
			foreach($matrixmemberlinkdetails as $key => $value){
				if($value['stripe_cusid'] != ''){
					$stripe_cardid    = $value['stripe_cardid'] ;
					$stripe_cusid    = $value['stripe_cusid'] ;
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
		//echo "<pre>";print_r($result);exit;
		return $result;
	}
	
	
    
}
?>
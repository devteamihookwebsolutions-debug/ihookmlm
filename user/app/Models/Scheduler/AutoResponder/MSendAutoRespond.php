<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MSendAutoRespond
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2017 - 2020, Sunsofty.
 * @version         Version 7.4
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Model\Scheduler\AutoResponder;
use Query\Bin_Query;

use Model\Middleware\MSendMail;
use Model\Middleware\MSendSms;
use Model\Middleware\MSendPush;
use Model\Middleware\MAmazonCloudFront;
use Model\Middleware\MSiteDetails;
use Model\Middleware\MCryptoGraphy;
use Model\Middleware\MMembersDetails;
class MSendAutoRespond {
    /**
     * This public static function is used to get the bonus list.
     * @return html data
    */
    public static function sendAutoRespondEmail() {

        $query = new Bin_Query();
		$sql1  = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "autoresponder as a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "autorespond_delay as b  ON a.autoresponder_delay = b.delay_id LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "autorespond_frequent as c ON c.frequent_id = a.autoresponder_frequent LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "autorespond_triggers as d ON d.trigger_id = a.autoresponder_trigger  WHERE a.autoresponder_delay!='1' AND (a.autoresponder_cron_date = '".date('Y-m-d')."' OR a.autoresponder_frequency_date = '".date('Y-m-d')."')" ;
		$obj1  = new Bin_Query;
		$obj1->executeQuery($sql1);
		$records = $obj1->records;
		foreach($records  as $key => $value){


			$action = array(1=>'email',2=>'sms',3=>'push_notification',4=>'webhook_push');
			$action_via = $action[$value['autoresponder_action']];
			$delay = $value['delay_name'];

			if($value['autoresponder_custom_delay'] != '0' && $value['delay_id'] == '4'){
                $autoresponder_cron_date =  date('Y-m-d',strtotime("+".$value['autoresponder_custom_delay']." days"));
                $mail_date = ' delay of '.$value['autoresponder_custom_delay'].' days';
                $delay_time =  date('Y-m-d H:i:s',strtotime("-".$value['autoresponder_custom_delay']." days"));
            }else if(strtotime($value['autoresponder_custom_date']) > 0  && $value['delay_id'] == '5'){
                $delay_time = $value['autoresponder_custom_date'];
                $mail_date = $value['delay_name'] .' - '. date('d F Y', strtotime($value['autoresponder_custom_date']));
                $autoresponder_cron_date = $value['autoresponder_custom_date'];

            }else if($value['delay_id'] == '2'){
                $autoresponder_cron_date =  date('Y-m-d',strtotime("+1 days"));
                $mail_date = ' delay of 1 days';
                $delay_time = date('Y-m-d H:i:s',strtotime("-1 days"));
            }else if($value['delay_id'] == '3'){
                $autoresponder_cron_date =  date('Y-m-d',strtotime("+7 days"));
                $mail_date =' delay of 7 days';
                $delay_time = date('Y-m-d H:i:s',strtotime("-7 days"));
            }

            if(date('Y-m-d') == $value['autoresponder_cron_date']){
            	$autoresponder_cron_date = $autoresponder_cron_date;
            }else{
            	$autoresponder_cron_date = $value['autoresponder_cron_date'];
            }

            if(date('Y-m-d') == $value['autoresponder_frequency_date']){
            	if($value['autoresponder_frequency_times'] < $value['autoresponder_frequency_sentcount']){
            			return false;
					}else{
						$autoresponder_frequency_sentcount = $value['autoresponder_frequency_sentcount'] + 1;
					}
	            if($value['autoresponder_frequent'] == '2'){
	                $frequent_date =  date('Y-m-d',strtotime("+1 days"));
	            }else if($value['autoresponder_frequent'] == '3'){
	                $frequent_date =  date('Y-m-d',strtotime("+7 days"));
	            }else {
	                $frequent_date = '';
	            }
	        }else{
	        	$frequent_date = $value['autoresponder_frequency_date'];
	        }

             $action = $value['trigger_default_name'];

            if($action == 'register' || $action == 'downline_register' || $action == 'spillover_register'){


            	if(strtotime($value['autoresponder_custom_date']) > 0  && $value['delay_id'] == '5'){
            		$where_condition = " members_doj like  '%".$delay_time."%'";
            	}else{
            		$where_condition = " members_doj BETWEEN  '".date('Y-m-d H:i:s' , strtotime($delay_time))."' AND  '".date('Y-m-d H:i:s' , strtotime($autoresponder_cron_date))."' ";
            	}

            	$sql1  = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "paymenthistory_table as b ON b.paymenthistory_member_id=a.members_id LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as c ON c.members_id=a.members_id INNER JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_table as d ON d.matrix_id = c.matrix_id  WHERE  ".$where_condition." AND b.paymenthistory_status ='paid' group by b.paymenthistory_member_id ORDER BY b.paymenthistory_id DESC limit 100";
            }else if($action == 'site_purchase' || $action == 'direct_purchase' || $action == 'spillover_purchase'){

            	if(strtotime($value['autoresponder_custom_date']) > 0  && $value['delay_id'] == '5'){
            		$where_condition = " members_doj like  '%".$delay_time."%'";
            	}else{
            	$where_condition = " b.paymenthistory_date BETWEEN  '".$delay_time."' AND  '".$autoresponder_cron_date."' ";
            }
            	$sql1  = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "paymenthistory_table as b ON b.paymenthistory_member_id=a.members_id LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table as c ON c.members_id=a.members_id INNER JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_table as d ON d.matrix_id = c.matrix_id   WHERE  ".$where_condition." AND b.paymenthistory_status ='paid' group by b.paymenthistory_member_id ORDER BY b.paymenthistory_id DESC limit 100";
            }else if($action == 'shop_purchase'){
            	if(strtotime($value['autoresponder_custom_date']) > 0  && $value['delay_id'] == '5'){
            		$where_condition = " AND a.post_date like  '%".$delay_time."%'";
            	}else{
            	$where_condition = " AND a.post_date BETWEEN  '".$delay_time."' AND  '".$autoresponder_cron_date."' AND a.post_status='wc-completed' ";
            }

            	$sql1 ="SELECT * FROM `" . $_ENV['STORE_PREFIX'] . "posts` AS a
				        LEFT JOIN   `" . $_ENV['STORE_PREFIX'] . "postmeta` AS b ON  b.meta_key='_customer_user' AND b.post_id=a.ID
				        LEFT JOIN `" . $_ENV['STORE_PREFIX'] . "postmeta` AS c ON c.meta_key='_order_total' AND c.post_id=b.post_id
				        LEFT JOIN `" . $_ENV['IHOOK_PREFIX'] . "members_table` AS d ON d.members_shop_id=b.meta_value AND c.post_id=b.post_id WHERE a.post_type='shop_order' ".$where_condition ."GROUP BY a.ID limit 100";
            }
			$obj1  = new Bin_Query;
			$obj1->executeQuery($sql1);
			$records_array   = $obj1->records;
			$query_admin = new Bin_Query();
			$sqladmin    = "SELECT * FROM `" . $_ENV['IHOOK_PREFIX'] . "admin_table` WHERE admin_status='enable' AND admin_type='1'";
			$query_admin->executeQuery($sqladmin);

			$admin_name  = $query_admin->records[0]	['admin_username'];
			$admin_email = $query_admin->records[0]['admin_email'];
			$admin_phoneno = $query_admin->records[0]['admin_phone'];
			//$push_token = $query_admin->records[0]['push_token'];
			$push_token = 'gOjmKFBMIxah_iO8CD0ZLYfBwcv1RkFyVEjPBGV-V6Z3XlaDiHRmm-SuFQd9OqwGmf';



		if($value['autoresponder_content'] == 1){

			$sql   = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "newsletter_buildertemplate_table where members_id = '0' and category_templates_status='1' and category_templates_id = '".$value['autoresponder_notification']."'";
			$query = new Bin_Query();
			$query->executeQuery($sql);
			$result_newsletter = $query->records[0];
			$records_mail['mail_name'] = $result_newsletter['category_templates_name'];
			$records_mail['mail_subject'] = $result_newsletter['category_templates_name'];
			$records_mail['mail_from'] = $admin_email;
			$records_mail['mail_from_name'] = $admin_name;

			$pagepath = $result_newsletter['category_templates_file_path'];
			$pagepath=MAmazonCloudFront::getCloudFrontUrl($pagepath);
			$funnnelpagecontent = file_get_contents($pagepath);
			$message = $funnnelpagecontent;
		}else if($value['autoresponder_content'] == 2 && $value['autoresponder_action'] == 1){

			$sqlMail = "SELECT * FROM `" . $_ENV['IHOOK_PREFIX'] . "mailtemplates_table` WHERE mail_id = '".$value['autoresponder_notification']."'
					AND mail_status='1' AND mail_lang='1'";
			$query->executeQuery($sqlMail);
			$records_mail = $query->records[0];
			$message         = $records_mail['mail_content'];

		}else if($value['autoresponder_content'] == 3){
			$records_mail['mail_name'] = $value['autoresponder_name'];
			$records_mail['mail_subject'] = $value['autoresponder_name'];
			$records_mail['mail_from'] = $admin_email;
			$records_mail['mail_from_name'] = $admin_name;
			$message = $value['autoresponder_customcontent'];
		}else if($value['autoresponder_content'] == 2 && $value['autoresponder_action'] == 2){
			$where                    = "WHERE sitesettings_name ='site_name' ";
	        $sitesettings             = MSiteDetails::getSiteSettingsDetails($where);
	        $site_name = $sitesettings[0]['sitesettings_value'];
			$sql1  = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "sms_notificaton
		                WHERE sms_default_name='trigger_notification' AND status='1'";
            $obj1  = new Bin_Query;
            $obj1->executeQuery($sql1);
            $records = $obj1->records[0];
			$body     = $records['notification_message'];
			$name                 = str_replace('[name]', $admin_name, $body);
			$autoresponder_trigger             = str_replace('[autoresponder_trigger]', $value['autoresponder_name'], $name);
			$trigger_delay           = str_replace('[trigger_delay]', $mail_date, $autoresponder_trigger);
			$message             = str_replace('[site_name]', $site_name, $trigger_delay);

		}else if($value['autoresponder_content'] == 2 && $value['autoresponder_action'] == 3){
			$where                    = "WHERE sitesettings_name ='site_name' ";
	        $sitesettings             = MSiteDetails::getSiteSettingsDetails($where);
	        $site_name = $sitesettings[0]['sitesettings_value'];
			$sql1  = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "push_notificaton
		                WHERE push_default_name='trigger_notification' AND status='1'";
            $obj1  = new Bin_Query;
            $obj1->executeQuery($sql1);
            $records = $obj1->records[0];
			$body     = $records['notification_message'];
			$title = $records['notification_name'];
			$name                 = str_replace('[name]', $admin_name, $body);
			$autoresponder_trigger             = str_replace('[autoresponder_trigger]', $value['autoresponder_name'], $name);
			$trigger_delay           = str_replace('[trigger_delay]', $mail_date, $autoresponder_trigger);
			$message             = str_replace('[site_name]', $site_name, $trigger_delay);

		}


					if($action_via == 'email'){
						$site_url                  = $_ENV['FCPATH'];
						foreach($records_array as $mkey => $mvalue){

							$members_email = $mvalue['members_email'];
							if($value['autoresponder_notification_to'] == 1){
								$email = $members_email;
							}else if($value['autoresponder_notification_to'] == 2){

								if($action == 'spillover_register' || $action == 'spillover_purchase'){
				                        $id = $mvalue['spillover_id'];
				                    }else{
				                        $id = $mvalue['direct_id'];
				                    }
								$sponsor_details=MMembersDetails::getUserDetails($id);
						        $sponsorname=$sponsor_details['members_username'];
						        $email=$sponsor_details['members_email'];
							}else{
								$email=$admin_email;
							}

							$members_username =$mvalue['members_username'];
							$members_phone = $mvalue['members_phone'];

							$members_password = $mvalue['members_password'];
							//$pass = MCryptoGraphy::decryptionData($members_password);

							$paymenthistory_amount = $mvalue['paymenthistory_amount'];
							$planprice = $site_currency . $paymenthistory_amount;
							$name      = str_replace('[name]', $members_username, $message);
							$password      = str_replace('[pass]', $pass, $name);
							$url = str_replace('[url]', $site_url, $password);
							$username      = str_replace('[username]', $members_username, $url);
							$mail      = str_replace('[members_email]', $mvalue['members_email'], $username);
							$username  = str_replace('[planame]', $mvalue['matrix_name'], $mail);
							$planprice   = str_replace('[planprice]', $site_currency.$paymenthistory_amount, $username);
							$address  = str_replace('[address]', $mvalue['members_address'], $planprice);
							$city  = str_replace('[city]', $mvalue['members_city'], $address);
							$state  = str_replace('[state]', $mvalue['members_state'], $city);
							$country  = str_replace('[country]', $mvalue['members_country'], $state);
							$zipcode  = str_replace('[zipcode]', $mvalue['members_zip'], $country);
							$totalprice  = str_replace('[totalprice]', $site_currency.$paymenthistory_amount, $zipcode);
							$subtotal  = str_replace('[subtotal]', $site_currency.$paymenthistory_amount, $totalprice);
							$tax  = str_replace('[tax]', '', $subtotal);
							$members_ip_address = str_replace('[ipaddress]', $mvalue['members_ip_address'], $subtotal);
							$packagename = str_replace('[packagename]', $mvalue['package_name'], $members_ip_address);
							$packageprice = str_replace('[packageprice]', $mvalue['package_price'], $packagename);
							$packageduration = str_replace('[packageduration]', $mvalue['package_duration'], $packageprice);
							$packagepv = str_replace('[packagepv]', $mvalue['package_pv'], $packageduration);
							$packagecommision = str_replace('[packagecommision]', $mvalue['package_direct_commission'].$mvalue['package_direct_commission_method'], $packagepv);
							$packageprice = str_replace('[packageprice]',$site_currency.$mvalue['package_price'], $packagecommision);
							$message  = str_replace('[coupon]', '', $packageprice);


							MSendMail::sendMail($records_mail, $email, $message, '', '', '');
						}

					}else if($action_via =='sms'){

						MSendSms::sendSms($admin_phoneno, $message);

					}else if($action_via =='push_notification'){

						 //MSendPush::sendPush($push_token,$message,$title);

					}
			$sql_matrix = "UPDATE `" . $_ENV['IHOOK_PREFIX'] . "autoresponder` SET
             `autoresponder_cron_date` = '".$autoresponder_cron_date."',
             `autoresponder_frequency_date` = '".$frequent_date."',
             `autoresponder_frequency_sentcount` = '".$autoresponder_frequency_sentcount."'
             WHERE autoresponder_id ='".$value['autoresponder_id']."'";
            $obj_matrix = new Bin_Query();
            if($obj_matrix->updateQuery($sql_matrix)){
                 return true;
            }else{
                 echo "cron error";exit;
            }

		}
		return true;
    }
}
?>

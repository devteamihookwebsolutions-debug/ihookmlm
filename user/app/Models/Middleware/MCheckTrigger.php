<?php
/**
 * This class contains public static functions related to Banner .
 *
 * @package         MCheckTrigger
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version        Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace User\App\Models\Middleware;
class MCheckTrigger {

    public static function getTriggerDetails($key,$action,$contact_info) {

        $query       = new Bin_Query();
          $sqlMail  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "autoresponder as a LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "autorespond_delay as b  ON a.autoresponder_delay = b.delay_id LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "autorespond_frequent as c ON c.frequent_id = a.autoresponder_frequent LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "autorespond_triggers as d ON d.trigger_id = a.autoresponder_trigger  WHERE  a.autoresponder_action='".$action."' AND d.trigger_default_name ='".$key."' AND a.autoresponder_delay = '1'";

        $query->executeQuery($sqlMail);
        $records = $query->records[0];

        if(count((array)$records)>0){
        $action_by = array(1=>'email',2=>'sms',3=>'push_notification',4=>'webhook_push');
            $action_via = $action_by[$records['autoresponder_action']];
            $delay = $records['delay_name'];

            if($records['autoresponder_custom_delay'] != '0' && $records['delay_id'] == '4'){
                $autoresponder_cron_date =  date('Y-m-d',strtotime("+".$records['autoresponder_custom_delay']." days"));
                $mail_date = ' delay of '.$records['autoresponder_custom_delay'].' days';
                $delay_time =  date('Y-m-d H:i:s',strtotime("-".$records['autoresponder_custom_delay']." days"));
            }else if(strtotime($records['autoresponder_custom_date']) > 0  && $records['delay_id'] == '5'){
                $autoresponder_cron_date =  $records['autoresponder_custom_date'];
                $mail_date = $records['delay_name'] .' - '. date('d F Y', strtotime($records['autoresponder_custom_date']));
                $delay_time =  $records['autoresponder_custom_date'];
            }else if($records['delay_id'] == '2'){
                $autoresponder_cron_date =  date('Y-m-d',strtotime("+1 days"));
                $mail_date = ' delay of 1 days';
                $delay_time = date('Y-m-d H:i:s',strtotime("-1 days"));
            }else if($records['delay_id'] == '3'){
                $autoresponder_cron_date =  date('Y-m-d',strtotime("+7 days"));
                $mail_date =' delay of 7 days';
                $delay_tmie = date('Y-m-d H:i:s',strtotime("-7 days"));
            }

            if(date('Y-m-d') == $records['autoresponder_cron_date']){
                $autoresponder_cron_date = $autoresponder_cron_date;
            }else{
                $autoresponder_cron_date = $records['autoresponder_cron_date'];
            }

            if(date('Y-m-d') == $records['autoresponder_frequency_date']){
                if($records['autoresponder_frequency_times'] < $records['autoresponder_frequency_sentcount']){
                        return false;
                    }else{
                        $autoresponder_frequency_sentcount = $records['autoresponder_frequency_sentcount'] + 1;
                    }
                if($records['autoresponder_frequent'] == '2'){
                    $frequent_date =  date('Y-m-d',strtotime("+1 days"));
                }else if($records['autoresponder_frequent'] == '3'){
                    $frequent_date =  date('Y-m-d',strtotime("+7 days"));
                }else {
                    $frequent_date = '';
                }
            }else{
                $frequent_date = $value['autoresponder_frequency_date'];
            }
            // $obj1  = new Bin_Query;
            // $obj1->executeQuery($sql1);
            // $records_array   = $obj1->records;
            $query_admin = new Bin_Query();
             $sqladmin    = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "admin_table` WHERE admin_status='enable' AND admin_type='1'";
            $query_admin->executeQuery($sqladmin);
            $admin_name  = $query_admin->records[0] ['admin_username'];
            $admin_email = $query_admin->records[0]['admin_email'];
            $admin_phoneno = $query_admin->records[0]['admin_phone'];
            $push_token = $query_admin->records[0]['push_token'];

             $where = " where members_email ='".$contact_info."'";
            $details=MMembersDetails::getWhereMemberDetails($where);
            $members_details =  $details[0];

            $trigger_default_name = $records['trigger_default_name'];

            if($trigger_default_name == 'register' || $trigger_default_name == 'downline_register' || $trigger_default_name == 'spillover_register'){
                $where_condition = "a.members_id = '".$members_details['members_id']."' ";
                 $sql1  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "paymenthistory_table as b ON b.paymenthistory_member_id=a.members_id LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table as c ON c.members_id=a.members_id INNER JOIN " . $_ENV['PROMLM_PREFIX'] . "matrix_table as d ON d.matrix_id = c.matrix_id   WHERE  ".$where_condition." AND b.paymenthistory_status = 'paid' group by b.paymenthistory_member_id ORDER BY b.paymenthistory_id DESC";
            }else if($trigger_default_name == 'site_purchase' || $trigger_default_name == 'direct_purchase' || $trigger_default_name == 'spillover_purchase'){
                 $where_condition = " a.members_id = '".$members_details['members_id']."' ";
                $sql1  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "members_table as a LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "paymenthistory_table as b ON b.paymenthistory_member_id=a.members_id LEFT JOIN " . $_ENV['PROMLM_PREFIX'] . "matrix_members_link_table as c ON c.members_id=a.members_id INNER JOIN " . $_ENV['PROMLM_PREFIX'] . "matrix_table as d ON d.matrix_id = c.matrix_id    WHERE  ".$where_condition." AND b.paymenthistory_status = 'paid' group by b.paymenthistory_member_id ORDER BY b.paymenthistory_id DESC";
            }else if($trigger_default_name == 'shop_purchase' ){
                $where_condition = "  AND d.members_shop_id = '".$members_details['members_shop_id']."' ";
                $sql1 ="SELECT * FROM `" . $_ENV['STORE_PREFIX'] . "posts` AS a
                        LEFT JOIN   `" . $_ENV['STORE_PREFIX'] . "postmeta` AS b ON  b.meta_key='_customer_user' AND b.post_id=a.ID
                        LEFT JOIN `" . $_ENV['STORE_PREFIX'] . "postmeta` AS c ON c.meta_key='_order_total' AND c.post_id=b.post_id
                        LEFT JOIN `" . $_ENV['PROMLM_PREFIX'] . "members_table` AS d ON d.members_shop_id=b.meta_value AND c.post_id=b.post_id WHERE a.post_type='shop_order' ".$where_condition ."GROUP BY a.ID";
            }
            $obj1  = new Bin_Query;
            $obj1->executeQuery($sql1);
            $records_array   = $obj1->records[0];
            if(count((array)$records_array) > 0){
                if($records['autoresponder_notification_to'] == 1){
                    $contact_info = $contact_info;
                }else if($records['autoresponder_notification_to'] == 2){

                    if($trigger_default_name == 'spillover_register' || $trigger_default_name == 'spillover_purchase'){
                        $id = $records_array['spillover_id'];
                    }else{
                        $id = $records_array['direct_id'];
                    }

                    $sponsor_details=MMembersDetails::getUserDetails($id);
                    $contact_info = $sponsor_details['members_email'];
                }else{
                    $contact_info = $admin_email;
                }

            if($records['autoresponder_content'] == 1){

                 $sql   = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "newsletter_buildertemplate_table where members_id = '0' and category_templates_status='1' and category_templates_id = '".$records['autoresponder_notification']."'";
                $query = new Bin_Query();
                $query->executeQuery($sql);
                $result_newsletter = $query->records[0];
                $records_mail['mail_name'] = $result_newsletter['category_templates_name'];
                $records_mail['mail_subject'] = $result_newsletter['category_templates_name'];
                $records_mail['mail_from'] = $admin_email;
                $records_mail['mail_from_name'] = $admin_name;

                $pagepath = $result_newsletter['category_templates_file_path'];

                if (!empty($pagepath)) {
                $pagepath=MAmazonCloudFront::getCloudFrontUrl($pagepath);
                $funnnelpagecontent = file_get_contents($pagepath);
                $message = $funnnelpagecontent;
                }
            }else if($records['autoresponder_content'] == 2 && $records['autoresponder_action'] == 1){
                   $sqlMail = "SELECT * FROM `" . $_ENV['PROMLM_PREFIX'] . "mailtemplates_table` WHERE mail_id = '".$records['autoresponder_notification']."'
                        AND mail_status='1' AND mail_lang='1'";
                $query  = new Bin_Query;
                $query->executeQuery($sqlMail);
                $records_mail = $query->records[0];
                $message         = $records_mail['mail_content'];
                 $members_password = $mvalue['members_password'];
                //$pass = MCryptoGraphy::decryptionData($members_password);

                $paymenthistory_amount = $mvalue['paymenthistory_amount'];
                $planprice = $site_currency . $paymenthistory_amount;
                $name      = str_replace('[name]', $members_username, $message);
                $password      = str_replace('[pass]', '', $name);
                $url = str_replace('[url]', $site_url, $password);
                $username      = str_replace('[username]', $mvalue['members_username'], $url);
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
                $message  = str_replace('[coupon]', '', $members_ip_address);

            }else if($records['autoresponder_content'] == 3){
                $records_mail['mail_name'] = $records['autoresponder_name'];
                $records_mail['mail_subject'] = $records['autoresponder_name'];
                $records_mail['mail_from'] = $admin_email;
                $records_mail['mail_from_name'] = $admin_name;
                $message = $records['autoresponder_customcontent'];
            }else if($records['autoresponder_content'] == 2 && $records['autoresponder_action'] == 2){
                $where                    = "WHERE sitesettings_name ='site_name' ";
                $sitesettings             = MSiteDetails::getSiteSettingsDetails($where);
                $site_name = $sitesettings[0]['sitesettings_value'];
                $sql1  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "sms_notificaton
                            WHERE sms_default_name='trigger_notification' AND status='1'";
                $obj1  = new Bin_Query;
                $obj1->executeQuery($sql1);
                $records = $obj1->records[0];
                $body     = $records['notification_message'];
                $name                 = str_replace('[name]', $admin_name, $body);
                $autoresponder_trigger             = str_replace('[autoresponder_trigger]', $records['autoresponder_name'], $name);
                $trigger_delay           = str_replace('[trigger_delay]', $mail_date, $autoresponder_trigger);
                $message             = str_replace('[site_name]', $site_name, $trigger_delay);

            }else if($records['autoresponder_content'] == 2 && $records['autoresponder_action'] == 3){
                $where                    = "WHERE sitesettings_name ='site_name' ";
                $sitesettings             = MSiteDetails::getSiteSettingsDetails($where);
                $site_name = $sitesettings[0]['sitesettings_value'];
                $sql1  = "SELECT * FROM " . $_ENV['PROMLM_PREFIX'] . "push_notificaton
                            WHERE push_default_name='trigger_notification' AND status='1'";
                $obj1  = new Bin_Query;
                $obj1->executeQuery($sql1);
                $records = $obj1->records[0];
                $body     = $records['notification_message'];
                $title = $records['notification_name'];
                $name                 = str_replace('[name]', $admin_name, $body);
                $autoresponder_trigger             = str_replace('[autoresponder_trigger]', $records['autoresponder_name'], $name);
                $trigger_delay           = str_replace('[trigger_delay]', $mail_date, $autoresponder_trigger);
                $message             = str_replace('[site_name]', $site_name, $trigger_delay);

            }

            if($action == 1 ){

                MSendMail::sendMail($records_mail, $contact_info, $message, '', '', '');
                return true;
            }else if($action == 2){

                MSendSms::sendSms($contact_info, $message);

            }else if($action_via =='push_notification'){

                 MSendPush::sendPush($contact_info,$message,$title);

            }
        }else{
            return false;
        }

    }else{
            return false;
        }


    }
}
?>

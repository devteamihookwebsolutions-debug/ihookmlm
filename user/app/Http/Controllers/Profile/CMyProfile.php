<?php
/**
 * This class contains public static functions related to my account
 *
 * @package         CMyProfile
 * @category        Controller
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?>

<?php
use Controller\BaseController;

class Controller_Profile_CMyProfile extends BaseController
{
    /**
    * This public static function is used  to constructor of this class
    *
    */
    public function __construct()
    {
        $output   = array();
        if (empty($_SESSION['default']['customer_id'])) {
            header("Location:" . $_ENV['FCPATH'] . "/login");
            exit();
        }
        parent::getSiteDetails();
    }
    /**
     * This public static function is used  to showMyProfile
     * @return HTML data
     */
    public static function showMyProfile()
    {

        try {

            $output = array();

            $user_id                  = $_SESSION['default']['customer_id'];
            $today                    = date('Y-m-d');
            $output['member_details'] = Model\Profile\MMyProfile::getMembersDetail();
            $output['mysite'] = Model\Profile\MMySite::getMembersSiteDetail();
            $output['socialmedia'] = Model\Profile\MSocialMedia::getMembersSocialDetail();
            $output['members_tax_file'] =  Model\Middleware\MAmazonCloudFront::getCloudFrontUrl($output['member_details']['members_tax_form']);
            $output['members_w8_form'] =  Model\Middleware\MAmazonCloudFront::getCloudFrontUrl($output['member_details']['members_w8_form']);


            $output['country']        = Model\Middleware\MCountryDetails::getCountryList($output['member_details']['members_country']);


            if ($output['member_details']['members_id_proof'] == '') {
                $output['members_id_proof'] = '-';
            } else {
                $members_id_prooflink =  Model\Middleware\MAmazonCloudFront::getCloudFrontUrl($output['member_details']['members_id_proof']);
                $output['members_id_proof'] = '<a href="' . $members_id_prooflink . '" target="_blank" rel="noopener" >' . __('Id Proof') . '</a>';
            }
            if ($output['member_details']['members_pan_tax_document'] == '') {
                $output['members_pan_tax_document'] = '-';
            } else {
                $members_pan_tax_documentlink =  Model\Middleware\MAmazonCloudFront::getCloudFrontUrl($output['member_details']['members_pan_tax_document']);
                $output['members_pan_tax_document'] = '<a href="' .$members_pan_tax_documentlink. '" target="_blank" rel="noopener" >' . __('Pan tax document') . ' </a>';
            }
            $output['totalorders']    = Model\Profile\MMyProfile::getTotalOrder($user_id);
            $cwallet  = Model\Middleware\MWalletBalance::getWalletCurrentBalance($user_id, 1);
            $ewallet  = Model\Middleware\MWalletBalance::getWalletCurrentBalance($user_id, 2);
            $output['todayearnings'] = Model\Middleware\MFormatNumber::formatingNumberCurrency($cwallet + $ewallet) * $_SESSION['matrix']['currency_conversion_rate'];
            $output['userlog']  = Model\Profile\MMyProfile::showActivityLogs();
            $output['new_notification'] = Model\Profile\MMyProfile::getUserNewNotification();
            $output['directsales'] = Model\Profile\MMyProfile::getDownlineSales();
            $output['language'] = Model\Profile\MMyProfile::getLanguage($output['member_details']['members_lang']);
            //start:form elements
            $attr_where = "ORDER BY id ASC";
            $output['regform']                          = Model\Middleware\MFormAttributes::getFormAttributes($attr_where);
            //end:form elements
            $output['communication'] = json_decode($output['member_details']['members_communication']);
            $output['notification'] = count((array)$Err->messages) ? $Err->values : Model\Profile\MMyProfile::getNotification($Err);

            /* $stripedetails 			    = Model\Profile\MCardDetails::getStripeCartDetails();

             $output['month']         				= $stripedetails['month'];
             $output['year']         				= $stripedetails['year'];
             $output['parseyear']         				= substr($output['year'], -2);;

             $output['stripedetails']    = $stripedetails;

             $where                  = 'WHERE paymentsettings_default_name="stripe"';
             $paymentgatewaydetails  = Model\Middleware\MPaymentGatewayDetails::getPaymentGatewayDetails($where);
             if ($paymentgatewaydetails['paymentsettings_status'] == 'Active') {
                 $where						= "members_id = ". $_SESSION['default']['customer_id'];
                 $striptsubid                = Model\Middleware\MMatrixMemberLink::getPartMatrixLinkDetails('stripe_subid', $where);
                 $output['striptsubid']		= $striptsubid[0]['stripe_subid'];
             }*/

            if ($_POST['password'] == 'profile' || $_GET['action'] == 'avatar') {
                $output['avatar']                  = '1';
            } else {
                $output['avatar']                  = '0';
            }
            //Rey
            $output['qrCodeUrl'] = Model\Middleware\MTwoFactor::getqr1();
            $output['qrCodeUrl1'] = Model\Middleware\MTwoFactor::getqr2();
            $output['2fa'] = Model\Middleware\MTwoFactor::get2faDetail();
            //Rey

            Bin_Template::createBlade('profile/myprofile', $output);
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
            unset($_SESSION['error_message']);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function saveMemberDetails()
    {
        try {
            Model\Profile\MMyProfile::updateMyProfile($_POST);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();

            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }
    public static function update2fa()
    {
        try {
            Model\Profile\MMyProfile::update2fa();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function saveContactDetails()
    {
        try {
            Model\Profile\MMyProfile::updateContactProfile($_POST);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function savePasswordDetails()
    {
        try {
            Model\Profile\MMyProfile::updatePasswordDetail($_POST);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function saveAvatarDetails()
    {
        try {
            Model\Profile\MMyProfile::updateAvatarDetails($_FILES, $_POST);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function saveTransPassDetail()
    {
        try {
            Model\Profile\MMyProfile::updateTransPassDetail($_POST);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function getAvatarGallery()
    {
        try {
            echo Model\Profile\MAvatarGallery::getAvatarGallery();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    /**
    * This public static function is used  to setAvatarGallery
    */
    public static function setAvatarGallery()
    {
        try {
            if ($_GET['sub1'] == 'admin') {
                $avatar_gallery_id = $_GET['sub3'];
                $members_id        = $_GET['sub2'];
                Model\Profile\MAvatarGallery::setAvatarGallery($avatar_gallery_id, $members_id);
                header("Location:" . $_SESSION['asseturl'] . "/" . $_ENV['CURRENT_PATH'] . "/usermanager/edituser/" . $_GET['sub2']);
                exit();
            } else {
                $avatar_gallery_id = $_GET['sub1'];
                $members_id        = $_SESSION['default']['customer_id'];
                Model\Profile\MAvatarGallery::setAvatarGallery($avatar_gallery_id, $members_id);
                header("Location:" . $_ENV['FCPATH'] . "/myprofile");
                exit();
            }
        } catch (Exception $e) {

            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/myprofile");
            exit();
        }
    }

    public static function checkCurrentPassword()
    {
        try {
            Model\Profile\MMyProfile::checkCurrentPassword();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function checkTransactionPassword()
    {
        try {
            Model\Profile\MMyProfile::checkTransactionPassword();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/myprofile");
            exit();
        }
    }

    public static function saveAccInfo()
    {
        try {
            Model\Profile\MMyProfile::updateAccInfo($_POST);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/myprofile");
            exit();
        }
    }
    public static function getTimeZone()
    {
        try {
            static $regions = array(
                          DateTimeZone::AFRICA,
                          DateTimeZone::AMERICA,
                          DateTimeZone::ANTARCTICA,
                          DateTimeZone::ASIA,
                          DateTimeZone::ATLANTIC,
                          DateTimeZone::AUSTRALIA,
                          DateTimeZone::EUROPE,
                          DateTimeZone::INDIAN,
                          DateTimeZone::PACIFIC,
                      );
            $timezones = array();
            foreach ($regions as $region) {
                $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
            }

            $timezone_offsets = array();
            foreach ($timezones as $timezone) {
                $tz = new DateTimeZone($timezone);
                $timezone_offsets[$timezone] = $tz->getOffset(new DateTime());
            }
            asort($timezone);
            $timezone_list = array();
            foreach ($timezone_offsets as $timezone => $offset) {
                $offset_prefix = $offset < 0 ? '-' : '+';
                $offset_formatted = gmdate('H:i', abs($offset));

                $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

                $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
            }

            return $timezone_list;
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function saveMailSetting()
    {
        try {
            Model\Profile\MMyProfile::saveMailSetting($_POST);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function updateCardDetails()
    {
        try {
            Model\Profile\MCardDetails::updateCardDetails();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function saveTaxInfo()
    {
        try {
            Model\Profile\MTaxDetails::saveTaxInfo();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }

    public static function cancelsubscription()
    {
        try {
            $memberlink_details = Model\Profile\MMyProfile::getMemberslinkdetails();
            $subid             = $memberlink_details['authorize_subid'];

            Model\Profile\MCardDetails::cancelsubscription($subid);
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("Location:" . $_ENV['FCPATH'] . "/dashboard");
            exit();
        }
    }




}
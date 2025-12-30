<?php

namespace Admin\App\Models\Terminology;
use Admin\App\Models\Member\TerminologySetting;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class MTerminology
{


public static function showLanguage($lang)
{

     // dd($lang);
    $language = config('language');
    // dd($languages);


        $output = "";
        if (count((array)$language) > 0) {
            // $output = ' <select aria-label="label" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 bg-neutral-100 text-neutral-900 dark:bg-neutral-700 dark:text-white dark:border-neutral-600 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" data-actions-box="true" id="lang_list" name="lang_list" onchange="selectLang(this.value);" required aria-label="label" >';
            $output = '';
            foreach ($language as $key => $value) {
                if ($lang == $key) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                $output .= ' <option value="' . $key . '" ' . $selected . '>' . $value . '</option>
                            ';
            }
        }
        // $output .= '</select>';
        // dd($output);
        return $output;
}
public static function getTerminology($lang, $type)
{


    return TerminologySetting::where('type', $type)
            ->where('language', $lang)
            ->pluck('language_value', 'language_key')
            ->toArray();
}
public static function showTerminologySettingsNew($lang, $type)
{
    // dd($type);
    // $lang = $request->query('sub1', 'en');
    // STATIC DATA
    $data = [
         ["label" => "Your Registration Successfully", "key" => "CUS_YOUR_REGISTRATION_SUCCESSFULLY"],
            ["label" => "Admin Approval Accepted", "key" => "CUS_ADMIN_APRROVAL_ACCEPTED"],
            ["label" => "Payment Failure Registration", "key" => "CUS_PAYMENT_FAILURE_REGISTRATION"],
            ["label" => "Payment Successfully In", "key" => "CUS_PAYMENT_SUCCESSFULLY_IN"],
            ["label" => "Has Been Joined Your Downline", "key" => "CUS_HAS_BEEN_JOINED_YOUR_DOWNLINE"],
            ["label" => "3D Secure Failed", "key" => "CUS_3D_SECURE_FAILED"],
            ["label" => "Your IP Blocked", "key" => "CUS_YOURIPBLOCKED"],
            ["label" => "Invalid Useremail and Password", "key" => "CUS_INVALID_USEREMAIL_AND_PASSWORD"],
            ["label" => "Account Deleted", "key" => "CUS_ACCOUNT_DELETED"],
            ["label" => "Invalid Email", "key" => "CUS_INVALIDEMAIL"],
            ["label" => "Member Suspended for the Plan", "key" => "CUS_MEMBERSUSPENDED_FOR_THE_PLAN"],
            ["label" => "Member Suspended", "key" => "CUS_MEMBERSUSPENDED"],
            ["label" => "The Account Logged Already", "key" => "CUS_THEACCOUNT_LOGGED_ALREADY"],
            ["label" => "Payment Pending", "key" => "CUS_PAYMENT_PENDING"],
            ["label" => "Site Offline", "key" => "CUS_SITEOFFLINE"],
            ["label" => "Captcha Code", "key" => "CUS_CAPCHACODE"],
            ["label" => "Captcha Code Required", "key" => "CUS_CAPCHAREQUIRED"],
            ["label" => "Invalid Captcha", "key" => "CUS_INVALIDCAPCHA"],
            ["label" => "Enter Valid Captcha", "key" => "CUS_ENTER_VALID_CAPTCHA"],
            ["label" => "Invalid Username and Password", "key" => "CUS_INVALID_USERNAME_AND_PASSWORD"],
            ["label" => "Reset Password Link Send", "key" => "CUS_RESET_PASSWORD_LINK_SEND"],
            ["label" => "Invalid User", "key" => "CUS_INVALIDUSER"],
            ["label" => "Invalid Link", "key" => "CUS_INVALID_LINK"],
            ["label" => "Password Changed Successfully Done", "key" => "CUS_PASSWORD_CHANGED_SUCCEFFULY_DONE"],
            ["label" => "Invalid Users Login", "key" => "CUS_INVALID_USERS_LOGIN"],
            ["label" => "Newpassword Sent To Your Mail", "key" => "CUS_NEWPASSWORD_SENT_TO_YOUR_MAIL"],
            ["label" => "Invalid OTP", "key" => "CUS_INVALID_OTPP"],
            ["label" => "Payment Accepted Admin Approval", "key" => "CUS_PAYMENT_ACCEPTED_ADMIN_APPROVAL"],
            ["label" => "Invalid CSRF Code", "key" => "CUS_INVALID_CSRF_CODE"],
            ["label" => "Member Has Been Registered", "key" => "CUS_MEMBER_HAS_BEEN_REGISTERED"],
            ["label" => "Contacts Updated Successfull", "key" => "CUS_CONTACTS_UPDATED_SUCCESSFULL"],
            ["label" => "Contacts Not Updated", "key" => "CUS_CONTACTS_NOT_UPDATED"],
            ["label" => "Customer Groups Created Successfully", "key" => "CUS_CUSTOMER_GROUPS_CREATED_SUCCESSFULLY"],
            ["label" => "Customer Groups Failed", "key" => "CUS_CUSTOMER_GROUPS_FAILED"],
            ["label" => "Customer Groups Updated Successfully", "key" => "CUS_CUSTOMER_GROUPS_UPDATED_SUCCESSFULLY"],
            ["label" => "Customer Groups Update Failed", "key" => "CUS_CUSTOMER_GROUPS_UPDATE_FAILED"],
            ["label" => "Customer Groups Deleted Successfully", "key" => "CUS_CUTOMER_GROUPS_DELETED_SUCCESSFULLY"],
            ["label" => "Customer Groups Not Deleted", "key" => "CUS_CUSTOMER_GROUPS_NOT_DELETED"],
            ["label" => "Mail Send Successfully", "key" => "CUS_MAIL_SEND_SUCCESSFULLY"],
            ["label" => "Newslists Added Successfully", "key" => "CUS_NEWSLISTS_ADDED_SUCCESSFULLY"],
            ["label" => "Group Member Details Updated Successfully", "key" => "CUS_GROUP_MEMBER_DETAILS_UPDATED_SUCCESSFULLY"],
            ["label" => "Group Member Deleted Successfully", "key" => "CUS_GROUPMEMBERDELETEDSUCCEFFULLY"],
            ["label" => "Newslists Updated Successfully", "key" => "CUS_NEWSLISTS_UPDATED_SUCCESSFULLY"],
            ["label" => "Newsletter Template Added", "key" => "CUS_NEWSLETTER_TEMPLATE_ADDED"],
            ["label" => "Newsletter Template Updated Successfully", "key" => "CUS_NEWSLETTER_TEMPLATE_UPDATED_SUCCESSFULLY"],
            ["label" => "Newsletter Template Deleted Successfully", "key" => "CUS_NEWSLETTER_TEMPLATE_DELETED_SUCCESSFULLY"],
            ["label" => "Please Select Any Products", "key" => "CUS_PLEASE_SELECT_ANY_PRODUCTS"],
            ["label" => "Try Again", "key" => "CUS_TRY_AGAIN"],
            ["label" => "Template Created Successfully", "key" => "CUS_TEMPLATECREATEDSUCCESSFULLY"],
            ["label" => "Something Went Wrong", "key" => "CUS_SOMETHING_WENT_WRONG"],
            ["label" => "Template Deleted Successfully", "key" => "CUS_TEMPLATEDELETEDSUCCESSFULLY"],
            ["label" => "Template Not Deleted", "key" => "CUS_TEMPLATE_NOT_DELETED"],
            ["label" => "Template Updated Successfully", "key" => "CUS_TEMPLATEUPDTAEDSUCCESSFULLY"],
            ["label" => "New Campaign Name Updated Successfully", "key" => "CUS_NEWCAMPAIGNNAME_UPDATED_SUCCESSFULLY"],
            ["label" => "New Campaign Name Not Updated", "key" => "CUS_NEWCAMPAIGNNAME_NOT_UPDTAED"],
            ["label" => "Campaign Mail Settings Updated Successfully", "key" => "CUS_CAMPAIGN_MAIL_SETTINGS_UPDATED_SUCCESSFULLY"],
            ["label" => "Campaign Message Added Successfully", "key" => "CUS_CAMPAIGN_MESSAGE_ADDED_SUCCESFULLY"],
            ["label" => "Campaign Message Not Added", "key" => "CUS_CAMPAIGN_MESSAGE_NOT_ADDED"],
            ["label" => "Campaign Deleted Successfully", "key" => "CUS_CAMPAIGN_DELETED_SUCCESSFULLY"],
            ["label" => "Campaign Not Deleted", "key" => "CUS_CAMPAIGN_NOT_DELETED"],
            ["label" => "Campaign Updated Successfully", "key" => "CUS_CAMPAIGN_UPDATED_SUCCESSFULLY"],
            ["label" => "Campaign Not Updated", "key" => "CUS_CAMPAIGN_NOT_UPDATED"],
            ["label" => "The File You Are Attempt", "key" => "CUS_THE_FILE_YOU_ARE_ATTEMPT"],
            ["label" => "Require Field Cannot", "key" => "CUS_REQUIRE_FIELD_CANNOT"],
            ["label" => "SMS Send Successfully", "key" => "CUS_SMS_SEND_SUCCESSFULLY"],
            ["label" => "Course Payment Not Paid", "key" => "CUS_COURSE_PAYMENT_NOT_PAID"],
            ["label" => "Course Payment Success", "key" => "CUS_COURSE_PAYMENT_SUCCESS"],
            ["label" => "Payment Failed", "key" => "CUS_PAYMENT_FAILED"],
            ["label" => "Payment Has Been Made Failed", "key" => "CUS_PAYMENT_HAS_BEEN_MADE_FAILED"],
            ["label" => "Invalid Card Details", "key" => "CUS_INVALID_CARD_DETAILS"],
            ["label" => "Site Settings Successfully Updated", "key" => "CUS_SITE_SETTINGS_SUCCESSFULLY_UPDATED"],
            ["label" => "Testimonial Updated Successfully", "key" => "CUS_TESTIMONIAL_UPDATED_SUCCESSFULLY"],
            ["label" => "Testimonial Added Successfully", "key" => "CUS_TESTIMONIAL_ADDED_SUCCESSFULLY"],
            ["label" => "Pages Added Successfully", "key" => "CUS_PAGES_ADDED_SUCCESSFULLY"],
            ["label" => "Pages Updated Successfully", "key" => "CUS_PAGES_UPDATED_SUCCESSFULLY"],
            ["label" => "Product Autoshipped Deleted Successfully", "key" => "CUS_PRODUCT_AUTOSHIPPED_DELETED_SUCCESSFULLY"],
            ["label" => "Product Autoshipped Deleted Failed", "key" => "CUS_PRODUCT_AUTOSHIPPED_DELETED_FAILED"],
            ["label" => "Party Setup Has Been Updated", "key" => "CUS_PARTY_SETUP_HAS_BEEN_UPDATED"],
            ["label" => "User Added Successfully", "key" => "CUS_USER_ADDED_SUCCESSFULLY"],
            ["label" => "User Select PartyId", "key" => "CUS_SELECT_PARTYID"],
            ["label" => "Party Setup Has Been Deleted", "key" => "CUS_PARTY_SETUP_HAS_BEEN_DELETED"],
            ["label" => "Party Setup Has Not Been Deleted", "key" => "CUS_PARTY_SETUP_HAS_NOT_BEEN_DELETED"],
            ["label" => "Request Epin Successfully", "key" => "CUS_REQUEST_EPIN_SUCCESSFULLY"],
            ["label" => "Epin Not Generated", "key" => "CUS_EPIN_NOT_GENERATED"],
            ["label" => "Count Must Number", "key" => "CUS_COUNT_MUST_NUMBER"],
            ["label" => "Insufficient Balance", "key" => "CUS_INSUFFICIENT_BALANCE"],
            ["label" => "Invalid Epin", "key" => "CUS_INVLAID_EPIN"],
            ["label" => "Enter The Epin", "key" => "CUS_ENTER_THE_EPIN"],
            ["label" => "Invalid Transaction Password", "key" => "CUS_INVALID_TRANSACTION_PASSWORD"],
            ["label" => "Message Sent Successfully", "key" => "CUS_MESSAGE_SENT_SUCCESSFULLY"],
            ["label" => "Message Not Sent", "key" => "CUS_MESSSAGE_NOT_SENT"],
            ["label" => "No Members Found", "key" => "CUS_NO_MEMBERS_FOUND"],
            ["label" => "Message Notify", "key" => "CUS_MESSAGE_NOTIFY"],
            ["label" => "Message Read Successfully", "key" => "CUS_MESSAGE_READ_SUCCESSFULLY"],
            ["label" => "Message Not Deleted", "key" => "CUS_MESSSAGE_NOT_DELETED"],
            ["label" => "Newticket Added Successfully", "key" => "CUS_NEWTICEKT_ADDED_SUCCESSFULLY"],
            ["label" => "Reply Send Successfully", "key" => "CUS_REPLY_SEND_SUCCESSFULLY"],
            ["label" => "Event Has Been Added Successfully", "key" => "CUS_EVENT_HAS_BEEN_ADDED_SUCCESSFULLY"],
            ["label" => "Event Has Been Deleted Successfully", "key" => "CUS_EVENT_HAS_BEEN_DELETED_SUCCESSFULLY"],
            ["label" => "Group Has Not Been Deleted", "key" => "CUS_GROUP_HAS_NOT_BEEN_DELETED"],
            ["label" => "Event Has Been Updated Successfully", "key" => "CUS_EVENT_HAS_BEEN_UPDATED_SUCCESSFULLY"],
            ["label" => "Unable Update Please Update Again", "key" => "CUS_UNABLE_UPDATE_PLEASE_UPDATE_AGAIN"],
            ["label" => "Account Added Successfully", "key" => "CUS_ACCOUT_ADDED_SUCCESSFULLY"],
            ["label" => "Personal Info Updated", "key" => "CUS_PERSONAL_INFO_UPDATED"],
            ["label" => "Personal Info Not Updated", "key" => "CUS_PERSONAL_INFO_NOT_UPDATED"],
            ["label" => "Password Updated Successfully", "key" => "CUS_PASSWORD_UPDATED_SUCCEFULLY"],
            ["label" => "Password Not Updated", "key" => "CUS_PASSWORD_NOT_UPDATED"],
            ["label" => "Avatar Updated Successfully", "key" => "CUS_AVATAR_UPDATED_SUCCEFFULLY"],
            ["label" => "Avatar Not Updated", "key" => "CUS_AVATAR_NOT_UPDATED"],
            ["label" => "Transaction Password Updated Successfully", "key" => "CUS_TRANSACTION_PASSWORD_UPDATED_SUCESSFULLY"],
            ["label" => "Transaction Password Not Updated", "key" => "CUS_TRANSACTION_PASSWORD_NOT_UPDATED"],
            ["label" => "Required Error", "key" => "CUS_REQUIRED_ERROR"],
            ["label" => "ValidOTP", "key" => "CUS_VALIDOTP"],
            ["label" => "OTP", "key" => "CUS_OTP"],
            ["label" => "Provide Valid Phone", "key" => "CUS_PROVIDE_VALID_PHONE"],
            ["label" => "Invalid Data", "key" => "CUS_INVALID_DATA"],
            ["label" => "Notify Updated Success", "key" => "CUS_NOTIFY_UPDATED_SUCCESS"],
            ["label" => "Cancel Stripe Subscription Before Upgrade", "key" => "CUS_CANCEL_STRIPE_SUBSCRIPTION_BEFOREUPGRADE"],
            ["label" => "Ok", "key" => "CUS_OK"],
            ["label" => "Cancel Chargebee Subscription Before Upgrade", "key" => "CUS_CANCEL_CHARGEBEE_SUBSCRIPTION_BEFOREUPGRADE"],
            ["label" => "Confirmation", "key" => "CUS_CONFIRMATION"],
            ["label" => "Cancel Authorize Subscription Before Upgrade", "key" => "CUS_CANCEL_AUTHORIZE_SUBSCRIPTION_BEFOREUPGRADE"],
            ["label" => "Yes Sure", "key" => "CUS_YES_SURE"],
            ["label" => "Cancel It", "key" => "CUS_CANCEL_IT"],
            ["label" => "Your Record Safe", "key" => "CUS_YOUR_RECORD_SAFE"],
            ["label" => "Do You Want Cancel Subscription", "key" => "CUS_DO_YOU_WANT_CANCEL_SUBSCRIPTION"],
            ["label" => "Done", "key" => "CUS_DONE"],
            ["label" => "Subcription Cancelled Deduct Payment", "key" => "CUS_SUBCRIPTION_CANCELLED_DEDUCT_PAYMENT"],
            ["label" => "Cancelled", "key" => "CUS_CANCELLED"],
            ["label" => "Your Withdraw Successfully", "key" => "CUS_YOUR_WITHDRAWAL_SUCCESSFULLY"],
            ["label" => "Your Request Not Placed", "key" => "CUS_YOUR_REUEST_NOT_PLACED"],
            ["label" => "Withdrawal Account Added Successfully", "key" => "CUS_WITHDRAWAL_ACCOUT_ADDED_SUCCESSFULLY"],
            ["label" => "Already In Use", "key" => "CUS_ALREADY_IN_USE"],
            ["label" => "Numeric Error", "key" => "CUS_NUMERIC_ERROR"],
            ["label" => "Fund Has Been Transferred Successfully", "key" => "CUS_FUND_HAS_BEED_TRANSFERRED_SUCCESSFULLY"],
            ["label" => "Fund Transferred Failed", "key" => "CUS_FUND_TRANSFERRED_FAILED"],
            ["label" => "Amount Number", "key" => "CUS_AMOUNT_NUMBER"],
            ["label" => "Fundtransfer Amount Less Than Current Balance", "key" => "CUS_FUNDTRANSFER_AMOUNT_LESS_THAN_CURRENT_BALANCE"],
            ["label" => "Ewallet Payment Msg Info", "key" => "CUS_EWALLETPAYMENTMSGINFO"],
            ["label" => "Ewallet Payment Success Message", "key" => "CUS_EWALLETPENINGPAYMENTSUCCESSMESSAGE"],
            ["label" => "Ewallet Success Message", "key" => "CUS_EWALLETSUCCESSMESSAGE"],
            ["label" => "Amount Credited To Ewallet", "key" => "CUS_AMOUNTCREDITEDTOEWALLET"],
            ["label" => "Upgrade Plan Package", "key" => "CUS_UPGRADE_PLAN_PACKAGE"],
            ["label" => "Payment is Pending", "key" => "CUS_PAYMENT_IS_PENDING"],
            ["label" => "This Package Is Purchased", "key" => "CUS_THIS_PACKAGE_IS_PURCHASED"],
            ["label" => "Package Success", "key" => "CUS_PACKAGE_SUCCESS"],
            ["label" => "Plan", "key" => "CUS_PLAN"],
            ["label" => "Total Amount Pay", "key" => "CUS_TOTAL_AMOUNT_PAY"],
            ["label" => "Duplicate Entry Users", "key" => "CUS_DUPLICATE_ENTRY_USERS"],
            ["label" => "Invalid Users", "key" => "CUS_INVALID_USERS"],
            ["label" => "Have Been Upload Successful", "key" => "CUS_HAVE_BEEN_UPLOAD_SUCCEFFULL"],
            ["label" => "Do You Want To Delete", "key" => "CUS_DOYOU_WANT_TO_DELETE"],
            ["label" => "Campaign Message", "key" => "CUS_CAMPAIGNMESSAGE"],
            ["label" => "Deleted", "key" => "CUS_DELETED"],
            ["label" => "Customer Group", "key" => "CUS_CUSTOMER_GROUP"],
            ["label" => "Please Select Items", "key" => "CUS_PLEASE_SELECT_ITEMS"],
            ["label" => "Selectshow", "key" => "CUS_SELECTSHOW"],
            ["label" => "Recipient Add Group Successfully", "key" => "CUS_RECIPIENT_ADD_GROUP_SUCCESSFULLY"],
            ["label" => "Add Recipient", "key" => "CUS_ADD_RECIPIENT"],
            ["label" => "Recipient Add Group Failed", "key" => "CUS_RECIPIENT_ADD_GROUP_FAILED"],
            ["label" => "Do You Want To Add", "key" => "CUS_DOYOU_WANT_TO_ADD"],
            ["label" => "Events", "key" => "CUS_EVENTS"],
            ["label" => "Events Has Been Deleted Successfully", "key" => "CUS_EVENT_HAS_BEEN_DELETED_SUCCESSFULLY"],
            ["label" => "Lead Contacts", "key" => "CUS_LEAD_CONTACTS"],
            ["label" => "Do you want to change status", "key" => "CUS_DOYOU_WANT_TO_CHANGE_STATUS"],
            ["label" => "Lead Capture Page", "key" => "CUS_LEAD_CAPTURE_PAGE"],
            ["label" => "Template Deleted", "key" => "CUS_TEMPLATE_DELETED"],
            ["label" => "Copy to clip", "key" => "CUS_COPYTOCLIP"],
            ["label" => "Your Record Safe", "key" => "CUS_YOURRECORDSSAFE"],
            ["label" => "Please Select The Message", "key" => "CUS_PLEASE_SELECT_THE_MESSAGE"],
            ["label" => "Mark as read", "key" => "CUS_MARK_AS_READ"],
            ["label" => "Message Not Read", "key" => "CUS_MESSSAGE_NOT_READ"],
            ["label" => "Message Deleted Successfully", "key" => "CUS_MESSAGE_DELETED_SUCCESSFULLY"],
            ["label" => "Select User", "key" => "CUS_SELECTUSER"],
            ["label" => "Invalid File Format", "key" => "CUS_INVALIDFILEFORMAT"],
            ["label" => "Select Valid Downline", "key" => "CUS_SELECT_VALID_DOWNLINE"],
            ["label" => "View Msg", "key" => "CUS_VIEWMSG"],
            ["label" => "Email Already Exists", "key" => "CUS_EMAIL_ALREADY_EXISTS"],
            ["label" => "Valid Password", "key" => "CUS_VALIDPASSWORD"],
            ["label" => "Enter Password", "key" => "CUS_ENTERPASSWORD"],
            ["label" => "Enter Maxlength", "key" => "CUS_ENTERMAXLENGTH"],
            ["label" => "Mismatch", "key" => "CUS_MISMATCH"],
            ["label" => "Repeat Password", "key" => "CUS_REPEATPASSWORD"],
            ["label" => "Invalid File Format", "key" => "CUS_INVALID_FILE_FORMAT"],
            ["label" => "Group Mem Deleted Successfully", "key" => "CUS_GROUPMEM_DELETED_SUCCESSFULLY"],
            ["label" => "Group Mem Not Deleted", "key" => "CUS_GROUPMEM_NOT_DELETED"],
            ["label" => "Subscriber Status Changed", "key" => "CUS_SUBSCRIBER_STATUS_CHANGED"],
            ["label" => "Subscriber Status Not Changed", "key" => "CUS_SUBSCRIBER_STATUS_NOT_CHANGED"],
            ["label" => "Newslist Deleted Successfully", "key" => "CUS_NEWSLIST_DELETED_SUCCESSFULLY"],
            ["label" => "Newslist Not Deleted", "key" => "CUS_NEWSLIST_NOT_DELETED"],
            ["label" => "Invalid Member Name", "key" => "CUS_INVALID_MEMBER_NAME"],
            ["label" => "Error For Maxlength 15", "key" => "CUS_ERROR_FOR_MAXLENGTH_15"],
            ["label" => "Username Already Exists", "key" => "CUS_USERNAME_ALREADY_EXISTS"],
            ["label" => "Email Error", "key" => "CUS_EMAIL_ERROR"],
            ["label" => "Invalid Password", "key" => "CUS_INVALID_PASSWORD"],
            ["label" => "Image File Below 2MB", "key" => "CUS_IMAGE_FILE_BELOW_2MB"],
            ["label" => "Invalid Password Format", "key" => "CUS_INVALID_PASSWORD_FORMAT"]
        ];
        // ... your full array ...
    

    // Extract all keys
    $keys = array_column($data, 'key');

    // Fetch all values in ONE QUERY (not inside loop)
    $records = TerminologySetting::where('type', $type)
        ->where('type', $type)
        ->where('language', $lang)
        ->whereIn('language_key', $keys)
        ->pluck('language_value', 'language_key')
        ->toArray();


    $content = '';

    foreach ($data as $item) {

        $label = $item['label'];
        $key   = $item['key'];

        // Get value if exists, else empty
        $value = $records[$key] ?? '';

        $content .= '
            <button type="button"
                class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-b-0 border-neutral-200 rounded-t-xl focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3"
                data-accordion-target="#accordion-'.$key.'" aria-controls="accordion-'.$key.'">

                <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                    '.$label.'
                </span>

                <input type="text" name="'.$key.'" id="'.$key.'"
                    class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 
                    dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2"
                    value="'.$value.'" required>
            </button>
        ';
    }
//   dd($content);
    return $content;
}

public static function updateTerminologySettings(Request $request, $lang)
{
    // dd($lang);
    // Get 'type' from request
    $type = $request->input('type');

    // Filter out keys that are not actual terminology fields
    $ignoredKeys = ['_token', 'type', 'do', 'action', 'sub1'];

    foreach ($request->except($ignoredKeys) as $key => $value) {
        // Skip empty values if needed
        if ($value === null) continue;

        // Update existing or create new record
        TerminologySetting::updateOrCreate(
            [
                'type' => $type,
                'language' => $lang,
                'language_key' => $key
            ],
            [
                'language_value' => $value,
                'updatedat' => now()
            ]
        );
    }

    // Flash success message
    session()->flash('success', 'Terminology configuration has been updated successfully');

    return true;
}
}
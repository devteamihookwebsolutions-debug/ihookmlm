<?php

namespace Admin\App\Models\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Admin\App\Models\Member\Payment;
use Admin\App\Models\Member\Admin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Admin\App\Mail\AdminOtpMail;

class MPaymentSettings
{
public static function showPaymentSettingsList()
{
   return Payment::where('paymentsettings_status', '!=', 'Deleted')
        ->get([
            'paymentsettings_id',
            'paymentsettings_name',
            'paymentsettings_accname',
            'paymentsettings_accnum',
            'paymentsettings_status',
            'paymentsettings_default_name',
            'paymentsettings_mode'
        ]);
}
public static function getBankwirePaymentSettings()
{
    $record = DB::table('ihook_bankwire_table')
        ->where('bankwire_id', 1)
        ->first();

    $record = (array) $record;   // convert stdClass to array

    // dd($record);    // now array

    return $record;
}
// public static function sendOTPPayment()
// {
//     // dd('function reached or not');
//     // 1. Get Main Admin
//     $admin = Admin::where('admin_type', 1)->first();
//     // dd($admin);
//     if (!$admin) {
//         return 0;
//     }

//     $random_no = rand(100000, 999999);

//     // Store OTP in session
//     Session::put('admin_otp_masspayout', $random_no);

//     // -------------------------
//     // 2. Send Email Notification
//     // -------------------------

//     $email_notifications_enabled = DB::table('ihook_sitesettings_table')
//         ->where('sitesettings_name', 'email_notification_admin')
//         ->value('sitesettings_value');

//     if ($email_notifications_enabled == '1') {

//         $mailLang = session('sitelang_id', 1);

//         $template = DB::table('ihook_mailtemplates_table')
//             ->where('mail_default_name', 'mail_send_otp')
//             ->where('mail_status', 1)
//             ->where('mail_lang', $mailLang)
//             ->first();

//         if (!$template) {
//             $template = DB::table('ihook_mailtemplates_table')
//                 ->where('mail_default_name', 'mail_send_otp')
//                 ->where('mail_status', 1)
//                 ->where('mail_lang', 1)
//                 ->first();
//         }

//         $message = str_replace('[otp]', $random_no, $template->mail_content);

//         Mail::send([], [], function ($mail) use ($admin, $template, $message) {
//             $mail->to($admin->admin_email)
//                 ->subject($template->mail_subject ?? "OTP Code")
//                 ->html($message);
//         });
//     }

//     // -------------------------
//     // 3. Send SMS
//     // -------------------------

//     if (!empty($admin->admin_phone)) {

//         $siteName = DB::table('ihook_sitesettings_table')
//             ->where('sitesettings_name', 'site_name')
//             ->value('sitesettings_value');

//         $smsMessage = "
//             Hi {$admin->admin_username},
//             Your OTP Code - {$random_no}
//             {$siteName}
//         ";

//         // CUSTOM SMS IMPLEMENTATION
//         MSendSms::sendSms($admin->admin_phone, $smsMessage);
//     }

//     // -------------------------
//     // 4. Store encrypted OTP
//     // -------------------------

//     $encrypted = MCryptoGraphy::encryptionData($random_no);

//     Admin::where('admin_id', session('admin.id'))
//         ->where('admin_status', 'enable')
//         ->update([
//             'admin_otp'         => $encrypted,
//             'admin_otp_decrypt' => $random_no,
//         ]);

//     return 1;
// }

//  public static function sendOTPPayment()
//     {
//         // Get admin_type = 1
//         $admin = Admin::where('admin_type', 1)
//             ->where('admin_status', 'enable')
//             ->first();
// // dd($admin);
//         if (!$admin) {
//             return 0;
//         }

//         // Generate OTP
//         $otp = random_int(100000, 999999);

//         // Encrypt OTP (like your MCryptoGraphy)
//         $encryptedOtp = Crypt::encryptString($otp);

//         // Update admin table
//         $admin->admin_otp = $encryptedOtp;
//         $admin->admin_otp_decrypt = $otp;
//         $admin->save();

//         // Send Email
//        $admin = Admin::find(1);

// Mail::to($admin->admin_email)
//     ->send(new AdminOtpMail($otp, $admin->admin_username));


//         return 1;
//     }

public static function sendOTPPayment()
{
    $admin = Admin::where('admin_type', 1)
                  ->where('admin_status', 'enable')
                  ->first();
    //  dd($admin);
    if (!$admin) {
        return false; // Changed to boolean for clarity
    }

    // Generate OTP
    $otp = random_int(100000, 999999);

    // Encrypt OTP
    $admin->admin_otp = Crypt::encryptString($otp);
    $admin->admin_otp_decrypt = $otp; // Note: Storing plain OTP is insecure — consider removing
    $admin->save();

    // Send email
    try {
        Mail::to($admin->admin_email)
            ->send(new AdminOtpMail($otp, $admin->admin_username));
        return true;
    } catch (\Exception $e) {
        // Log error for debugging
        Log::error("OTP email failed: " . $e->getMessage());
        return false;
    }
}
}

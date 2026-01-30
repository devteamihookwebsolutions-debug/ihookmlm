<?php

/**
 * This class contains public functions related to UserForgotPasswordController
 *
 * @package         UserForgotPasswordController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace User\App\Http\Controllers;
use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Admin\App\Models\Mail\MEmailTemplate;
use Admin\App\Models\Factories\MEmailSettings;

use Admin\App\Models\Middleware\MSiteSettings;
use Session;
use Admin\App\Models\Member\Admin;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\UserPasswordOtp;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class UserForgotPasswordController extends Controller{

    public function showEmailForm()
    {      
        return view('user::auth.forgot-email');
    }

     public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $member = Member::where('members_email', $request->email)->first();


        if(!$member){
            return back()->withErrors(['email' => 'Member email not found']);
        }

        $otp = rand(100000, 999999);
         
        $member->user_otp = Hash::make($otp);  
        $member->save();

        $template = MEmailTemplate::getTemplateByDefaultName('forget_password_mail');

        //  echo '<pre>';
        //  print_r($template);
        //  exit();

        if (!$template) {
            return back()->withErrors(['email' => 'Forgot password email template not found']);
        }

         $mailContent = str_replace(
            ['[site_name]', '[name]', '[pass]'],
            [
                config('app.name'),
                $member->members_username,
                $otp
            ],
            $template->mail_content
        );

        $smtp = MEmailSettings::getEmailSettings();
        $senderEmail = $template->mail_from;
        // echo '<pre>';
        // print_r($senderEmail);exit();
    
        $senderEmail = $template->mail_from ?? $smtp->sender_email ?? 'admin@tradetrailblazer.com';
        $senderName  = $template->mail_from_name ?? $smtp->sender_name ?? config('app.name');

       
        $subject     = $template->mail_subject ?? 'Forgot Password OTP';

    
        Mail::send([], [], function ($message) use ($request, $mailContent, $senderEmail, $senderName, $subject) {
            $message->to($request->email)
                    ->from($senderEmail, $senderName)
                    ->subject($subject)
                    ->html($mailContent); 
        });

        session(['user_reset_email' => $request->email]);

        return redirect()->route('user.forgot.password.verify')
            ->with('success', 'OTP sent to your email');
    }

    public function showOtpForm()
    {
        if (!session('user_reset_email')) {
            return redirect()->route('user.forgot.password');
        }

        $email = session('user_reset_email');

        $otpRecord = UserPasswordOtp::where('email', $email)
            ->latest()
            ->first();

        if (!$otpRecord) {
            return redirect()->route('user.forgot.password')->withErrors(['email' => 'No OTP found. Please request again.']);
        }

        return view('user::auth.verify-otp', [
            'email' => $email,
           
        ]);
    }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $email = session('user_reset_email');

        if (!$email) {
            return back()->withErrors(['otp' => 'Session expired. Please request OTP again.']);
        }

        $member = Member::where('members_email', $email)->first();

        if (!$member) {
            return back()->withErrors(['otp' => 'User not found']);
        }

        if (!Hash::check($request->otp, $member->user_otp)) {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

      
        session(['user_otp_verified' => true]);

        return redirect()->route('user.reset.password');
    }

   

    public function showResetForm()
    {
        if (!session('user_otp_verified')) {
            return redirect()->route('user.forgot.password');
        }

        return view('user::auth.reset-password');
    }



    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required','confirmed','min:8','regex:/[A-Z]/','regex:/[0-9]/','regex:/[@$!%*#?&]/', 
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
        ]);

        $email = session('user_reset_email');

        if (!$email) {
            return redirect()->route('user.forgot.password')
                ->withErrors(['email' => 'Session expired. Please request OTP again.']);
        }

        $member = Member::where('members_email', $email)->first();

        if (!$member) {
            return redirect()->route('user.forgot.password')
                ->withErrors(['email' => 'Member account not found.']);
        }

        $member->update([
            'members_password' => Hash::make($request->password)
        ]);

        
       $template = MEmailTemplate::getTemplateByDefaultName('reset_password_mail');

        if (!$template) {
            return back()->withErrors(['email' => 'Reset password email template not found']);
        }

        $mailContent = str_replace(
            ['[site_name]', '[name]', '[pass]'],   
            [
                config('app.name'),
                $member->members_username,
                $request->password                 
            ],
            $template->mail_content
        );

         $smtp = MEmailSettings::getEmailSettings();

        $senderEmail = $template->mail_from ?? $smtp->sender_email ?? 'admin@tradetrailblazer.com';
        $senderName  = $template->mail_from_name ?? $smtp->sender_name ?? config('app.name');
        $subject     = $template->mail_subject ?? 'Password Reset Confirmation';

        //  Send mail
        Mail::send([], [], function ($message) use ($email, $mailContent, $senderEmail, $senderName, $subject) {
            $message->to($email)
                    ->from($senderEmail, $senderName)
                    ->subject($subject)
                    ->html($mailContent);
        });


        session()->forget([
            'user_reset_email',
            'user_otp_verified'
        ]);

        return redirect()->route('user.login')
            ->with('success', 'Password reset successfully. Confirmation email sent.');
    }

    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'password' => [
    //             'required',
    //             'confirmed',
    //             'min:8',
    //             'regex:/[A-Z]/',
    //             'regex:/[0-9]/',
    //             'regex:/[@$!%*#?&]/',
    //         ],
    //     ], [
    //         'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
    //     ]);

    //     $email = session('admin_reset_email');

    //     if (!$email) {
    //         return redirect()->route('admin.forgot.password')
    //             ->withErrors(['email' => 'Session expired. Please request OTP again.']);
    //     }

    //     $admin = Admin::where('admin_email', $email)->first();

    //     if (!$admin) {
    //         return redirect()->route('admin.forgot.password')
    //             ->withErrors(['email' => 'Admin account not found.']);
    //     }

    //     //  Update password
    //     $admin->update([
    //         'admin_password' => Hash::make($request->password)
    //     ]);

    //     //  Fetch email template
    //     $template = MEmailTemplate::getTemplateByDefaultName('reset_password_mail');

    //     if (!$template) {
    //         return back()->withErrors(['email' => 'Reset password email template not found']);
    //     }

    //     // Build mail body (same as old PHP logic)
    //     $mailContent = str_replace(
    //         ['[site_name]', '[name]', '[pass]'],   
    //         [
    //             config('app.name'),
    //             $admin->admin_username,
    //             $request->password                 
    //         ],
    //         $template->mail_content
    //     );

    //     // SMTP / Sender
    //     $smtp = MEmailSettings::getEmailSettings();

    //     $senderEmail = $template->mail_from ?? $smtp->sender_email ?? 'admin@tradetrailblazer.com';
    //     $senderName  = $template->mail_from_name ?? $smtp->sender_name ?? config('app.name');
    //     $subject     = $template->mail_subject ?? 'Password Reset Confirmation';

    //     //  Send mail
    //     Mail::send([], [], function ($message) use ($email, $mailContent, $senderEmail, $senderName, $subject) {
    //         $message->to($email)
    //                 ->from($senderEmail, $senderName)
    //                 ->subject($subject)
    //                 ->html($mailContent);
    //     });

    //     //  Clear session
    //     session()->forget(['admin_reset_email', 'admin_otp_verified']);

    //     return redirect()->route('admin.login')
    //         ->with('success', 'Password reset successfully. Confirmation email sent.');
    // }



    public function resendOtp(Request $request)
    {
        
        $email = session('user_reset_email');
        if(!$email){
            return response()->json([
                'status' => 'error',
                'message' => 'Session expired. Please restart process.'
            ]);
        }

      
        $member = Member::where('members_email', $email)->first();
        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ]);
        }

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(1);

             
        $member->user_otp = Hash::make($otp);  
        $member->save();

        $template = MEmailTemplate::getTemplateByDefaultName('forget_password_mail');

        if (!$template) {
            return back()->withErrors(['email' => 'Forgot password email template not found']);
        }

        $mailContent = str_replace(
            ['[site_name]', '[name]', '[pass]'],
            [
                config('app.name'),
                $member->members_username,
                $otp
            ],
            $template->mail_content
        );

        $smtp = MEmailSettings::getEmailSettings();

        $senderEmail = $smtp->sender_email ?? 'admin@tradetrailblazer.com';
        $senderName  = $smtp->sender_name ?? config('app.name');
        $subject     = $template->mail_subject ?? 'Forgot Password OTP';

    
        Mail::send([], [], function ($message) use ($request, $mailContent, $senderEmail, $senderName, $subject) {
            $message->to($request->email)
                    ->from($senderEmail, $senderName)
                    ->subject($subject)
                    ->html($mailContent); 
        });

        session(['user_reset_email' => $request->email]);

        return response()->json([
            'status' => 'success',
            'message' => 'OTP resent successfully',
            'expires_at' => $expiresAt->toIso8601String() 
        ]);
    }
   
    
}
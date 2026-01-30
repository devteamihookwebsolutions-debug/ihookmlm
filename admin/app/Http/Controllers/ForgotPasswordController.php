<?php

/**
 * This class contains public functions related to ForgotPasswordController
 *
 * @package         ForgotPasswordController
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

namespace Admin\App\Http\Controllers;
use Admin\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Session;
use Admin\App\Models\Member\Admin;
use Admin\App\Models\Member\AdminPasswordOtp;
use Admin\App\Models\Mail\MEmailTemplate;
use Admin\App\Models\Factories\MEmailSettings;

use Admin\App\Models\Middleware\MSiteSettings;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller{

    public function showEmailForm()
    {
        return view('admin::auth.forgot-email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $admin = Admin::where('admin_email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Admin email not found']);
        }
        $plainPassword = Str::random(16);

        $admin->admin_password = Hash::make($plainPassword);
        $admin->save();


        $template = MEmailTemplate::getTemplateByDefaultName('forget_password_mail');

        if (!$template) {
            return back()->withErrors(['email' => 'Forgot password email template not found']);
        }


        $mailContent = str_replace(
            ['[site_name]', '[name]', '[pass]'],
            [
                config('app.name'),
                $admin->admin_username,
                $plainPassword
            ],
            $template->mail_content
        );

        $smtp = MEmailSettings::getEmailSettings();
        $senderEmail = !empty($template->mail_from)
            ? $template->mail_from
            : (!empty($smtp->sender_email) ? $smtp->sender_email : 'admin@tradetrailblazer.com');

        $senderName = !empty($template->mail_from_name)
            ? $template->mail_from_name
            : (!empty($smtp->sender_name) ? $smtp->sender_name : config('app.name'));

        $subject = !empty($template->mail_subject)
            ? $template->mail_subject
            : 'Your New Password';



        Mail::send([], [], function ($message) use ($request, $mailContent, $senderEmail, $senderName, $subject) {
            $message->to($request->email)
                    ->from($senderEmail, $senderName)
                    ->subject($subject)
                    ->html($mailContent);
        });

        return redirect()->route('admin.login')
            ->with('success', 'A new password has been sent to your registered email. Please check your inbox.');

    }

    // public function showOtpForm()
    // {
    //     if (!session('admin_reset_email')) {
    //         return redirect()->route('admin.forgot.password');
    //     }

    //     $email = session('admin_reset_email');

    //     $otpRecord = AdminPasswordOtp::where('email', $email)
    //         ->latest()
    //         ->first();

    //     if (!$otpRecord) {
    //         return redirect()->route('admin.forgot.password')->withErrors(['email' => 'No OTP found. Please request again.']);
    //     }

    //     return view('admin::auth.verify-otp', [
    //         'email' => $email,
    //         // 'expires_at' => $otpRecord->expires_at->toIso8601String(),
    //     ]);
    // }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $email = session('admin_reset_email');

        $otpRecord = Admin::where('admin_email', $email)->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'OTP not found']);
        }

        if (!Hash::check($request->otp, $otpRecord->admin_otp)) {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

        session(['admin_otp_verified' => true]);

        return redirect()->route('admin.reset.password');
    }



    public function showResetForm()
    {
        if (!session('admin_otp_verified')) {
            return redirect()->route('admin.forgot.password');
        }

        return view('admin::auth.reset-password');
    }



    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
        ]);

        $email = session('admin_reset_email');

        if (!$email) {
            return redirect()->route('admin.forgot.password')
                ->withErrors(['email' => 'Session expired. Please request OTP again.']);
        }

        $admin = Admin::where('admin_email', $email)->first();

        if (!$admin) {
            return redirect()->route('admin.forgot.password')
                ->withErrors(['email' => 'Admin account not found.']);
        }

        //  Update password
        $admin->update([
            'admin_password' => Hash::make($request->password)
        ]);

        //  Fetch email template
        $template = MEmailTemplate::getTemplateByDefaultName('reset_password_mail');

        if (!$template) {
            return back()->withErrors(['email' => 'Reset password email template not found']);
        }

        // Build mail body (same as old PHP logic)
        $mailContent = str_replace(
            ['[site_name]', '[name]', '[pass]'],
            [
                config('app.name'),
                $admin->admin_username,
                $request->password
            ],
            $template->mail_content
        );

        // SMTP / Sender
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

        //  Clear session
        session()->forget(['admin_reset_email', 'admin_otp_verified']);

        return redirect()->route('admin.login')
            ->with('success', 'Password reset successfully. Confirmation email sent.');
    }





    public function resendOtp(Request $request)
    {
        $email = session('admin_reset_email');
        if(!$email){
            return response()->json([
                'status' => 'error',
                'message' => 'Session expired. Please restart process.'
            ]);
        }

        $admin = Admin::where('admin_email', $email)->first();
        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin not found'
            ]);
        }

        $otp = rand(100000, 999999);


        $admin->admin_otp_decrypt = $otp;
        $admin->admin_otp = Hash::make($otp);
        $admin->save();

        $template = MEmailTemplate::getTemplateByDefaultName('forget_password_mail');

        if (!$template) {
            return back()->withErrors(['email' => 'Forgot password email template not found']);
        }


        $mailContent = str_replace(
            ['[site_name]', '[name]', '[pass]'],
            [
                config('app.name'),
                $admin->admin_username,
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

        session(['admin_reset_email' => $request->email]);

        return redirect()->route('admin.forgot.password.verify')
            ->with('success', 'OTP sent to your email');


        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'OTP resent successfully',
        //     'expires_at' => $expiresAt->toIso8601String()
        // ]);
    }





}

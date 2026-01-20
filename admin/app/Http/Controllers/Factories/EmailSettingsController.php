<?php

/**
 * This class contains public functions related to EmailSettingsController
 *
 * @package         EmailSettingsController
 * @category        Controller
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php
namespace Admin\App\Http\Controllers\Factories;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Factories\MEmailSettings;
use Admin\App\Models\Middleware\MSiteSettings;
use  Admin\App\Models\Middleware\MAmazonCloudFront;
use  Admin\App\Models\Middleware\MAdminActivityLog;
use Illuminate\Http\Request;
use Admin\App\Models\Member\Banner;
use Exception;
use Illuminate\Support\Facades\Session;

class EmailSettingsController extends Controller
{

public function viewEmailSettings()
{
                // 1 Get email settings
            $emailSettings = MEmailSettings::getEmailSettings();
            $emailNotificationSettings = MEmailSettings::getENotificationSettings();

            // dd($emailNotificationSettings);
            // 2 Get site settings
            $siteSettings = MSiteSettings::showSiteSettings('');
            // dd($siteSettings);

            // 3 Generate CloudFront URLs
            $mailBackground = $siteSettings['mail_background'] ?? null;
            $mailBackgroundCdn = $mailBackground
                ? env('CDNCLOUDEXTURL'). '/' . MAmazonCloudFront::getCloudFrontUrl($mailBackground)
                : null;
                // dd($mailBackgroundCdn);

            $mailLogo = $siteSettings['mail_sitelogo'] ?? null;
            $mailLogoCdn = $mailLogo
                ? env('CDNCLOUDEXTURL') . '/' . MAmazonCloudFront::getCloudFrontUrl($mailLogo)
                : null;

            // dd($mailBackground);
            // 4 Return Blade view with data
            return view('factories.mailsettings', [
                'errval' => $emailSettings,
                'email_set' => $emailNotificationSettings,
                'show_sitesettings' => $siteSettings,
                'mail_background' => $mailBackground,
                'mail_backgroundcdn' => $mailBackgroundCdn,
                'mail_sitelogo' => $mailLogo,
                'mail_sitelogocdn' => $mailLogoCdn,
            ])->with([
                'success' => Session::pull('success_message'),
                'error_message' => Session::pull('error_message')
            ]);


}


public function addEmailSettings(Request $request)
{

 $request->validate([
        'smtp_perfer'  => 'required',
        'sender_email' => 'required|email',
        'sender_name'  => 'required|string',

        'smtp_hname' => 'required_if:smtp_perfer,1',
        'smtp_port'  => 'required_if:smtp_perfer,1',
        'smtp_user'  => 'required_if:smtp_perfer,1',
        'smtp_pass'  => 'required_if:smtp_perfer,1',
        'mailjet_public_key'  => 'required_if:smtp_perfer,4|string',
        'mailjet_private_key' => 'required_if:smtp_perfer,4|string',
    ]);

        // Admin Activity Log
    MAdminActivityLog::getAdminActivity($request, 'Add Email Setting');


            // Add Email Settings
        $saved = MEmailSettings::addEmailSettings($request);

        if ($saved) {
            return redirect()
                ->route('viewemailsettings')
                ->with('success', 'SMTP Mail has Updated.');
        }

        return redirect()
            ->back()
            ->with('error_message', 'SMTP Mail has not Updated.');

}


public function addEmailGeneralSettings(Request $request)
{

        MEmailSettings::addEmailGeneralSettings($request);


        return redirect()->route('viewemailsettings') // use your named route
                         ->with('success', 'Email settings added successfully.');
}



public function editEmail(Request $request, $id, $lid)
{
    $errval = MEmailSettings::getEditEmailDetails($id, $lid);

    if (!$errval) {
        abort(404);
    }

    $mail_name = MEmailSettings::getMailName($id);
    $previewmail_content = MEmailSettings::getPreviewMailContent($errval->mail_content);

    return view('factories.editemail', [
        'mail' => $errval,
        'mail_lang' => $lid,
        'errval' => $errval,
        'mail_name' => $mail_name,
        'previewmail_content' => $previewmail_content
    ]);
}

public function updateEmail(Request $request, $mail_id, $mail_lang)
{
    try {
        MEmailSettings::updateEmail($request, $mail_id, $mail_lang);

        return redirect()
            ->route('editemail.edit', [$mail_id, $mail_lang]);


    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error_message', $e->getMessage());
    }
}

}

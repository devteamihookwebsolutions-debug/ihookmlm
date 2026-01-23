<?php

/**
 * This class contains public functions related to MEmailSettings
 *
 * @package         MEmailSettings
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Factories;
use Admin\App\Display\Factories\DEmailSettings;
use Illuminate\Support\Facades\DB;
use Admin\App\Models\Member\SmtpSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

use Exception;


class MEmailSettings
{
public static function getEmailSettings()
{
    $prefix = config('services.ihook.prefix');

    $records= DB::table($prefix . '_smtp_settings_table')
        ->where('activated_mail_send_status', 1)
        ->first();

    // dd($records);
    return $records;


}

public static function getENotificationSettings()
{
    $prefix = config('services.ihook.prefix');

    // -----------------------------
    // 1 Get mail templates
    // -----------------------------
    $records = DB::table($prefix . '_mailtemplates_table')
        ->select('mail_id', 'mail_name')
        ->where('mail_name', '!=', '')
        ->where('mail_default_name', '!=', 'mail_send_otp')
        ->groupBy('mail_default_name', 'mail_id', 'mail_name')
        ->orderBy('mail_id', 'ASC')
        ->get();
        // dd($records);

    // -----------------------------
    // 2 Count total records
    // -----------------------------
    $iTotal = DB::table($prefix . '_mailtemplates_table')
        ->where('mail_name', '!=', '')
        ->where('mail_default_name', '!=', 'mail_send_otp')
        ->distinct('mail_id')
        ->count('mail_id');

    // -----------------------------
    // 3 Get languages
    // -----------------------------
    $recordsLang = DB::table($prefix . '_language_table')
        ->orderBy('lang_id', 'ASC')
        ->get();

    // -----------------------------
    // 4 Return formatted response
    // -----------------------------
    return DEmailSettings::getENotificationSettings(
        $records,
        $iTotal,
        $recordsLang
    );
}

public static function addEmailSettings(Request $request)
{
    Log::info('Email Settings Request:', $request->all());

    $smtpPerfer = (string) $request->input('smtp_perfer', '0');

    if (!in_array($smtpPerfer, ['0', '1', '2', '3', '4', '5'])) {
        $smtpPerfer = '0';
    }

    $data = [
        'sender_email' => $request->input('sender_email'),
        'sender_name'  => $request->input('sender_name'),
        'smtp_perfer'  => $smtpPerfer,
        'activated_mail_send_status' => 1,
    ];

    // SMTP (Gmail / custom)
    if ($smtpPerfer === '1') {
        $data['smtp_hname'] = $request->input('smtp_hname');
        $data['smtp_port']  = $request->input('smtp_port');
        $data['smtp_user']  = $request->input('smtp_user');
        $data['smtp_pass']  = $request->input('smtp_pass');
    }

    // Mailjet
    if ($smtpPerfer === '4') {

        $data['mailjet_public_key']  = $request->input('mailjet_public_key');
        $data['mailjet_private_key'] = $request->input('mailjet_private_key');
    }

    // Find active record
    $smtp = SmtpSetting::where('activated_mail_send_status', 1)->first();

    if ($smtp) {
        $smtp->update($data);   // UPDATE
    } else {
        SmtpSetting::create($data); // INSERT
    }

    return true;
}

public static function addEmailGeneralSettings(Request $request)
{
    try {
      // Mail background
        if ($request->hasFile('mail_background')) {
            $file = $request->file('mail_background');
            $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/mail_background', $filename, 'public');
            $path = asset('storage/' . $path);
        } else {
            $path = $request->input('hidden_mail_background');
        }

        // Site logo
        if ($request->hasFile('mail_sitelogo')) {
            $file = $request->file('mail_sitelogo');
            $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('uploads/mail_sitelogo', $filename, 'public');
            $logoPath = asset('storage/' . $logoPath);
        } else {
            $logoPath = $request->input('hidden_mail_sitelogo');
        }


        // 3 Update other settings
        $exceptFields = ['_token', 'mail_background', 'mail_sitelogo', 'hidden_mail_background', 'hidden_mail_sitelogo'];
        foreach ($request->except($exceptFields) as $key => $value) {
            SiteSetting::updateOrCreate(
                ['sitesettings_name' => $key],
                ['sitesettings_value' => $value]
            );
        }

        // 4 Update mail background and site logo
        SiteSetting::updateOrCreate(
            ['sitesettings_name' => 'mail_background'],
            ['sitesettings_value' => $path]
        );

        SiteSetting::updateOrCreate(
            ['sitesettings_name' => 'mail_sitelogo'],
            ['sitesettings_value' => $logoPath]
        );

        Session::flash('success', __('General Settings has been updated'));
        return redirect()->route('emailsettings.view');

    } catch (\Exception $e) {
        Session::flash('error', $e->getMessage());
        return redirect()->route('emailsettings.add');
    }
}
public static function getEditEmailDetails($id, $lid)
{
    $prefix = config('services.ihook.prefix');

    // Convert lid to INT
    $lid = (int) $lid;

    /* -----------------------------
     | 1. Get base template by ID
     * ----------------------------- */
    $mailTemplate = DB::table($prefix.'_mailtemplates_table')
        ->where('mail_id', $id)
        ->first();

    if (!$mailTemplate) {
        throw new \Exception('Mail template not found.');
    }

    $mail_default_name = trim($mailTemplate->mail_default_name);

    /* -----------------------------
     | 2. Get language-specific record
     * ----------------------------- */
    $record = DB::table($prefix.'_mailtemplates_table')
        ->where('mail_default_name', $mail_default_name)
        ->where('mail_lang', $lid)
        ->first();

    /* -----------------------------
     | 3. Fallback to default language
     * ----------------------------- */
    if (!$record) {
        $record = DB::table($prefix.'_mailtemplates_table')
            ->where('mail_default_name', $mail_default_name)
            ->where('mail_lang', 1)
            ->first();
    }

    if (!$record) {
        throw new \Exception('Mail template for selected language not found.');
    }

    return $record;
}

public static function getMailName($mail_id)
{
    $prefix = config('services.ihook.prefix');

    if (!$mail_id) {
        throw new \Exception('Mail ID is required.');
    }

    $record = DB::table($prefix.'_mailtemplates_table')
                ->select('mail_name')
                ->where('mail_id', $mail_id)
                ->first();

    if (!$record) {
        throw new \Exception('Mail template not found.');
    }

    return $record->mail_name;
}


 public static function getPreviewMailContent($message)
    {
      $prefix = config('services.ihook.prefix');
        // dd($message);
        $siteSettings = session('site_settings');

        $site_logo   = $siteSettings['site_logo'] ?? '';
        $copyright   = $siteSettings['site_footer_content'] ?? '';
        $site_name   = $siteSettings['site_name'] ?? '';

        $base_url   = config('app.url');
        $cdnasset   = config('services.cdn.asset_url');
        $cdnupload  = config('services.cdn.upload_url');


        $admin_email_id = DB::table($prefix.'_sitesettings_table')
            ->where('sitesettings_name', 'admin_mail_id')
            ->value('sitesettings_value');

        $company_address = DB::table($prefix.'_sitesettings_table')
            ->where('sitesettings_name', 'company_address')
            ->value('sitesettings_value');


        $settings = DB::table($prefix .'_sitesettings_table')
            ->whereIn('sitesettings_name', [
                'facebooklinkurl',
                'googlelinkurl',
                'instalinkurl',
                'linkedinlinkurl',
                'mail_background',
                'mail_sitelogo',
                'twitterlinkurl',
            ])
            ->pluck('sitesettings_value', 'sitesettings_name');

        $facebook   = $cdnasset . '/assets/img/emailicon/facebook.png';
        $twitter    = $cdnasset . '/assets/img/emailicon/twitter.png';
        $google     = $cdnasset . '/assets/img/emailicon/google.png';
        $linkedin   = $cdnasset . '/assets/img/emailicon/linkedin.png';
        $instagram  = $cdnasset . '/assets/img/emailicon/instagram.png';
        $person     = $cdnasset . '/assets/img/emailicon/person.png';
        $checkwhite = $cdnasset . '/assets/img/emailicon/checkwhite.png';
        $checkblue  = $cdnasset . '/assets/img/emailicon/checkblue.png';
        $keylock    = $cdnasset . '/assets/img/emailicon/keylock.png';

        $site_logo       = self::cloudFront($settings['mail_sitelogo'] ?? $site_logo);
        $site_background = self::cloudFront($settings['mail_background'] ?? '');


        $replace = [
            '[facebook]'          => $facebook,
            '[twitter]'           => $twitter,
            '[google]'            => $google,
            '[instagram]'         => $instagram,
            '[linkedin]'          => $linkedin,
            '[site_logo]'         => $site_logo,
            '[copyrigh]'          => $copyright,
            '[companyaddress]'    => $company_address,
            '[checkwhite]'        => $checkwhite,
            '[checkblue]'         => $checkblue,
            '[person]'            => $person,
            '[keylock]'           => $keylock,
            '[site_name]'         => $site_name,
            '[site_background]'   => $site_background,
            '[facebooklinkurl]'   => $settings['facebooklinkurl'] ?? '',
            '[twitterlinkurl]'    => $settings['twitterlinkurl'] ?? '',
            '[linkedinlinkurl]'   => $settings['linkedinlinkurl'] ?? '',
            '[instalinkurl]'      => $settings['instalinkurl'] ?? '',
            '[googlelinkurl]'     => $settings['googlelinkurl'] ?? '',
        ];

        return str_replace(array_keys($replace), array_values($replace), $message);
    }

    private static function cloudFront($path)
    {
        if (!$path) {
            return '';
        }

        return rtrim(config('services.cdn.cloudfront_url'), '/') . '/' . ltrim($path, '/');
    }


// public static function updateEmail(Request $request, $mail_id, $mail_lang)
// {
//     $prefix = config('services.ihook.prefix');

//     $mail_status = $request->mail_status == '1' ? 1 : 0;
//     $mail_content = trim($request->message_content);

//     // Get base mail template
//     $mail = DB::table($prefix.'_mailtemplates_table')
//         ->where('mail_id', $mail_id)
//         ->first();

//     if (!$mail) {
//         return back()->with('error_message', __('Mail template not found'));
//     }

//     $mail_default_name = $mail->mail_default_name;
//     $mail_for = $mail->mail_for ?? 'general';

//     // Common update data
//     $data = [
//         'mail_from'      => trim($request->mail_from),
//         'mail_from_name' => trim($request->mail_from_name),
//         'mail_subject'   => trim($request->mail_subject),
//         'mail_content'   => $mail_content,
//         'mail_status'    => $mail_status,
//         'modified_at'    => now(),
//         'modified_by'    => auth()->id() ?? 0,
//         'mail_for'       => $mail_for,
//     ];

//     /**
//      * UPDATE ONLY (no insert)
//      */
//     $updateOnly = function ($lang_id) use ($prefix, $mail_default_name, $data) {
//         return DB::table($prefix.'_mailtemplates_table')
//             ->where('mail_default_name', trim($mail_default_name))
//             ->where('mail_lang', $lang_id)
//             ->update($data); // returns affected rows
//     };

//     // ============================
//     // Single language update
//     // ============================
//     if ($mail_lang != 0) {

//         $updated = $updateOnly($mail_lang);
//         dd($updated);

//         if ($updated > 0) {
//             return back()->with(
//                 'success',
//                 __('Mail content updated for selected language')
//             );
//         }

//         return back()->with(
//             'error_message',
//             __('Record not found for selected language')
//         );
//     }

//     // ============================
//     // All languages update
//     // ============================
//     $languages = DB::table($prefix.'_language_table')
//         ->orderBy('lang_id')
//         ->pluck('lang_id');

//     $anyUpdated = false;

//     foreach ($languages as $lang_id) {
//         if ($updateOnly($lang_id) > 0) {
//             $anyUpdated = true;
//         }
//     }

//     if ($anyUpdated) {
//         return back()->with(
//             'success',
//             __('Mail content updated for existing languages')
//         );
//     }

//     return back()->with(
//         'error_message',
//         __('No existing records found to update')
//     );
// }


public static function updateEmail(Request $request, $mail_id, $mail_lang)
{
    $prefix = config('services.ihook.prefix');

    // Get the base mail template
    $mail = DB::table($prefix.'_mailtemplates_table')
        ->where('mail_id', $mail_id)
        ->first();

    if (!$mail) {
        return back()->with('error_message', __('Mail template not found'));
    }

    $now = now();

    // Data to update
    $data = [
        'mail_from'      => trim($request->mail_from),
        'mail_from_name' => trim($request->mail_from_name),
        'mail_subject'   => trim($request->mail_subject),
        'mail_content'   => trim($request->message_content),
        'mail_status'    => $request->mail_status == '1' ? 1 : 0,
        'mail_for'       => $mail->mail_for ?? 'general',
        'modified_by' => auth()->check() ? auth()->user()->members_id : 0,
        'modified_at'    => $now,
    ];

    // SINGLE LANGUAGE UPDATE
    if ($mail_lang != 0) {
        $lang_id = (int) $mail_lang;

        // Update only if the record exists
        $updated = DB::table($prefix.'_mailtemplates_table')
            ->where('mail_default_name', trim($mail->mail_default_name))
            ->where('mail_lang', $lang_id)
            ->update($data);

        if ($updated) {
            return back()->with('success', __('Mail content updated successfully'));
        } else {
            // Record for this language does NOT exist
            return back()->with('error_message', __('Record not found for selected language'));
        }
    }

    // UPDATE ALL EXISTING LANGUAGES
    $updated = DB::table($prefix.'_mailtemplates_table')
        ->where('mail_default_name', $mail->mail_default_name)
        ->update($data);

    if ($updated) {
        return back()->with('success', __('Mail content updated for all existing languages'));
    }

    return back()->with('error_message', __('No records found to update'));
}





}

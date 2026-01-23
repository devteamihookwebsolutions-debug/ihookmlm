<?php

/**
 * This class contains public functions related to MSendMail
 *
 * @package         MSendMail
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

namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\DB;

class MSendMail
{
    /**
     * Send email to user
     */
    public static function send(
        object $recordsMail,
        string $to,
        string $message,
        ?string $attachment = null,
        ?string $username = null
    ): bool {

        // Load mail assets (OLD CODE MERGED HERE)
        $mailAssets = self::loadMailAssets();


        // Replace template placeholders
        $message = self::applyTemplateVariables($message, $mailAssets);

        // SMTP settings
        $prefix = config('services.ihook.prefix');

        $smtpSettings = DB::table($prefix . '_smtp_settings_table')
            ->where('activated_mail_send_status', 1)
            ->first();

        $smtpPrefer = (int) ($smtpSettings->smtp_perfer ?? 0);

        // Send primary email
        self::sendByProvider(
            $smtpPrefer,
            $smtpSettings,
            $recordsMail,
            $to,
            $message,
            $attachment,
            $username
        );

        return true;
    }

    /**
     * Load site settings & assets (Converted from OLD PHP code)
     */
    // protected static function loadMailAssets(): array
    // {
    //     $prefix = config('services.ihook.prefix');
    //     $cdn = config('services.cdn.cloudfront');
    //     // dd($cdn);

    //     $settings = DB::table($prefix . '_sitesettings_table')
    //         ->pluck('sitesettings_value', 'sitesettings_name');
    //     // dd($settings);
    //     return [
    //         // Site details
    //         'site_name'        => $settings['site_name'] ?? '',
    //         'companyaddress'   => $settings['company_address'] ?? '',
    //         'copyrigh'         => $settings['site_footer_content'] ?? '',

    //         // Logos & background
    //         'site_logo'        => $cdn . ($settings['mail_sitelogo'] ?? $settings['site_logo'] ?? ''),
    //         'site_background'  => $cdn . ($settings['mail_background'] ?? ''),

    //         // Social icons
    //         'facebook'   => asset('assets/img/emailicon/facebook.png'),
    //         'twitter'    => asset('assets/img/emailicon/twitter.png'),
    //         'google'     => asset('assets/img/emailicon/google.png'),
    //         'linkedin'   => asset('assets/img/emailicon/linkedin.png'),
    //         'instagram'  => asset('assets/img/emailicon/instagram.png'),
    //         'person'     => asset('assets/img/emailicon/person.png'),
    //         'checkwhite' => asset('assets/img/emailicon/checkwhite.png'),
    //         'checkblue'  => asset('assets/img/emailicon/checkblue.png'),
    //         'keylock'    => asset('assets/img/emailicon/keylock.png'),

    //         // Social links
    //         'facebooklinkurl'  => $settings['facebooklinkurl'] ?? '',
    //         'twitterlinkurl'   => $settings['twitterlinkurl'] ?? '',
    //         'linkedinlinkurl'  => $settings['linkedinlinkurl'] ?? '',
    //         'instagramlinkurl' => $settings['instalinkurl'] ?? '',
    //         'googlelinkurl'    => $settings['googlelinkurl'] ?? '',
    //     ];
    // }
protected static function loadMailAssets(): array
{
    $prefix = config('services.ihook.prefix');
    $cdn = config('services.cdn.cloudfront', asset('')); // fallback to base URL
    // dd($cdn);
    $settings = DB::table($prefix . '_sitesettings_table')
        ->pluck('sitesettings_value', 'sitesettings_name');

    // Ensure full URLs for site logos
    $siteLogo = $settings['mail_sitelogo'] ?? $settings['site_logo'] ?? '';
    if (!filter_var($siteLogo, FILTER_VALIDATE_URL)) {
        $siteLogo = rtrim($cdn, '/') . '/' . ltrim($siteLogo, '/');
    }

    $siteBackground = $settings['mail_background'] ?? '';
    if (!filter_var($siteBackground, FILTER_VALIDATE_URL)) {
        $siteBackground = rtrim($cdn, '/') . '/' . ltrim($siteBackground, '/');
    }

    $baseUrl = rtrim($cdn, '/');
    // dd($baseUrl);
    return [
        // Site details
        'site_name'        => $settings['site_name'] ?? '',
        'companyaddress'   => $settings['company_address'] ?? '',
        'copyright'        => $settings['site_footer_content'] ?? '',

        // Logos & background
        'site_logo'        => $siteLogo,
        'site_background'  => $siteBackground,

        // Social icons
        'facebook'   => $baseUrl . '/assets/img/emailicon/facebook.png',
        'twitter'    => $baseUrl . '/assets/img/emailicon/twitter.png',
        'google'     => $baseUrl . '/assets/img/emailicon/google.png',
        'linkedin'   => $baseUrl . '/assets/img/emailicon/linkedin.png',
        'instagram'  => $baseUrl . '/assets/img/emailicon/instagram.png',
        'person'     => $baseUrl . '/assets/img/emailicon/person.png',
        'checkwhite' => $baseUrl . '/assets/img/emailicon/checkwhite.png',
        'checkblue'  => $baseUrl . '/assets/img/emailicon/checkblue.png',
        'keylock'    => $baseUrl . '/assets/img/emailicon/keylock.png',

        // Social links
        'facebooklinkurl'  => $settings['facebooklinkurl'] ?? '',
        'twitterlinkurl'   => $settings['twitterlinkurl'] ?? '',
        'linkedinlinkurl'  => $settings['linkedinlinkurl'] ?? '',
        'instagramlinkurl' => $settings['instalinkurl'] ?? '',
        'googlelinkurl'    => $settings['googlelinkurl'] ?? '',
    ];
}

    /**
     * Replace placeholders in email template
     */
    protected static function applyTemplateVariables(string $message, array $data): string
    {
        foreach ($data as $key => $value) {
            $message = str_replace('[' . $key . ']', $value, $message);
        }
        return $message;
    }

    /**
     * Send mail using selected provider
     */
    protected static function sendByProvider(
        int $smtpPrefer,
        $smtpSettings,
        object $recordsMail,
        string $to,
        string $message,
        ?string $attachment,
        ?string $username
    ): void {

        if ($smtpPrefer == 5) { // Brevo
            MBrevoEmail::sendMailBrevo(
                $recordsMail->mail_from,
                $to,
                $recordsMail->mail_subject,
                $message,
                $recordsMail->mail_from_name,
                $username,
                $attachment
            );

        } elseif ($smtpPrefer == 3) { // MailChimp
            MMailChimp::sendMailChimp(
                $recordsMail->mail_from,
                $to,
                $recordsMail->mail_subject,
                $message,
                $recordsMail->mail_from_name,
                $attachment
            );

        } elseif ($smtpPrefer == 2) { // SendGrid
            MSendGrid::sendMailSendGrid(
                $recordsMail->mail_from,
                $to,
                $recordsMail->mail_subject,
                $message,
                $recordsMail->mail_from_name,
                $attachment
            );

        } elseif ($smtpPrefer == 1) { // SMTP
            MSmtp::sendSMTP(
                (array) $smtpSettings,
                $recordsMail->mail_from,
                $to,
                $recordsMail->mail_subject,
                $message,
                $recordsMail->mail_from_name,
                $attachment
            );

        } else { // PHP mail fallback
            $headers  = "From: {$recordsMail->mail_from}\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            mail($to, $recordsMail->mail_subject, $message, $headers);
        }

        // Log mail
        self::logMail(
            $recordsMail->mail_from,
            $to,
            $recordsMail->mail_subject,
            $message,
            $recordsMail->mail_default_name ?? 'unknown'
        );
    }

    /**
     * Log mail to database
     */
     protected static function logMail(
        string $from,
        string $to,
        string $subject,
        string $message,
        string $mailTemplateName
    ): void {

        $prefix = config('services.ihook.prefix');

        $memberId = DB::table($prefix . '_members_table')
            ->where('members_email', $to)
            ->value('members_id');

        DB::table($prefix . '_mailtemplate_reports')->insert([
            'member_id'    => $memberId,
            'mail_from'    => $from,
            'mail_to'      => $to,
            'mail_subject' => $subject,
            'mail_content' => $message,
            'type'         => $mailTemplateName, // store template name
            'status'       => 1,
            'delivered_on' => now(),
        ]);
    }
}

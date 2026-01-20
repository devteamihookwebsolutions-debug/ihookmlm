<?php

/**
 * This class contains public functions related to MSendGridBulkMail
 *
 * @package         MSendGridBulkMail
 * @category        Model
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
namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\DB;

class MSendGridBulkMail
{
    public static function sendMailSendGrid(
        string $mail_from,
        array  $mailto,
        string $mail_subject,
        string $message,
        string $mail_from_name = '',
        string $attachment = null
    ): bool {
      $prefix = config('services.ihook.prefix');
        // Get SendGrid API key
        $apiKey = DB::table($prefix.'_thirdpartyintegration')
            ->where('metakey', 'sendgrid_apikey')
            ->where('module', 'sendgrid')
            ->value('metavalue');

        if (!$apiKey) {
            throw new \Exception('SendGrid API key not found');
        }


        $emails = array_unique(array_column($mailto, 'email'));
        $bcc = [];

        foreach ($emails as $email) {
            $bcc[] = ['email' => $email];
        }


        $content = html_entity_decode($message);
        $content = self::minimizeCSSContent($content);
        $content = self::compressCode($content);
        $content = str_replace('"', "'", $content);

        $payload = [
            'personalizations' => [
                [
                    'to' => [
                        ['email' => $mail_from, 'name' => $mail_from_name]
                    ],
                    'bcc' => $bcc,
                    'subject' => $mail_subject,
                ]
            ],
            'from' => [
                'email' => $mail_from,
                'name'  => $mail_from_name,
            ],
            'content' => [
                [
                    'type'  => 'text/html',
                    'value' => $content,
                ]
            ],
        ];

        //Attachment
        if ($attachment && file_exists($attachment)) {
            $payload['attachments'][] = [
                'content'  => base64_encode(file_get_contents($attachment)),
                'type'     => mime_content_type($attachment),
                'filename' => basename($attachment),
            ];
        }


        $ch = curl_init('https://api.sendgrid.com/v3/mail/send');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
        ]);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return true;
    }

    // Helpers
    public static function compressCode($code)
    {
        return preg_replace(
            ['/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s','/<!--(.|\s)*?-->/'],
            ['>','<','\\1'],
            $code
        );
    }

    public static function minimizeCSSContent($css)
    {
        $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css);
        $css = preg_replace('/\s{2,}/', ' ', $css);
        $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
        $css = preg_replace('/;}/', '}', $css);
        return $css;
    }
}

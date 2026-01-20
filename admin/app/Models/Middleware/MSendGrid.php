<?php

/**
 * This class contains public functions related to MSendGrid
 *
 * @package         MSendGrid
 * @category        Model
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

namespace Admin\App\Models\Middleware;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class MSendGrid
{

    /**
     * Send mail using SendGrid
     * @param string $mail_from
     * @param string $mailto
     * @param string $mail_subject
     * @param string $message
     * @param string|null $mail_from_name
     * @param string|null $attachment
     * @param string|null $recipient_name
     * @return bool
     */

public static function sendMailSendGrid(
    string $mail_from,
    string $mailto,
    string $mail_subject,
    string $message,
    ?string $mail_from_name = null,
    ?string $attachment = null,
    ?string $recipient_name = null
): bool {

    $prefix = config('services.ihook.prefix');

    $record = DB::table($prefix . '_thirdpartyintegration')
        ->where('metakey', 'sendgrid_apikey')
        ->where('module', 'sendgrid')
        ->first();

    if (!$record || empty($mail_from)) {
        Log::error('SendGrid error: Missing API key or From email');
        return false;
    }

    $apiKey = $record->metavalue;

    $payload = [
     'personalizations' => [[
            'to' => [[
                'email' => $mailto,
                'name'  => $recipient_name ?? ''
            ]],
            'subject' => $mail_subject
        ]],
        'from' => [
            'email' => $mail_from, // MUST be verified in SendGrid
            'name'  => $mail_from_name ?? 'MLM Software'
        ],
        'content' => [
        [
            'type' => 'text/plain',
            'value' => strip_tags($message)
        ],
        [
            'type' => 'text/html',
            'value' => html_entity_decode($message)
        ]]
    ];
    // dd($payload);
    try {
        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->asJson()
            ->post('https://api.sendgrid.com/v3/mail/send', $payload);

        // Always log response for debugging
        Log::info('SendGrid response', [
            'status' => $response->status(),
            'body'   => $response->body(),
            'payload'=> $payload
        ]);

        if ($response->status() === 202) {
            return true;
        }

        Log::error('SendGrid mail failed', [
            'status'   => $response->status(),
            'response' => $response->body(),
            'payload'  => $payload
        ]);

        return false;

    } catch (\Exception $e) {
        Log::error('SendGrid exception', [
            'error'   => $e->getMessage(),
            'payload' => $payload
        ]);
        return false;
    }

}

    /**
     * Send mail using Mailjet
     *
     * @param string $mail_from
     * @param string $mailto
     * @param string $mail_subject
     * @param string $message
     * @param string|null $mail_from_name
     * @param string|null $attachment
     * @param string|null $recipient_name
     * @return bool
     */
    public static function sendViaMailJet(
        string $mail_from,
        string $mailto,
        string $mail_subject,
        string $message,
        ?string $mail_from_name = null,
        ?string $attachment = null,
        ?string $recipient_name = null
    ): bool {
        $apiKeyPublic = config('services.mailjet.public_key');
        $apiKeyPrivate = config('services.mailjet.private_key');

        $content = html_entity_decode($message);

        $body = [
            'Messages' => [[
                'From' => [
                    'Email' => $mail_from,
                    'Name' => $mail_from_name ?? ''
                ],
                'To' => [[
                    'Email' => $mailto,
                    'Name' => $recipient_name ?? ''
                ]],
                'Subject' => $mail_subject,
                'HTMLPart' => $content,
            ]]
        ];

        // Handle attachment
        if ($attachment && file_exists($attachment)) {
            $filename = basename($attachment);
            $fileEncoded = base64_encode(file_get_contents($attachment));
            $body['Messages'][0]['Attachments'] = [[
                'ContentType' => mime_content_type($attachment),
                'Filename' => $filename,
                'Base64Content' => $fileEncoded
            ]];
        }
        $response = Http::withBasicAuth($apiKeyPublic, $apiKeyPrivate)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://api.mailjet.com/v3.1/send', $body);

        return $response->successful();
    }
}


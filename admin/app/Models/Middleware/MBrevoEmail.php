<?php

/**
 * This class contains public functions related to MBrevoEmail
 *
 * @package         MBrevoEmail
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
use Illuminate\Support\Facades\Http;

class MBrevoEmail
{
    /**
     * Send mail using Brevo (Sendinblue)
     */
    public static function sendMailBrevo(
        string $mailFrom,
        string $mailTo,
        string $mailSubject,
        string $message,
        string $mailFromName,
        ?string $membersUsername = null,
        ?string $attachment = null
    ): bool {

        //  Get API key from DB
        $prefix = config('services.ihook.prefix');
        // dd($prefix);
        $record = DB::table($prefix . '_thirdpartyintegration')
            ->where('module', 'brevo')
            ->where('metakey', 'brevo_apikey')
            ->first();
        //  dd($record);
        if (!$record) {
            throw new \Exception('Brevo API key not found');
        }

        $apiKey  = $record->metavalue;
        $content = html_entity_decode($message);

        //  Base email body
        $body = [
            "sender" => [
                "name"  => $mailFromName,
                "email" => $mailFrom,
            ],
            "to" => [
                [
                    "email" => $mailTo,
                    "name"  => $membersUsername,
                ],
            ],
            "subject"     => $mailSubject,
            "htmlContent" => $content,
        ];

        //  Attachment handling (optional)
        if (!empty($attachment) && file_exists($attachment)) {

            $filename = basename($attachment);
            $fileData = base64_encode(file_get_contents($attachment));

            $body['attachment'] = [
                [
                    'content' => $fileData,
                    'name'    => $filename,
                ],
            ];
        }

        //  Send email using Laravel HTTP client
 $response = Http::withHeaders([
    'accept'       => 'application/json',
    'api-key'      => $apiKey,   //  IMPORTANT
    'content-type' => 'application/json',
])
->timeout(60)
->post('https://api.sendinblue.com/v3/smtp/email', $body);

// dd($response->status(), $response->body());

        return $response->successful();
    }
}

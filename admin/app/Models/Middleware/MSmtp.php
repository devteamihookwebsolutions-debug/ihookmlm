<?php

/**
 * This class contains public functions related to MSmtp
 *
 * @package         MSmtp
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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class MSmtp
{
    /**
     * Send email using SMTP
     */
    public static function sendSMTP(
        array $records,
        string $mail_from,
        string $mailto,
        string $mail_subject,
        string $message,
        ?string $mail_from_name = null,
        ?string $attachment = null
    ): bool {

        //  Test log (confirm function reached)
        Log::channel('smtp')->debug('SMTP function reached');

        $mail = new PHPMailer(true);

        try {

            // SMTP CONFIG
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $records['smtp_user'];     // Gmail ID
            $mail->Password   = $records['smtp_pass'];     // Gmail APP PASSWORD
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // SMTP DEBUG LOG
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = function ($str, $level) {
                Log::channel('smtp')->debug($str);
            };

            // Encoding
            $mail->CharSet  = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);

            // IMPORTANT: setFrom MUST match smtp_user
            $mail->setFrom(
                $records['smtp_user'],
                $mail_from_name ?? 'Admin'
            );

            // TO ADDRESS
            $mail->addAddress($mailto);

            // EMAIL CONTENT
            $mail->Subject = $mail_subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);

            // SEND
            $mail->send();

            Log::channel('smtp')->debug('SMTP mail sent successfully');
            return true;

        } catch (Exception $e) {

            Log::channel('smtp')->error('SMTP ERROR: ' . $mail->ErrorInfo);
            return false;
        }
    }
}

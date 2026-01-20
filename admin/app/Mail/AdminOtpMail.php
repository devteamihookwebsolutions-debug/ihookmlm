<?php

/**
 * This class contains public functions related to AdminOtpMail
 *
 * @package         AdminOtpMail
 * @category        Mail
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

namespace Admin\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $username;

    public function __construct($otp, $username)
    {
        $this->otp = $otp;
        $this->username = $username;
    }

    public function build()
    {
        return $this->subject('Admin OTP Code')
                  ->view('emails.admin-otp');

    }
}

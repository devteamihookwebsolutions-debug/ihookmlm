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

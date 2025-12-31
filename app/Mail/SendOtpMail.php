<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userName;

    // Constructor receives OTP and user name
    public function __construct($otp, $userName)
    {
        $this->otp = $otp;
        $this->userName = $userName;
    }

    // Build the email
    public function build()
    {
        return $this->subject('Your OTP Code')
                    ->view('emails.sendOtp'); // Blade view file
    }
}

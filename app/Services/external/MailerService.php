<?php

namespace App\Services\external;

use App\Services\external\mail\MailerSendService;
use Mail;

use App\Models\User;

class MailerService
{
    private string $ccEmail;
    public function __construct()
    {
        $this->ccEmail = env('MAIL_FROM_ADDRESS');

    }

    public function sendWelcomeMail(User $user)
    {
        $mailer = new MailerSendService('Welcome to our platform! ' . $user->name);


        Mail::to($user->email)
            //->cc($this->ccEmail)
            ->send($mailer);
    }
}

<?php

namespace App\Services\external;

use App\Services\external\mail\MailerSendService;
use Mail;

use App\Models\User;

class MailerService
{
    public function sendWelcomeMail(User $user)
    {
        $mailer = new MailerSendService('Welcome to our platform! ' . $user->name);
        Mail::to($user->email)
            ->send($mailer);
    }
}

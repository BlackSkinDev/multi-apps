<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Jobs\SendEmailsJob;
use App\Mail\EmailVerificationMail;
use App\Mail\MagicLoginMail;
use App\Mail\PasswordResetMail;
use App\Mail\WelcomeEmail;
use App\Models\User;

class EmailService
{

    public function __construct() {

    }


    /**
     * Send email verification mail to user
     * @param User $user
     * @param $token
     */
    public function sendEmailVerificationLink(User $user,$token): void
    {
        $data = [
            'user'  =>$user,
            'token' =>$token
        ];

        dispatch(new SendEmailsJob($user->email,$data,EmailVerificationMail::class));
    }

}

<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Jobs\SendEmailsJob;
use App\Mail\EmailVerificationMail;
use App\Mail\PasswordResetMail;
use App\Mail\WelcomeEmail;
use App\Models\User;

class EmailService
{

    public function __construct(
        IUserRepository $userRepository,

    ) {
        $this->userRepository = $userRepository;
    }


    /**
     * Send Welcome email to user
     * @param User $user
     */
    public function sendWelcomeEmail(User $user): void
    {
        dispatch(new SendEmailsJob($user->email,$user,WelcomeEmail::class));
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

    /**
     * Send password reset link to user
     * @param User $user
     * @param $token
     */
    public function sendPasswordResetLink(User $user,$token): void
    {
        $data = [
            'user'  =>$user,
            'token' =>$token
        ];
        dispatch(new SendEmailsJob($user->email,$data,PasswordResetMail::class));
    }



}

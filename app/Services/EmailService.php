<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Jobs\SendEmailsJob;
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



}

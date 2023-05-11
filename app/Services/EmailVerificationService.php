<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IEmailVerificationTokenRepository;
use App\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class EmailVerificationService
{
    public function __construct(
        IEmailVerificationTokenRepository $emailVerificationTokenRepository,
        EmailService                      $emailService,
        IUserRepository                   $userRepository

    ) {
        $this->emailVerificationTokenRepository = $emailVerificationTokenRepository;
        $this->emailService                     = $emailService;
        $this->userRepository                   = $userRepository;
    }


    /**
     * Send Verification email to user
     * @param string $email
     * @throws ClientErrorException
     */
    public function sendVerificationEmail(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        DB::beginTransaction();

        $email_verification = $this->emailVerificationTokenRepository->create(['user_id'=>$user->id]);

        try {

            $this->emailService->sendEmailVerificationLink($user,$email_verification->token);

            DB::commit();;

        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            throw new ClientErrorException(__('validation.error_occurred'));
        }
    }

    /**
     * Verify user email
     * @param string $token
     * @throws ClientErrorException
     */
    public function verifyEmail(string $token): void
    {

        $email_verification = $this->emailVerificationTokenRepository->findByToken($token);

        if (!$email_verification){
            throw new ClientErrorException("Verification link is invalid.");
        }

        if ($email_verification->expired_at->lt(now())){
            throw new ClientErrorException("Verification link has expired");
        }


        $this->userRepository->verifyEmail($email_verification->user);

        $this->emailVerificationTokenRepository->delete($email_verification);

    }



}

<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IEmailVerificationTokenRepository;
use App\Interfaces\IUserRepository;
use App\Models\EmailVerificationToken;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class EmailVerificationService
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService,) {
        $this->emailService  = $emailService;
    }


    /**
     * Send Verification email to user
     * @param string $email
     * @throws ClientErrorException
     */
    public function sendVerificationEmail(string $email): void
    {
        $user = User::whereEmail($email)->firstorfail();

        DB::beginTransaction();

        $email_verification = EmailVerificationToken::create(['user_id'=>$user->id]);

        try {

            $this->emailService->sendEmailVerificationLink($user,$email_verification->token);

            DB::commit();

        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            throw new ClientErrorException('Unable to send email verification link');
        }
    }

    /**
     * Verify user email
     * @param string $token
     * @throws ClientErrorException
     */
    public function verifyEmail(string $token): void
    {

        $email_verification = EmailVerificationToken::whereToken($token)->first();

        if ($email_verification->expired_at->lt(now())){
            throw new ClientErrorException("Verification link has expired");
        }

        $user = $email_verification->user;

        $user->update(['email_verified_at' => now()]);

        $email_verification->delete();

    }



}

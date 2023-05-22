<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IPasswordResetTokenRepository;
use App\Interfaces\IUserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasswordResetService
{

    public function __construct(
        IPasswordResetTokenRepository     $passwordResetTokenRepository,
        EmailService                      $emailService,
        IUserRepository                   $userRepository

    ) {
        $this->passwordResetTokenRepository     = $passwordResetTokenRepository;
        $this->emailService                     = $emailService;
        $this->userRepository                   = $userRepository;
    }


    /**
     * Send Password Reset Link to user
     * @param string $email
     * @throws ClientErrorException
     */
    public function sendPasswordResetEmail(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        DB::beginTransaction();

        $password_verification = $this->passwordResetTokenRepository->create(['email'=>$user->email]);

        try {

            $this->emailService->sendPasswordResetLink($user,$password_verification->token);

            DB::commit();;

        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            throw new ClientErrorException(__('validation.error_occurred'));
        }
    }

    /**
     * Reset user password
     * @param array $data
     * @throws ClientErrorException
     */
    public function updatePassword(array $data): void
    {

        $password_reset_token = $this->passwordResetTokenRepository->findByToken($data['token']);


        if ($password_reset_token->expired_at->lt(now())){
            throw new ClientErrorException("Password reset link has expired");
        }

        $user = $this->userRepository->findByEmail($password_reset_token->email);

        $this->userRepository->update($user,['password'=>$data['new_password']]);

        $this->passwordResetTokenRepository->delete($password_reset_token);

    }

    /**
     * Change user password
     * @param array $data
     * @throws ClientErrorException
     */
    public function changePassword(array $data): void
    {
        $user = auth()->user();

        if (!password_verify($data['old_password'],$user->password)){
            throw new ClientErrorException("Old password incorrect");
        }
        $this->userRepository->update($user,['password'=>$data['new_password']]);
    }



}

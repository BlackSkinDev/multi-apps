<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IPersonalAccessTokenRepository;
use App\Interfaces\IRefreshTokenRepository;
use App\Interfaces\IUserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;



class AuthService
{

    public function __construct(
        IUserRepository                 $userRepository,
        IRefreshTokenRepository         $refreshTokenRepository,
        IPersonalAccessTokenRepository  $personalAccessTokenRepository,
        EmailService                    $emailService,
        EmailVerificationService        $emailVerificationService,
    ) {
        $this->userRepository                = $userRepository;
        $this->refreshTokenRepository        = $refreshTokenRepository;
        $this->personalAccessTokenRepository = $personalAccessTokenRepository;
        $this->emailService                  = $emailService;
        $this->emailVerificationService      = $emailVerificationService;
    }


    /**
     * Register user
     * @param array $user_data
     * @throws ClientErrorException
     */
    public function register(array $user_data)
    {
        DB::beginTransaction();

        if($user = $this->userRepository->create($user_data)){
            try {

                $this->emailService->sendWelcomeEmail($user);

                DB::commit();;

                return $user;

            } catch (\Exception $e){
                DB::rollBack();
                Log::error($e);
                throw new ClientErrorException(__('validation.error_occurred'));
            }
        }
    }

    /**
     * Login user
     * @param array $request
     * @return array
     * @throws ClientErrorException
     */
    public function login(array $request): array
    {
        $user = $this->userRepository->findByEmail($request['email']);

        if(!$user){
            throw new ClientErrorException('This email is not associated with any account');
        }

        if (! password_verify($request['password'],$user->password)) {
            throw new ClientErrorException('Incorrect password');
        }

        if (!$user->enabled) {
            throw new ClientErrorException('Your account has been deactivated. Contact your admin!');
        }

        if (!$user->email_verified_at) {
            try {
                $this->emailVerificationService->sendVerificationEmail($user->email);
            } catch (\Exception $e){
                Log::error($e);
                throw new Exception(__('validation.error_occurred'));
            }
            throw new ClientErrorException('Please verify your account. A verification link has been sent to your email!');
        }

        $access_token = $this->userRepository->createUserToken($user);


        $cookie = cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);


        $refresh_token = $this->refreshTokenRepository->create(['personal_access_token_id' => $access_token->accessToken->id]);

        return [
            'name'          => $user->name,
            'email'         => $user->email,
            'is_admin'      => (bool)$user->is_admin,
            'refresh_token' => $refresh_token->token,
            'cookie'        => $cookie
        ];
    }



    /**
     * Log out
     */
    public function logout(): void
    {
        auth()->user()->tokens()->delete();
    }

}

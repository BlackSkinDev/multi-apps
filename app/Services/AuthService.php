<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IMagicLinkTokenRepository;
use App\Interfaces\IPersonalAccessTokenRepository;
use App\Interfaces\IRefreshTokenRepository;
use App\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mockery\Exception;



class AuthService
{

    private EmailVerificationService $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService) {
        $this->emailVerificationService      = $emailVerificationService;
    }


    /**
     * Register user
     * @param array $user_data
     * @return User
     * @throws ClientErrorException
     */
    public function register(array $user_data):User
    {
        DB::beginTransaction();

        if($user = User::create($user_data)){
            try {

                $this->emailVerificationService->sendVerificationEmail($user->email);
                DB::commit();;

                return $user;

            } catch (\Exception $e){
                DB::rollBack();
                Log::error($e);
                throw new ClientErrorException('Unable to register user');
            }
        }
    }

    /**
     * Login user with password
     * @param array $request
     * @return array
     * @throws ClientErrorException
     */
    public function loginWithPassword(array $request): array
    {
        $user = User::whereEmail($request['email'])->first();

        if (! password_verify($request['password'],$user->password)) {
            throw new ClientErrorException('Incorrect password!');
        }

        if (!$user->enabled) {
            throw new ClientErrorException('Your account has been deactivated. Contact our support!');
        }

        if (!$user->email_verified_at) {
            try {
                $this->emailVerificationService->sendVerificationEmail($user->email);
            } catch (\Exception $e){
                Log::error($e);
                throw new ClientErrorException($e->getMessage());
            }
            throw new ClientErrorException('Please verify your account. A verification link has been sent to your email!');
        }

        return $this->authenticateUser($user);
    }



    /**
     * Log out
     */
    public function logout(): void
    {
        auth()->user()->tokens()->delete();
    }


    /**
     * @param $user
     * @return array
     */
    public function authenticateUser($user): array
    {

        $token =  $user->createToken("MTL")->plainTextToken;

        return [
            'email' => $user->email,
            'photo' => $user->photo,
            'username' => $user->username,
            'token' => $token,
            'bio' => $user->bio
        ];
    }

}

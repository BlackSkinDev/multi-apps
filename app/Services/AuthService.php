<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Repositories\PersonalAccessTokenRepository;
use App\Repositories\RefreshTokenRepository;
use App\Repositories\UserRepository;
use Illuminate\Cookie\CookieJar;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Cookie;


class AuthService
{

    public function __construct(UserRepository $userRepository,RefreshTokenRepository $refreshTokenRepository,PersonalAccessTokenRepository $personalAccessTokenRepository)
    {
        $this->userRepository                   = $userRepository;
        $this->refreshTokenRepository           = $refreshTokenRepository;
        $this->personalAccessTokenRepository    = $personalAccessTokenRepository;
    }


    /**
     * Register user
     * @param array $user_data
     * @return mixed
     */
    public function register(array $user_data)
    {
        return $this->userRepository->create($user_data);
    }

    /**
     * Login user
     * @param array $request
     * @return array
     * @throws ClientErrorException
     */
    public function login(array $request)
    {
        $user = $this->userRepository->findByEmail($request['email']);

        if(!$user){
            throw new ClientErrorException('This email is not associated with any account');
        }

        if (! password_verify($request['password'],$user->password)) {
            throw new ClientErrorException('Incorrect password');
        }

        $access_token = $user->createToken("auth-token");

        $cookie = cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);

        $refresh_token = $this->refreshTokenRepository->create(['personal_access_token_id' => $access_token->accessToken->id]);

        return [
            'name'          => $user->name,
            'email'         => $user->email,
            'refresh_token' => $refresh_token->token,
            'cookie'        => $cookie
        ];
    }


    /**
     * Refresh access token
     * @param string $token
     * @throws ClientErrorException
     */
    public function refreshToken(string $token): Application|CookieJar|Cookie
    {
        $refresh_token = $this->refreshTokenRepository->findByToken($token);

        if(!$refresh_token){
            throw new ClientErrorException('Invalid refresh token was detected!');
        }

        if($refresh_token->expired_at->lt(now())){
            $refresh_token->clear();
            throw new ClientErrorException('Refresh token has expired!');
        }

        $accessToken =  $this->personalAccessTokenRepository->findById($refresh_token->personal_access_token_id);

        $access_token = $accessToken->user->createToken("auth-token");

        return cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);
    }

    /**
     * Log out
     */
    public function logout(): void
    {
        auth()->user()->tokens()->delete();
    }

}

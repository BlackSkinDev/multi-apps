<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IPersonalAccessTokenRepository;
use App\Interfaces\IRefreshTokenRepository;
use App\Interfaces\IUserRepository;
use Illuminate\Cookie\CookieJar;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshTokenService
{

    public function __construct(
        IUserRepository                 $userRepository,
        IRefreshTokenRepository         $refreshTokenRepository,
        IPersonalAccessTokenRepository  $personalAccessTokenRepository,
    ) {
        $this->userRepository                = $userRepository;
        $this->refreshTokenRepository        = $refreshTokenRepository;
        $this->personalAccessTokenRepository = $personalAccessTokenRepository;
    }

    /**
     * Refresh access token
     * @param string $token
     * @return Application|CookieJar|Cookie
     * @throws ClientErrorException
     */
    public function refreshToken(string $token): Application|CookieJar|Cookie
    {
        $refresh_token = $this->refreshTokenRepository->findByToken($token);

        if(!$refresh_token){
            throw new ClientErrorException('Invalid refresh token was detected!');
        }

        if($refresh_token->expired_at->lt(now())){
            $token_user = $this->personalAccessTokenRepository->fetchUser($refresh_token->personal_access_token_id);
            $this->userRepository->deleteTokens($token_user);
            $this->refreshTokenRepository->delete($refresh_token);
            throw new ClientErrorException('Your session has expired.Login again!');
        }

        $accessToken =  $this->personalAccessTokenRepository->findById($refresh_token->personal_access_token_id);

        $access_token = $accessToken->user->createToken("auth-token");

        return cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);
    }

}

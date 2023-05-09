<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RefreshTokenRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\PersonalAccessToken;
use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    /**
     * Sign up an admin user
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user_data = array_merge($request->validated(),['is_admin'=>1]);
        return httpResponse(true,User::create($user_data));
    }

    /**
     * Sign in
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function login(LoginRequest $request): JsonResponse
    {

        $user = User::whereEmail($request->email)->first();

        if(!$user){
            throw new ClientErrorException('This email is not associated with any account');
        }

        if (! password_verify($request->password,$user->password)) {
            throw new ClientErrorException('Incorrect password');
        }

        $access_token = $user->createToken("auth-token");

        $cookie = cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);

        $refresh_token = RefreshToken::create(['personal_access_token_id' => $access_token->accessToken->id]);

        $data = [
            'name'          => $user->name,
            'email'         => $user->email,
            'refresh_token' => $refresh_token->token,
        ];

        return httpResponse(true,$data)->withCookie($cookie);

    }

    /**
     * Refresh user access token
     * @param RefreshTokenRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {

        $refresh_token = RefreshToken::where('token',$request->refresh_token)->first();

        if(!$refresh_token){
            throw new ClientErrorException('Invalid refresh token was detected!');
        }


        if($refresh_token->expired_at->lt(now())){
            $refresh_token->clear();
            throw new ClientErrorException('Refresh token has expired!');
        }

        $accessToken =  PersonalAccessToken::where('id',$refresh_token->personal_access_token_id)->first();

        $access_token = $accessToken->user->createToken("auth-token");

        $cookie = cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);

        return httpResponse(true)->withCookie($cookie);
    }

    /**
     * Logout
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return httpResponse(true,null,"Logged out");
    }

    /**
     * Get authenticated user
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        $data = [
            'name'       => auth()->user()->name,
            'email'      => auth()->user()->email,
            'is_admin'   => auth()->user()->is_admin
        ];
        return httpResponse(true,$data);
    }


}

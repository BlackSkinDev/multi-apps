<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RefreshTokenRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\PersonalAccessToken;
use App\Models\RefreshToken;
use App\Models\User;


class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        return successResponse(User::create($request->validated()));
    }

    public function login(LoginRequest $request)
    {

        $user = User::whereEmail($request->email)->first();

        if(!$user){
            return errorResponse("This email is not associated with any account");
        }

        if (! password_verify($request->password,$user->password)) {
            return errorResponse("Incorrect password");
        }

        $access_token = $user->createToken("auth-token");

        $cookie = cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);

        $refresh_token = RefreshToken::create(['personal_access_token_id' => $access_token->accessToken->id]);

        return successResponse([
            'name'          => $user->name,
            'email'         => $user->email,
            'refresh_token' => $refresh_token->token,
        ])->withCookie($cookie);

    }

    public function refreshToken(RefreshTokenRequest $request){

        $refresh_token = RefreshToken::where('token',$request->refresh_token)->first();

        if(!$refresh_token){
            return errorResponse("Invalid refresh token was detected!");
        }


        if($refresh_token->expired_at->lt(now())){
            $refresh_token->clear();
            return errorResponse("Refresh token has expired!");
        }

        $accessToken =  PersonalAccessToken::where('id',$refresh_token->personal_access_token_id)->first();

        $access_token = $accessToken->user->createToken("auth-token");

        $cookie = cookie('access_token', $access_token->plainTextToken, null, null, null, false, true);

        return successResponse()->withCookie($cookie);
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        return successResponse("Logged out");
    }

    public function user()
    {
        return successResponse([
            'name'  => auth()->user()->name,
            'email' => auth()->user()->email
        ]);
    }


}

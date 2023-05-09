<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Sign up an admin user
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        $user_data = array_merge($request->validated(),['is_admin'=>1]);
        $user = $this->authService->register($user_data);
        return httpResponse(true,$user);
    }

    /**
     * Sign in
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function show(LoginRequest $request): JsonResponse
    {
        $data  = $this->authService->login($request->validated());

        return httpResponse(true,array_diff_key($data, ['cookie' => null]))->withCookie($data['cookie']);
    }


    /**
     * Logout
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        $this->authService->logout();
        return httpResponse(true,[],"Logged out");
    }



}

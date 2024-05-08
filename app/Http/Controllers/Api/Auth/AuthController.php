<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
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
     * @throws ClientErrorException
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        return successResponse(UserResource::make($user));
    }

    /**
     * Sign in
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function show(LoginRequest $request): JsonResponse
    {
        $data  = $this->authService->loginWithPassword($request->validated());

        return successResponse($data);
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

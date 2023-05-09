<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RefreshTokenRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class RefreshTokenController extends Controller
{
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Refresh user access token
     * @param RefreshTokenRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function update(RefreshTokenRequest $request): JsonResponse
    {
        $cookie = $this->authService->refreshToken($request->refresh_token);

        return httpResponse(true)->withCookie($cookie);
    }
}

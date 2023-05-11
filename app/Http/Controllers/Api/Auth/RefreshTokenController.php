<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RefreshTokenRequest;
use App\Services\AuthService;
use App\Services\RefreshTokenService;
use Illuminate\Http\JsonResponse;

class RefreshTokenController extends Controller
{
    public function __construct(RefreshTokenService $refreshTokenService)
    {
        $this->refreshTokenService = $refreshTokenService;
    }

    /**
     * Refresh user access token
     * @param RefreshTokenRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function update(RefreshTokenRequest $request): JsonResponse
    {
        $cookie = $this->refreshTokenService->refreshToken($request->refresh_token);

        return httpResponse(true)->withCookie($cookie);
    }
}

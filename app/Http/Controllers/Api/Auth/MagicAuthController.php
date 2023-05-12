<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MagicLoginRequest;
use App\Http\Requests\Auth\MagicLoginTokenVerificationRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class MagicAuthController extends Controller
{
    public function __construct(AuthService $authService)
    {
        $this->authService                = $authService;
    }

    /**
     * Send Magic link
     * @param MagicLoginRequest $request
     * @return JsonResponse
     */
    public function store(MagicLoginRequest $request): JsonResponse
    {
       $this->authService->sendMagicLink($request->validated());

        return httpResponse(true);
    }

    /**
     * Verify magic link and login user
     * @param MagicLoginTokenVerificationRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function update(MagicLoginTokenVerificationRequest $request): JsonResponse
    {
        $data = $this->authService->loginWithMagicLink($request->token);
        return httpResponse(true,array_diff_key($data, ['cookie' => null]))->withCookie($data['cookie']);

    }

}

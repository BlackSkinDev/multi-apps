<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MagicLoginRequest;
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
     * @throws ClientErrorException
     */
    public function store(MagicLoginRequest $request): JsonResponse
    {
        $data  = $this->authService->loginWithMagicLink($request->validated());

        return httpResponse(true,array_diff_key($data, ['cookie' => null]))->withCookie($data['cookie']);
    }

}

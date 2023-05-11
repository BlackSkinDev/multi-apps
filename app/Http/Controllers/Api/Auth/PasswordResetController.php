<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordRequestLinkRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends Controller
{
    public function __construct(
        PasswordResetService $passwordResetService,
    )
    {
        $this->passwordResetService   = $passwordResetService;
    }

    /**
     * Send Password reset link
     * @param PasswordRequestLinkRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function store(PasswordRequestLinkRequest $request): JsonResponse
    {
        $this->passwordResetService->sendPasswordResetEmail($request->email);
        return httpResponse(true);
    }

    /**
     * Reset user password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function update(PasswordResetRequest $request): JsonResponse
    {
        $this->passwordResetService->updatePassword($request->validated());
        return httpResponse(true);
    }
}

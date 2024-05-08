<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendVerifyEmailRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Services\EmailVerificationService;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller
{
    public function __construct(
        EmailVerificationService $emailVerificationService,
    )
    {
        $this->emailVerificationService   = $emailVerificationService;
    }

    /**
     * Verify user email
     * @param VerifyEmailRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function update(VerifyEmailRequest $request): JsonResponse
    {
        $this->emailVerificationService->verifyEmail($request->token);
        return successResponse();
    }

    /**
     * resend verify email to user
     * @param ResendVerifyEmailRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function store(ResendVerifyEmailRequest $request): JsonResponse
    {
        $this->emailVerificationService->sendVerificationEmail($request->email);
        return successResponse();
    }
}

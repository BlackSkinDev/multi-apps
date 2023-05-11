<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendVerifyEmailRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Interfaces\IUserRepository;
use App\Services\EmailVerificationService;
use Illuminate\Http\JsonResponse;

class EmailVerificationTokenController extends Controller
{
    public function __construct(
        EmailVerificationService $emailVerificationService,
        IUserRepository          $userRepository
    )
    {
        $this->emailVerificationService   = $emailVerificationService;
        $this->userRepository             = $userRepository;
    }

    /**
     * Verify user email
     * @param VerifyEmailRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function show(VerifyEmailRequest $request): JsonResponse
    {
        $this->emailVerificationService->verifyEmail($request->token);
        return httpResponse(true);
    }

    /**
     * resend verify email to user
     * @param ResendVerifyEmailRequest $request
     * @return JsonResponse
     */
    public function store(ResendVerifyEmailRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByEmail($request->email);
        $this->emailVerificationService->sendVerificationEmail($user);
        return httpResponse(true);
    }
}

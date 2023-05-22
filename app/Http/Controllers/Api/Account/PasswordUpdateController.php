<?php

namespace App\Http\Controllers\Api\Account;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\PasswordUpdateRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;


class PasswordUpdateController extends Controller
{
    public function __construct(
        PasswordResetService $passwordResetService,
    )
    {
        $this->passwordResetService   = $passwordResetService;
    }


    /**
     * Reset user password
     * @param PasswordUpdateRequest $request
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function update(PasswordUpdateRequest $request): JsonResponse
    {
        $this->passwordResetService->changePassword($request->validated());
        return httpResponse(true);
    }
}

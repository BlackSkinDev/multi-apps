<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\Account\AccountResource;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * fetch  logged in user account info
     */
    public function show(): JsonResponse
    {
        $accountInfo = AccountResource::make(auth()->user());
        return httpResponse(true,$accountInfo);
    }

    /**
     * update  logged in user account info
     */
    public function update(AccountUpdateRequest $request): JsonResponse
    {
        $this->accountService->updateUserInfo($request->validated());
        return httpResponse(true);
    }
}

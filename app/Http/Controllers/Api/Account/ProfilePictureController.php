<?php

namespace App\Http\Controllers\Api\Account;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ProfilePictureUpdateRequest;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class ProfilePictureController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Update Profile Picture of logged in user
     * @throws ClientErrorException
     */
    public function update(ProfilePictureUpdateRequest $request): JsonResponse
    {
        $this->accountService->uploadProfilePicture($request->file);
        return httpResponse(true);
    }
}

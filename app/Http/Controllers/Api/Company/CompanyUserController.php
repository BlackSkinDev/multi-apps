<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\Company\CompanyUserProfileResource;
use App\Http\Resources\Company\CompanyUserResource;
use App\Models\User;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    /**
     * get users in logged in user company
     */
    public function index(): JsonResponse
    {
        $q= request('q');
        $users = $this->companyService->fetchUsers($q);
        return httpResponse(true,CompanyUserResource::collection($users));
    }

    /**
     * get a user in logged in user company
     */
    public function show($uuid): JsonResponse
    {
        $user = $this->companyService->fetchUserByUuid($uuid);
        return httpResponse(true,CompanyUserProfileResource::make($user));
    }

}

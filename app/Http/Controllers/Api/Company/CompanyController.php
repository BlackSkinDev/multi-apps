<?php

namespace App\Http\Controllers\Api\Company;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Company\CompanyUserResource;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;


class CompanyController extends Controller
{
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    /**
     * Create new user company
     * @throws ClientErrorException
     */
    public function store(CreateCompanyRequest $request): JsonResponse
    {
        $company = $this->companyService->createCompany($request->validated());
        return httpResponse(true,$company);
    }

    /**
     * Fetch logged in user company details
     */
    public function show()
    {
        $company = $this->companyService->fetchAuthUserCompany();
        return httpResponse(true,CompanyResource::make($company));
    }

    /**
     * Update user company.
     * @throws ClientErrorException
     */
    public function update(UpdateCompanyRequest $request): JsonResponse
    {
        $this->companyService->updateAuthUserCompany($request->validated());
        return httpResponse(true);
    }


}

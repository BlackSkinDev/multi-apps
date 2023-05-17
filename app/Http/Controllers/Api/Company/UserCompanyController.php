<?php

namespace App\Http\Controllers\Api\Company;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCompanyController extends Controller
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
     * Fetch user company details
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Update user company.
     */
    public function update(Request $request, Company $company)
    {
        //
    }


}

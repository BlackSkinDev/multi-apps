<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\ICompanyRepository;
use App\Interfaces\IUserRepository;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CompanyService
{
    public function __construct(
        ICompanyRepository  $companyRepository,
        FileService         $fileService,
        IUserRepository     $userRepository
    ) {
        $this->companyRepository  = $companyRepository;
        $this->fileService        = $fileService;
        $this->userRepository     = $userRepository;
    }

    /**
     * Create user company
     * @param array $data
     * @return Company
     * @throws ClientErrorException
     */
    public function createCompany(array $data): Company
    {
        $user = auth()->user();

        if ($user->company){
            throw  new ClientErrorException("You have already created your company!");
        }

        DB::beginTransaction();

        try {

            $logo = $this->fileService->uploadCompanyLogo($data['logo']);

            $companyData = [
                'name'          => $data['name'],
                'description'   => $data['description'],
                'logo'          => $logo
            ];

            $company =  $this->companyRepository->create($companyData);

            $this->userRepository->attachCompany($user,$company->id);

            DB::commit();

            return $company;

        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            throw new ClientErrorException(__('validation.error_occurred'));
        }

    }


    /**
     * Create user company
     * @return Company
     */
    public function fetchAuthUserCompany(): Company
    {
        return  $this->companyRepository->findById(auth()->user()->company_id);
    }

    /**
     * update user company
     * @param $data
     * @throws ClientErrorException
     */
    public function updateAuthUserCompany($data): void
    {
        DB::beginTransaction();

        try {
            $logo = "";

            if (isset($data['logo'])){
                $logo = $this->fileService->uploadCompanyLogo($data['logo']);
            }

            $companyData = [
                'name'          => $data['name'],
                'description'   => $data['description'],
            ];

            if ($logo){
                $companyData['logo'] = $logo;
            }

            $this->companyRepository->update(auth()->user()->company,$companyData);

            DB::commit();

        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            throw new ClientErrorException(__('validation.error_occurred'));
        }

    }




}

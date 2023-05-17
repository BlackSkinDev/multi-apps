<?php

namespace App\Interfaces;

use App\Models\Company;

interface ICompanyRepository
{
    public function create(array $data);
//    public function findById(Company $company);
//    public function delete(Company $token);
}

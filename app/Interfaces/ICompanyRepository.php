<?php

namespace App\Interfaces;

use App\Models\Company;

interface ICompanyRepository
{
    public function create(array $data);
    public function findById(int $id);
}

<?php

namespace App\Repositories;

use App\Interfaces\ICompanyRepository;
use App\Models\Company;

class CompanyRepository implements ICompanyRepository
{

    protected Company $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    /**
     * Create new user
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find company by id
     */
    public function findById(int $id)
    {
        return $this->model->where('id',$id)->first();
    }
}

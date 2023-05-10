<?php

namespace App\Repositories;

use App\Interfaces\IPersonalAccessTokenRepository;
use App\Models\PersonalAccessToken;

class PersonalAccessTokenRepository implements IPersonalAccessTokenRepository
{

    protected PersonalAccessToken $model;

    public function __construct(PersonalAccessToken $model)
    {
        $this->model = $model;
    }


    /**
     * Get access token by id
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

}

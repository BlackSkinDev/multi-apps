<?php

namespace App\Repositories;

use App\Models\PersonalAccessToken;

class PersonalAccessTokenRepository
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

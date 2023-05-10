<?php

namespace App\Repositories;

use App\Interfaces\IRefreshTokenRepository;
use App\Models\RefreshToken;

class RefreshTokenRepository implements IRefreshTokenRepository
{
    protected RefreshToken $model;

    public function __construct(RefreshToken $model)
    {
        $this->model = $model;
    }

    /**
     * Create new refresh token
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Get refresh token by token
     */
    public function findByToken(string $token)
    {
        return $this->model->where('token',$token)->first();
    }


}

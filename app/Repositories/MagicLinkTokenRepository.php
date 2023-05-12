<?php

namespace App\Repositories;

use App\Interfaces\IMagicLinkTokenRepository;
use App\Models\MagicLinkToken;

class MagicLinkTokenRepository implements IMagicLinkTokenRepository
{
    protected MagicLinkToken $model;

    public function __construct(MagicLinkToken $model)
    {
        $this->model = $model;
    }


    /**
     * create magic link token for a user
     */
    public function create($data)
    {
        return $this->model->create($data);
    }


}

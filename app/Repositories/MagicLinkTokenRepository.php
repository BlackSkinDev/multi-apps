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

    /**
     * get magic link record by token
     */
    public function findByToken(string $token)
    {
        return $this->model->where('token',$token)->first();
    }

    /**
     * delete magic link records that have been sent to a user
     */
    public function delete(MagicLinkToken $magicLinkToken)
    {
       $this->model->where('email',$magicLinkToken->email)->orWhere('token',$magicLinkToken->token)->delete();
    }


}

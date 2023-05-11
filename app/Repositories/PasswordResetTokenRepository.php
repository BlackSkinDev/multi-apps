<?php

namespace App\Repositories;

use App\Interfaces\IPasswordResetTokenRepository;
use App\Models\PasswordResetToken;

class PasswordResetTokenRepository implements IPasswordResetTokenRepository
{

    protected PasswordResetToken $model;

    public function __construct(PasswordResetToken $model)
    {
        $this->model = $model;
    }


    /**
     * Create password reset
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find a password reset token record by token
     */
    public function findByToken(string $token)
    {
        return $this->model->where('token',$token)->first();
    }

    /**
     * Delete password reset token
     */
    public function delete(PasswordResetToken $token)
    {
        return PasswordResetToken::where('email',$token->email)->delete();

    }


}

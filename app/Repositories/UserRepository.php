<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected User $model;

    public function __construct(User $model)
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
     * Find user by email
     */
    public function findByEmail(string $email):User
    {
        return $this->model->where('email',$email)->first();
    }

    /**
     * Update  user
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Delete  user
     */
    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}

<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class UserRepository implements IUserRepository
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
    public function findByEmail(string $email):User|null
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
    public function destroy(User $user): ?bool
    {
        return $user->delete();
    }

    /**
     * Verify user
     */
    public function verifyEmail(User $user): void
    {
          $user->update(['email_verified_at' => now()]);
    }

    /**
     * create  user token
     */
    public function createUserToken(User $user): NewAccessToken
    {
        return $user->createToken("auth-token");
    }

    /**
     * delete user tokens
     */
    public function deleteTokens(User $user): void
    {
        $user->tokens()->delete();
    }

}
